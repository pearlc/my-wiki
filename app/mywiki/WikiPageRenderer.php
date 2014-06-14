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
        $offset = 0;

        // 제목들 추출 :
        while (true) {

            $substr = $this->extract('[[', ']]', $text, $offset, true);

            $titleCandidate = trim(ltrim(rtrim($substr, ']]'), '[['));

            if ($substr === false) {
                break;
            }

            /**
             * 제목 후보에는 개행을 나타내는 문자가 포함되면 안됨. -> 일반 위키에는 <br/>, wiysiwyg 에는 </p>
             * 이런 글자가 포함된다면, 첫번째 표식인 '[[' 직후부터 다시 탐색 시작.
             */
            if (strpos($titleCandidate, '</p>', 0) !== false) {
                $offset += 2;
//                echo $offset;exit;
                continue;
            }


            $titleCandidate = $this->washingTitle($titleCandidate);

            /**
             * 또한 [[ 틀린 링크 ], [[ 맞는 링크 ]] 와 같은 경우도 처리해야함
             */

            if (!$this->isValid($titleCandidate)) {

                // 유효한 제목이 아닌 경우
                $offset += 2;
                continue;

            } else {
                $stringToReplace = link_to_route('wiki.page.show', $titleCandidate, [$titleCandidate]);
            }

            $placeHolder = microtime();

            $text = str_replace($substr, $placeHolder, $text);

            $placeHolders[$placeHolder] = [
                'rawstring' => $substr,
                'titleCandidate' => $titleCandidate,
                'stringToReplace' => $stringToReplace,
            ];

            $offset = strpos($text, $placeHolder, $offset);
        }

        // 실제 링크 치환
        foreach($placeHolders as $k => $v) {
            if ($v['stringToReplace'] !== false) {
                $text = str_replace($k, $v['stringToReplace'], $text);
            } else {
                $text = str_replace($k, $v['rawstring'], $text);
            }
        }

        $this->text = $text;
    }

    private function washingTitle($titleCandidate)
    {
        // TODO : 작은 따옴표, 큰 따옴표 문제 없는지 확인, 논리적으로 이상 없는지도 확인
        $titleCandidate = str_replace('&gt;', '>', $titleCandidate);
        $titleCandidate = str_replace('&lt;', '<', $titleCandidate);
        $titleCandidate = str_replace('&#39;', "'", $titleCandidate);
        return $titleCandidate;
    }

    private function isValid($titleCandidate)
    {
        return Page::isValidForTitle($titleCandidate);
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
        $this->internalLink();
        $this->html = $this->text;
    }

    public function getHtml()
    {
        return $this->html;
    }
}
