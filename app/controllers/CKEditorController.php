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

                // TODO : 현재는 이름을 클라이언트에서의 의름 그대로 쓰기 때문에 이름 충돌나는 경우에 대해 에러 처리 해야함 (걍 새로운 파일 제일 뒤에 (1) 같은 넘버링 하면 될듯)
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
                    //'maxsize' => 150*1024,   // 150KB
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
                    }
                }
            } catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
                $message = '알수 없는 사용자입니다.';  // autologin 기능 켜진 상태에서 유저가 삭제됬을 경우에 이 예외 발생
            } catch (Exception $e) {
                print_r($e);
//                $message = '알수 없는 오류가 발생했습니다.';
            }

        } else {
            $message = '로그인이 필요합니다.';
        }
        return "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($funcNum, '$fileUrl', '$message');</script>";
    }

}
