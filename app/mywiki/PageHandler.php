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
        // TODO : len 이라고 되있는 필드를 byte로 바꾸는게 어떨지?


        // TODO : 입력값에 대한 sql injection, xss 검사 필요

        $title = Input::get('title');
        $text = Input::get('text');
        $ip = Request::getClientIp();
        $len = strlen($text);
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
        $page->len = $len;
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
        $revision->len = $len;
        $revision->sha1 = $sha1;

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
        $pageChange->old_len = 0;
        $pageChange->new_len = $len;
        $pageChange->deleted = 0;


        $revision->save();
        $pageChange->save();

        $page->latest_revision()->associate($revision);
        $page->save();


        // 사진, 리소스등을 사용했다면 관련 db 업데이트
        /**
         *
         * 외부링크 : [http://naver.com 외부링크 제목]
         * 내부링크 : [[문서제목]]
         * 이미지 : <img>
         * 기타 위젯 : [[[ ]]] ??
         *
         */

        // page 저장
    }

    public function updatePageWithInput()
    {

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
