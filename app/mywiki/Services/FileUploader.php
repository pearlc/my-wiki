<?php
/**
 * Created by PhpStorm.
 * User: jinhochung
 * Date: 2014. 6. 28.
 * Time: 오후 6:11
 */

namespace mywiki\Services;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\URL;


class FileUploader {

    private $filters = null;

    private $file = null;

    public function __construct($file) {
        $this->file = $file;
    }

    /**
     * TODO : FileUploader 의 기능적인 책임은 어디까지인가?
     * 디렉토리 지정도 가능? 파일명 rename? 이런것들도 포함을 시켜야 하는가? <- 해당 부분이 공통적으로 사용될것 같다면 그러는게 맞을듯
     * 고민한 결과 : single responsibility 원칙에 의해, 디렉토리 지정 안함. 다만 파일명이 겹치는 경우에는 뒤에 (1) 형식으로 충돌 방지.
     *
     *
     * TODO : 모든 오류는 예외를 던지는 방식으로 처리할것
     *
     * 아래 코드를 참고해서 만듬
     * http://www.paulfp.net/blog/2010/10/how-to-add-and-upload-an-image-using-ckeditor/
     * http://maxoffsky.com/code-blog/uploading-files-in-laravel-4/
     */
    public function upload($destinationPath, $filename) {

        // TODO : 모든 취약점 검사 : 예를들어 path나 파일명에 ../../ 같은게 들어간 경우.. (파일명은 해결 됫음. path에 있을 경우만 해결하면 됨)

        $filename = $this->sanitizeFilename($filename);

        $file = $this->file;

        if ($file->isValid())
        {
            // 이름 충돌을 방지하기 위해 unique 한 이름 정하기
            $filename = $this->determineFilename( public_path() . '/' . $destinationPath, $filename);

            // 최종 저장
            $file->move(public_path() . '/' . $destinationPath, $filename);

            return URL::to($destinationPath. $filename);
        }
        return false;
    }

    /**
     * 파일 이름에 '../../' 등 들어간것 제거
     * @param $filename
     * @return mixed
     */
    protected function sanitizeFilename($filename)
    {
        $pathinfo = pathinfo($filename);
        return $pathinfo['basename'];
    }

    /**
     * @param $destinationPath : 절대경로로 받음
     * @param $filename
     * @return string
     */
    protected function determineFilename($destinationPath, $filename)
    {
        /**
         *
         * TODO : 성능상 문제 있는 로직
         *
         * 동일한 파일명이 계속 입력될 경우, 루프 한번당 계속해서 파일에 접근하기 때문에 성능상의 문제가 발생할수 있고, 악의적으로 이용할경우 거의 무한에 가까운 루프를 돌수 있음.
         *
         */
        $resetMagicNumber = 1000;



        if ( ! File::exists($destinationPath . '/' . $filename) ) {
            return $filename;
        }

        $pathinfo = pathinfo($destinationPath . '/' . $filename);

        $pathinfoFilename = $pathinfo['filename'];
        $pathinfoExtension = $pathinfo['extension'];

        $i = 1;
        while(true) {
            $nameCandidate = $pathinfoFilename . ' ' . $i . '.' .$pathinfoExtension;
            if ( ! File::exists($destinationPath . '/' . $nameCandidate) ) {
                break;
            }
            $i++;

            if ($i >= $resetMagicNumber) {
                $pathinfoFilename = $pathinfoFilename . '_';
                $i = 1;
            }
        }
        return $nameCandidate;
    }
}
