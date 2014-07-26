<?php
/**
 * Created by PhpStorm.
 * User: jinhochung
 * Date: 2014. 6. 28.
 * Time: 오후 12:07
 */

class CKEditorController extends BaseController
{
    public function fileUpload()
    {
        $funcNum = Input::get('CKEditorFuncNum');
        $fileUrl = '';
        $message = '';

        $user = Sentry::getUser();

        if ($user) {

            try {
                $file = Input::file('upload');
                $validator = new \mywiki\Services\FileUploadValidator($file, [
                    'mimetype' => [
                        'image/gif',
                        'image/jpeg',
                        'image/png'
                    ],
                    'extension' => [
                        'gif',
                        'jpg',
                        'jpeg',
                        'png',
                    ],
                    'maxsize' => 1*1024*1024,   // 1MB
                ]);

                if ($validator->fails()) {
                    foreach($validator->errors as $v) {
                        $message .= $v;
                    }
                } else {
                    $fileUploader = new \mywiki\Services\FileUploader($file);
                    $path = 'uploads/users/' . $user->id . '/';    // 각 유저별로 업로드 디렉토리 분리
                    $filename = $file->getClientOriginalName();

                    $fileUrl = $fileUploader->upload($path, $filename);

                    if ($fileUrl === false) {
                        // 업로드 실패 (파일 이름이 올바르지 않음)

                        // Do something
                        $message = '파일 이름이 올바르지 않습니다.';
                    }
                }
            } catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
                $message = '알수 없는 사용자입니다.';  // autologin 기능 켜진 상태에서 유저가 삭제됬을 경우에 이 예외 발생
            } catch (Exception $e) {
                $message = '알수 없는 오류가 발생했습니다.';
            }

        } else {
            $message = '로그인이 필요합니다.';
        }
        return "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($funcNum, '$fileUrl', '$message');</script>";
    }

}
