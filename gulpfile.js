
/**
 * 참고 url
 * 라라캐스트 : https://laracasts.com/lessons/laravel-and-gulp
 * sitepoint : http://www.sitepoint.com/introduction-gulp-js/
 * uncss관련 addy osmani 글 : http://addyosmani.com/blog/removing-unused-css/
 */

var gulp = require('gulp');
var gutil = require('gulp-util');
var notify = require('gulp-notify');
var sass = require('gulp-ruby-sass');
var autoprefix = require('gulp-autoprefixer');
var exec = require('child_process').exec;
var sys = require('sys');
var concat = require('gulp-concat');
var stripDebug = require('gulp-strip-debug');
var uglify = require('gulp-uglify');
var jshint = require('gulp-jshint');
var changed = require('gulp-changed');
var imagemin = require('gulp-imagemin');
var less = require('gulp-less');
var minify = require('gulp-minify-css');

var srcPath = {
    css: ['app/assets/bootstrap-3.1.1/dist/css/bootstrap.min.css', 'app/assets/themes/slate/bootstrap.css', 'app/assets/css/**/*.css'],
    scripts: ['app/assets/js/**/*.js', 'app/assets/bootstrap-3.1.1/dist/js/bootstrap.min.js'],
    ckeditor: 'app/assets/ckeditor-4.4.0/**/*.*',
    jshint: 'app/assets/js/**/*.js',
    images: 'app/assets/images/**/*',
    phpunit: 'app/**/*.php'
}

var destPath = {
    css: 'public/assets/css',
    scripts: 'public/assets/js/',
    ckeditor: 'public/assets/ckeditor',
    images: 'public/assets/images'
}

//gulp.task('less', function() {
//    return gulp.src(srcPath.less)
//        .pipe(less())
//        .pipe(gulp.dest('public/css'));
//});


gulp.task('css', function() {

    return gulp.src(srcPath.css)
        .pipe(autoprefix('last 10 version'))
        .pipe(concat('all.css'))
        .pipe(gulp.dest(destPath.css))
        .pipe(concat('all.min.css'))
        .pipe(minify({keepSpecialComments: 0}))
        .pipe(gulp.dest(destPath.css))
        .pipe(notify('CSS compiled, prefixed, and minified'));

//    return gulp.src(sassDir + '/main.sass')
//        .pipe(sass({ style: 'compressed' }).on('error', gutil.log))
//        .pipe(autoprefix('last 10 version'))
//        .pipe(gulp.dest(destPath.css))
//        .pipe(notify('CSS compiled, prefixed, and minified'));
});


gulp.task('phpunit', function() {
    exec('phpunit', function(error, stdout) {
        sys.puts(stdout);
    });
});


gulp.task('jshint', function() {
    gulp.src(srcPath.jshint)
        .pipe(jshint())
        .pipe(jshint.reporter('default'));
});


gulp.task('images', function() {
    gulp.src(srcPath.images)
        .pipe(changed(destPath.images))
        .pipe(imagemin().on('error', gutil.log))
        .pipe(gulp.dest(destPath.images));
});


gulp.task('scripts', function() {
    gulp.src(srcPath.scripts)
        .pipe(concat('all.js'))      // 일단 concat 만 실행하고 raw 파일 출력
        .pipe(gulp.dest(destPath.scripts))
        .pipe(concat('all.min.js'))
        .pipe(stripDebug())
        .pipe(uglify())
        .pipe(gulp.dest(destPath.scripts));  // stripDebug, uglify 실행후 prod 버전 출력
});


gulp.task('editor', function() {
    gulp.src(srcPath.ckeditor)
        .pipe(gulp.dest(destPath.ckeditor));
});


gulp.task('watch', function() {
    gulp.watch(srcPath.css, ['css']).on('error', gutil.log);    // 디렉토리 이름이 바뀌면 특정 상황에서 오류 뱉어냄
    gulp.watch(srcPath.scripts, ['scripts']).on('error', gutil.log);  // 디렉토리 이름이 바뀌면 특정 상황에서 오류 뱉어냄
    gulp.watch(srcPath.images, ['images']).on('error', gutil.log);  // 디렉토리 이름이 바뀌면 특정 상황에서 오류 뱉어냄
//    gulp.watch(srcPath.phpunit, ['phpunit']);
});


gulp.task('default', ['css', 'scripts', 'images', 'editor', /* 'phpunit', */ 'watch']);