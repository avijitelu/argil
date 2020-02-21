var gulp = require('gulp');
var sourcemaps = require('gulp-sourcemaps');
var sass = require('gulp-sass');
var concat = require('gulp-concat');
var minify = require('gulp-minify');
var rename = require('gulp-rename');
var uglify = require('gulp-uglify');
var pump = require('pump');

// Compile SASS to CSS with compressed
gulp.task('sass', function() {
    return gulp.src('public/assets/dev/sass/*.scss')
            .pipe(sass({
                outputStyle: 'compressed',
                errLogToConsole: true
            }).on('error', sass.logError))
            .pipe(gulp.dest('public/assets/build/css/'));
});

// Generate source map for SASS file
gulp.task('sm', function() {
    return gulp.src('public/assets/dev/sass/*.scss')
            .pipe(sourcemaps.init())
                .pipe(sass({
                    outputStyle: 'compressed',
                    errLogToConsole: true
                }).on('error', sass.logError))
            .pipe(sourcemaps.write('.'))
            .pipe(gulp.dest('public/assets/build/css/'));
});

// Create single js file
gulp.task('script', function() {
    pump([
        gulp.src('public/assets/dev/js/**/*.js'),
        uglify(),
        rename({suffix: ".min"}),
        gulp.dest('public/assets/build/js/')
    ])
});

// Watch the sm gulp task
gulp.task('watch', function() {
    gulp.watch('public/assets/dev/sass/**/*.scss', ['sass']);
    gulp.watch('public/assets/dev/js/**/*.js', ['script']);
});