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


    /**
     * text 내에 있는 '내부 링크' 들을 a 태그로 변경
     * @return mixed|string
     */
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
        $placeHolders = [];

        // 제목들 추출
        while (true) {
            $substr = $this->extract('[[', ']]', $text, 0, true);

            $titleCandidate = trim(ltrim(rtrim($substr, ']]'), '[['));

            if ($substr === false) {
                break;
            }

            $placeHolder = microtime();

            $text = str_replace($substr, $placeHolder, $text);

            $placeHolders[$placeHolder] = [
                'rawstring' => $substr,
                'titleCandidate' => $titleCandidate,
                'stringToReplace' => false,
            ];
        }

        // 각각에 대해 유효한 제목인지 확인
        foreach($placeHolders as $k => $v) {
            $titleCandidate = $v['titleCandidate'];

            if (Page::isValidForTitle($titleCandidate)) {
                $stringToReplace = link_to_route('wiki.page.show', $titleCandidate, [$titleCandidate]);
                $placeHolders[$k]['stringToReplace'] = $stringToReplace;
            }
        }

        // 실제 링크 치환
        foreach($placeHolders as $k => $v) {
            if ($v['stringToReplace'] !== false) {
                $text = str_replace($k, $v['stringToReplace'], $text);
            } else {
                $text = str_replace($k, $v['rawstring'], $text);
            }
        }

        return $text;
    }

    private function extract($pointer1, $pointer2, $haystack, $offset = 0, $signInlcude = false)
    {
        $p1 = strpos($haystack, $pointer1, $offset);
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
