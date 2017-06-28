/**
 * Created by iibarguren on 6/26/17.
 */

/**
 * Created by iibarguren on 3/13/17.
 */

var gulp = require('gulp'),
  concat = require('gulp-concat'),
  cssnext = require('postcss-cssnext'),
  cssnano = require('gulp-cssnano'),
  livereload = require('gulp-livereload'),
  modernizr = require('gulp-modernizr'),
  merge = require('merge-stream'),
  plumber = require('gulp-plumber'),
  rename = require('gulp-rename'),
  del = require('del'),
  uglify = require('gulp-uglify'),
  notify = require("gulp-notify"),
  minify = require('gulp-minify'),
  bower = require('gulp-bower'),
  babel = require('gulp-babel');

var config = {
  bowerDir: './bower_components'
};

var paths = {
  npm: './node_modules',
  js: './app/Resources/assets/js',
  svg: './app/Resources/assets/svg',
  buildCss: './web/cssagenda21',
  buildJs: './web/jsagenda21',
  buildSvg: './web/svg'
};

myFonts = [
  config.bowerDir + '/font-awesome/fonts/**.*',
  config.bowerDir + '/bootstrap/fonts/**.*'
];

myCss = [
  config.bowerDir + '/bootstrap/dist/css/bootstrap.min.css',
  config.bowerDir + '/bootstrap/dist/css/bootstrap-theme.min.css',
  config.bowerDir + '/font-awesome/css/font-awesome.min.css'
];

myJs = [
  config.bowerDir + '/jquery/dist/jquery.min.js',
  config.bowerDir + '/bootstrap/dist/js/bootstrap.min.js',
  config.bowerDir + '/bootstrap/js/**.*'
];


function onError(err) {
  console.log(err);
  this.emit('end');
}

gulp.task('bower', function () {
  return bower()
    .pipe(gulp.dest(config.bowerDir))
});

gulp.task('clean', function () {
  return del([
    'web/cssagenda21/*',
    'web/jsagenda21/*',
    'web/fontsagenda21/*'
  ]);
});

gulp.task('icons', function () {
  return gulp.src(myFonts)
    .pipe(gulp.dest('./web/fontsagenda21'));

});

// CSS
gulp.task('css:prod', function () {
  return merge (
    gulp.src(myCss)
      .pipe(cssnano({keepSpecialComments: 1,rebase: false}))
  ).pipe(concat('app.min.css')).pipe(gulp.dest(paths.buildCss));
});


// JS
gulp.task('js:prod', function () {
  return gulp.src(myJs)
    .pipe(babel({presets: ['es2015']}))
    .pipe(minify())
    .pipe(concat('app.min.js'))
    .pipe(gulp.dest('web/jsagenda21/'));
});


gulp.task('default', ['clean', 'icons', 'js:prod', 'css:prod']);

