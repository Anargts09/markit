var gulp = require('gulp');
var $    = require('gulp-load-plugins')();
var uglify = require("gulp-uglify");
var autoprefixer = require("gulp-autoprefixer");

var sassPaths = [
  'bower_components/foundation-sites/scss',
  'bower_components/motion-ui/src'
];

gulp.task('sass', function() {
  return gulp.src('./src/scss/**/*.scss')
    .pipe($.sass({
      includePaths: sassPaths
    })
    .on('error', $.sass.logError))
    .pipe($.autoprefixer({
      browsers: ['last 2 versions', 'ie >= 9']
    }))
    .pipe(autoprefixer())
    .pipe($.sass({outputStyle: 'compressed'}))
    .pipe(gulp.dest('css'));
});

gulp.task("js", function() {
    gulp.src(["./src/js/**/*.js","!js/min/**/*.js"])
        .pipe(uglify())
        .pipe(gulp.dest("js/min"));
});

gulp.task('default', function(){
  gulp.watch("./src/scss/**/*.scss" , ['sass']);
  gulp.watch("./src/js/**/*.js" , ['js']);
});
