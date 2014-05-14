## Laravel PHP Framework

[![Latest Stable Version](https://poser.pugx.org/laravel/framework/version.png)](https://packagist.org/packages/laravel/framework) [![Total Downloads](https://poser.pugx.org/laravel/framework/d/total.png)](https://packagist.org/packages/laravel/framework) [![Build Status](https://travis-ci.org/laravel/framework.png)](https://travis-ci.org/laravel/framework) [![License](https://poser.pugx.org/laravel/framework/license.png)](https://packagist.org/packages/laravel/framework)

## Dependencies
1. php 5.5 (MAMP 로 설치한 경우 php -v 로 확인해서 php cli 경로 제대로 가리키고 있는지 확인)
2. composer
3. sentry2 (composer 로 자동 다운됨)
4. gulp
5. ckeditor


## 코드 다운로드
프로젝트 생성 : git clone ~~~


## composer 설치
http://code.tutsplus.com/tutorials/easy-package-management-with-composer--net-25530

## composer install
문제 발생시 php 5.5.10 제대로 설치 되있는지 확인 

http://stackoverflow.com/questions/16830405/laravel-requires-the-mcrypt-php-extension

## php dependency 설치
1. 프로젝트 디렉토리에서 명령어 실행 : composer install


## gulp를 위해 node.js설치
http://nodejs.org/download/ 

이후 생략


## gulp 설치
참고 : http://www.sitepoint.com/introduction-gulp-js/

1. global 영역에 gulp를 설치하기 위해 관리자 권한 획득 후 명령어 실행 : npm install gulp -g
2. 프로젝트 local 영역에 gulp를 설치하기 위해 프로젝트 디렉토리로 이동해 명령어 실행 (이러면 node_modules 폴더가 생김) : npm install gulp --save-dev
3. package.json 의 dependencies를 설치하기 위해 명령어 실행 : npm install


## sentry migration
1. sentry 관련 db migration 명령어 실행 : php artisan migrate --package=cartalyst/sentry


## my-wiki db migration 
1. my-wiki 관련 db migration 명령어 실행 : php artisan migrate

