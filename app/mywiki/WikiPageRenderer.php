<?php

namespace mywiki;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;
use Sentry;
use Page;
use Revision;
use PageChange;


class WikiPageRenderer {

    private $page = null;

    private $text = '';

    /**
     * 최종 출력될 html
     * @var string
     */
    private $html = '';

    public function __construct($page)
    {
        $this->page = $page;

        $this->text = $this->page->latest_revision->text;
    }

    public function internalLink()
    {

        /**
         *
         * 형식에 맞는 문자열 뽑기 (콜백 필요)
         * 원하는 최종 결과물 획득 (콜백 필요)
         * 뽑은 문자열을 최종 결과물로 replace
         *
         * 각 위젯별로 필요한것? 이 위젯이라는것을 판단하는 identifier, 파서(파싱해서 object화 까지), 결과 html 생성코드
         *
         */

        $text = $this->text;

        while(true) {

            $title = $this->extract('[[', ']]', $text, false);

            if ($title === false) {
                break;
            }

            // todo : 존재하지 않는 문서일 경우 style 다르게 처리
            $linkHtml = link_to_route('wiki.page.show', $title, [$title]);

            // todo : [[ 와 제목 사이에 빈칸이 있는 경우 해결
            $text = str_replace('[[' . $title . ']]', $linkHtml, $text);
        }

        return $text;
    }

    private function extract($pointer1, $pointer2, $haystack, $signInlcude = false)
    {
        $p1 = strpos($haystack, $pointer1);
        $str = false;

        if ($p1 !== false) {
            $p2 = strpos($haystack, $pointer2, $p1 + strlen($pointer1));

            if ($p2 !== false) {
                if ($signInlcude) {
                    $str = substr($haystack, $p1, $p2 - $p1 + strlen($pointer2) );
                } else {
                    $str = substr($haystack, $p1 + strlen($pointer1), $p2 - ($p1 + strlen($pointer1)) );
                }
            }
        }

        return $str;
    }

    public function render()
    {
        $this->html = $this->internalLink();
    }

    public function getHtml()
    {
        return $this->html;
    }
}
