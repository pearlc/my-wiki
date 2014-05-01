
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

var sassDir = 'app/assets/sass';
var targetCssDir = 'public/assets/css';

var path = {
    css: ['app/assets/bootstrap-3.1.1/dist/css/bootstrap.min.css', 'app/assets/themes/slate/bootstrap.css', 'app/assets/css/**/*.css'],
    scripts: ['app/assets/js/**/*.js', 'app/assets/bootstrap-3.1.1/dist/js/bootstrap.min.js']
}

//gulp.task('less', function() {
//    return gulp.src(path.less)
//        .pipe(less())
//        .pipe(gulp.dest('public/css'));
//});

gulp.task('css', function() {

    return gulp.src(path.css)
        .pipe(autoprefix('last 10 version'))
        .pipe(concat('all.css'))
        .pipe(gulp.dest(targetCssDir))
        .pipe(concat('all.min.css'))
        .pipe(minify({keepSpecialComments: 0}))
        .pipe(gulp.dest(targetCssDir))
        .pipe(notify('CSS compiled, prefixed, and minified'));

//    return gulp.src(sassDir + '/main.sass')
//        .pipe(sass({ style: 'compressed' }).on('error', gutil.log))
//        .pipe(autoprefix('last 10 version'))
//        .pipe(gulp.dest(targetCssDir))
//        .pipe(notify('CSS compiled, prefixed, and minified'));
});


gulp.task('phpunit', function() {
    exec('phpunit', function(error, stdout) {
        sys.puts(stdout);
    });
});


gulp.task('jshint', function() {
    gulp.src('app/assets/js/**/*.js')
        .pipe(jshint())
        .pipe(jshint.reporter('default'));
});


gulp.task('imagemin', function() {
    var imgSrc = 'app/assets/images/**/*',
        imgDst = 'public/assets/images';

    gulp.src(imgSrc)
        .pipe(changed(imgDst))
        .pipe(imagemin())
        .pipe(gulp.dest(imgDst));
});



gulp.task('scripts', function() {

    gulp.src(path.scripts)
        .pipe(concat('all.js'))      // 일단 concat 만 실행하고 raw 파일 출력
        .pipe(gulp.dest('public/assets/js/'))
        .pipe(concat('all.min.js'))
        .pipe(stripDebug())
        .pipe(uglify())
        .pipe(gulp.dest('public/assets/js/'));  // stripDebug, uglify 실행후 prod 버전 출력

//    gulp.src(['./src/scripts/lib.js','./src/scripts/*.js'])
//        .pipe(concat('script.js'))
//        .pipe(stripDebug())
//        .pipe(uglify())
//        .pipe(gulp.dest('./build/scripts/'));
});



gulp.task('watch', function() {
    gulp.watch(path.css, ['css']);

    gulp.watch(path.scripts, ['scripts']);

    gulp.watch('app/**/*.php', ['phpunit']);
});


gulp.task('default', ['css', 'scripts', 'phpunit', 'watch']);