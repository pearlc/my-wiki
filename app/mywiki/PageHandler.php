<?php
/**
 * Created by PhpStorm.
 * User: jinhochung
 * Date: 2014. 5. 18.
 * Time: 오후 7:02
 */

namespace mywiki;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;
use Sentry;
use Page;
use Revision;
use PageChange;

class PageHandler {

    protected $page = null;

    function __contruct() {

    }

    function createPageWithInput($input)
    {
        // TODO : 입력값에 대한 sql injection, xss 검사 필요

        // TODO : 이 함수가 실행되는 과정에서 발생할수 있는 에러들 파악. 에러 처리

        $title = Input::get('title');
        $text = Input::get('text');
        $ip = Request::getClientIp();
        $bytes = strlen($text);
        $sha1 = sha1($text);


        /**
         *
         * https://laracasts.com/lessons/responsibility
         *
         *
         *
         */


        /**
         *
         *
         * 1. page 에 entry 추가
         *      - page_changes 에 entry 추가
         *      - 사진, 리소스등을 사용했다면 관련 db도 업데이트
         *
         * 2. 로그인 했다면 관련 유저 정보도 업데이트 (어떤걸 업데이트하지?)
         *
         */

        try
        {
            $user = Sentry::getUser();
        }
        catch (\Cartalyst\Sentry\Users\UserNotFoundException $e)
        {
            // 'remember me' 선택한 상태에서 유저가 삭제된 경우
            // TODO : 추가로 해줘야할 작업이 있나? 쿠키 삭제?
            $user = null;
        }



        // page 생성
        $page = new Page();
        $page->namespace = 1;
        $page->title = $title;
        $page->counter = 0;
        $page->is_redirected = 0;
        $page->is_new = 1;
        $page->bytes = $bytes;
        $page->random = 0;  // TODO : page 테이블의 random 필드가 꼭 필요한 필드인가? 걍 실시간 랜덤 번호 생성해서 id에 가장 근접한애 뽑으면 될거 같은데
        //$page->touched_at = '';   // TODO : 생성시 제대로 update 되는지 확인

        $page->save();


        // revision 생성
        $revision = new Revision();
        $revision->page()->associate($page);
        $revision->text = $text;
        $revision->comment = '';    // TODO : 미구현
        if ($user !== null) $revision->user()->associate($user);
        $revision->ip = $ip;
        $revision->deleted = 0;
        $revision->bytes = $bytes;
        $revision->parent_revision_id = null;
        $revision->sha1 = $sha1;
        $revision->save();

        // page_changes 에 entry 추가
        $pageChange = new PageChange();
        $pageChange->page()->associate($page);
        if ($user !== null) $pageChange->user()->associate($user);
        $pageChange->namespace = Page::NAMESPACE_MAIN;
        $pageChange->title = $title;
        $pageChange->comment = '';  // TODO : 미구현
        $pageChange->bot = '';  // TODO : 미구현
        $pageChange->type = PageChange::PC_NEW;
        $pageChange->ip = $ip;
        $pageChange->old_bytes = 0;
        $pageChange->new_bytes = $bytes;
        $pageChange->deleted = 0;
        $pageChange->save();

        $page->latest_revision()->associate($revision);
        $page->save();


        // TODO : 사진, 리소스등을 사용했다면 관련 db 업데이트
        /**
         *
         * 외부링크 : [http://naver.com 외부링크 제목]
         * 내부링크 : [[문서제목]]
         * 이미지 : <img>
         * 기타 위젯 : [[[ ]]] ??
         *
         */

        return $page;
    }

    public function updatePageWithInput($input)
    {
        $title = Input::get('title');
        $text = Input::get('text');
        $ip = Request::getClientIp();
        $bytes = strlen($text);
        $sha1 = sha1($text);

        try
        {
            $user = Sentry::getUser();
        }
        catch (\Cartalyst\Sentry\Users\UserNotFoundException $e)
        {
            // 'remember me' 선택한 상태에서 유저가 삭제된 경우
            // TODO : 추가로 해줘야할 작업이 있나? 쿠키 삭제?
            $user = null;
        }

        // TODO : 해당 문서 title이 db에 없다면 에러처리
        // TODO : 이름 바꾸는 기능이 들어갔을때, 한 유저가 편집중에 다른유저가 이름을 바꾸는 경우에는 어떻게 오류 판단하는가?


        $page = Page::with('latest_revision')->where('title', $title)->first();
        $oldRevision = $page->latest_revision;

        // TODO : 충돌검사. 문제 있다면 충돌 해결하는 ui 뿌려줌

        /**
         * revision 업데이트
         * page changes 업데이트
         * page 업데이트
         */


        // TODO : revision/pageChanges manager(혹은 handler) 같은걸 만들어야 할듯. delete나 이름 변경시 코드 재사용해서 사용할수 있게
        // revision 생성
        $newRevision = new Revision();
        $newRevision->page()->associate($page);
        $newRevision->text = $text;
        $newRevision->comment = '';    // TODO : 미구현
        if ($user !== null) $newRevision->user()->associate($user);
        $newRevision->ip = $ip;
        $newRevision->deleted = 0;
        $newRevision->bytes = $bytes;
        $newRevision->parent_revision_id = $oldRevision->id;
        $newRevision->sha1 = $sha1;
        $newRevision->save();

        // page_changes 에 entry 추가
        $pageChange = new PageChange();
        $pageChange->page()->associate($page);
        if ($user !== null) $pageChange->user()->associate($user);
        $pageChange->namespace = Page::NAMESPACE_MAIN;
        $pageChange->title = $title;
        $pageChange->comment = '';  // TODO : 미구현
        $pageChange->bot = '';  // TODO : 미구현
        $pageChange->type = PageChange::PC_NEW;
        $pageChange->ip = $ip;
        $pageChange->old_bytes = $oldRevision->bytes;
        $pageChange->new_bytes = $bytes;
        $pageChange->deleted = 0;
        $pageChange->save();

        // page update
        $page->latest_revision()->associate($newRevision);
        $page->bytes = $newRevision->bytes;
        // $page->touched_at = '';  // todo : touched_at 이거 자동 혹은 어떤 방식으로 업뎃? : 꼭 필요한 필드인지도 생각해볼것
        $page->save();

        return $page;
    }

    public function updateRelatedMedia()
    {

    }

    /**
     * 문서에 이미지, 표 등 미디어 사용 탐지하는 함수
     */
    public function detectMedia()
    {
        return '';
    }

    public function updateUploadedFiles()
    {

    }

    public function updateExternalLink()
    {

    }

    public function updatePageLink()
    {

    }


} 
