<?php
/**
 * Created by PhpStorm.
 * User: jinhochung
 * Date: 2014. 7. 6.
 * Time: 오후 3:34
 */

namespace mywiki\Services;


class FileUploadValidator {

    protected $success = null;

    public $errors = [];

    protected $file;

    protected $rules;

    public function __construct($file, $rules)
    {
        $this->file = $file;
        $this->rules = $rules;
    }

    protected function validate()
    {
        $errors = [];

        foreach($this->rules as $k => $v) {
            switch($k) {
                case 'mimetype':
                    $r = $this->mimeTypeValidate($v);
                    if ($r !== true) {
                        $errors[] = '허용된 파일 형식이 아닙니다.';
                    }
                    break;

                case 'maxsize':
                    $r = $this->maxsizeValidate($v);
                    if ($r !== true) {
                        $errors[] = '최대 ' . number_format($v/1024/1024, 2) . 'MB까지만 허용됩니다.';
                    }
                    break;

                case 'extension':
                    $r = $this->extensionValidate($v);
                    if ($r !== true) {
                        $errors[] = '허용된 확장자가 아닙니다.';
                    }
                    break;

                default:
                    $errors[] = '알수 없는 필터입니다.';
                    break;
            }
        }
        $this->errors = $errors;

        if (count($errors) === 0) {
            $this->success = true;
        } else {
            $this->success = false;
        }
    }

    protected function mimeTypeValidate($allowedMimeType)
    {
        $file = $this->file;

        if (!is_array($allowedMimeType)) {
            $allowedMimeType = [$allowedMimeType];
        }

        if (in_array($file->getMimeType(), $allowedMimeType) ) {
            return true;
        } else {
            return false;
        }
    }

    protected function extensionValidate($allowedExtensions)
    {
        $file = $this->file;

        if (!is_array($allowedExtensions)) {
            $allowedExtensions = [$allowedExtensions];
        }

        if (in_array($file->getClientOriginalExtension(), $allowedExtensions)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param $allowedSize Byte
     */
    protected function maxsizeValidate($maxSize)
    {
        $file = $this->file;

        if ($file->getSize() <= $maxSize) {
            return true;
        }
        return false;
    }


    public function passes()
    {
        if ($this->success === null) {
            $this->validate();
        }

        return $this->success;
    }

    public function fails()
    {
        if ($this->success === null) {
            $this->validate();
        }
        return !$this->success;
    }
} 
