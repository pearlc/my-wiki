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


## 이메일 발송에 사용될 계정 id / pw 등록
1. php.ini 파일의 include_path 경로에 'my-wiki-classified.php' 파일 생성
2. 아래와 같이 변수 설정

```php
<?php
define('MY_WIKI_EMAIL_ACCOUNT', '');
define('MY_WIKI_EMAIL_PASSWORD','');
```

## gulp 실행
`$ gulp`

## Environment 설정법
1. 아래 3개 환경이 있다고 가정 (개별 환경 추가 가능)
  1. development <- default
  2. testing
  3. production
2. environment 변수를 통해 판단하므로 아래와 같이 apache 설정을 해주거나

	`SetEnv ENV development`
3. 이렇게 php 코드로 선언해주어야함

  `$_ENV["FOO"] = 'bar';`
