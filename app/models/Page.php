<?php
/**
 * Created by PhpStorm.
 * User: jinhochung
 * Date: 2014. 5. 18.
 * Time: 오전 1:28
 */


class Page extends Eloquent {

    /**
     * 네임스페이스를 여기다 정의하는것이 옳은가?
     *
     *
     *
     *
     *
     *
     *
     *
     * define( 'NS_MEDIA', -2 );
    define( 'NS_SPECIAL', -1 );

     *
    define( 'NS_MAIN', 0 );
    define( 'NS_TALK', 1 );
    define( 'NS_USER', 2 );
    define( 'NS_USER_TALK', 3 );
    define( 'NS_PROJECT', 4 );
    define( 'NS_PROJECT_TALK', 5 );
    define( 'NS_FILE', 6 );
    define( 'NS_FILE_TALK', 7 );
    define( 'NS_MEDIAWIKI', 8 );
    define( 'NS_MEDIAWIKI_TALK', 9 );
    define( 'NS_TEMPLATE', 10 );
    define( 'NS_TEMPLATE_TALK', 11 );
    define( 'NS_HELP', 12 );
    define( 'NS_HELP_TALK', 13 );
    define( 'NS_CATEGORY', 14 );
    define( 'NS_CATEGORY_TALK', 15 );
     *
     */

    const NAMESPACE_MAIN = 0;
    const NAMESPACE_TALK = 1;
    const NAMESPACE_USER = 2;
    const NAMESPACE_USER_TALK = 3;
    const NAMESPACE_PROJECT = 4;
    const NAMESPACE_PROJECT_TALK = 5;
    const NAMESPACE_FILE = 6;
    const NAMESPACE_FILE_TALK = 7;

    protected $fillable = ['id', 'namespace', 'title', 'counter', 'is_redirected', 'is_new', 'latest_revision_id', 'bytes', 'random', 'touched_at'];

    protected static $validatorErrors;


    public function page_changes()
    {
        return $this->hasMany('PageChange');
    }

    public function revisions()
    {
        return $this->hasMany('Revision');
    }

    public function latest_revision()
    {
        return $this->belongsTo('Revision');
    }


    /**
     * TODO : 문서 제목 (혹은 검색시) 필터링 함수
     *
     * 두가지 형태의 필터링이 필요할듯 :
     *  1. 제목에 사용할수 없는 문자 필터링 (여기도 두가지가 필요할듯. 검색에서 아예 무시할 개행문자 같은 것들, 혹은 본문에는 삽입 가능하고 검색도 가능한 특수문자)
     *  2. 제목에서 사용가능한 문자로면 구성된 string 으로 변환하는 함수
     */


    /**
     * TODO : 입력된 title을 저장(혹은 출력)될수있는 제목 형식에 맞게 변형시키는 메서드
     *
     */
    public static function sanitizeForTitle($title)
    {
        return $title;
    }

    public static function isValidForCreation($input)
    {

        $validator = Validator::make($input, [
            'title' => 'required|unique:pages',
            'text' => 'required'
        ]);

        self::$validatorErrors = $validator->errors();

        return $validator->passes();
    }

    public static function getErrors()
    {
        return self::$validatorErrors;
    }
}
