'use strict';

var gulp = require('gulp'),

    // Sass/CSS processes
    autoprefixer = require('autoprefixer'),
    bourbon = require('bourbon').includePaths,
    cssMinify = require('gulp-cssnano'),
    mqpacker = require('css-mqpacker'),
    pixrem = require( 'gulp-pixrem' ),
    postcss = require('gulp-postcss'),
    sass = require('gulp-sass'),
    sassLint = require('gulp-sass-lint'),
    sourcemaps = require('gulp-sourcemaps'),

    // Utilities
    browserSync = require('browser-sync'),
    notify = require('gulp-notify'),
    rename = require('gulp-rename'),
    plumber = require('gulp-plumber');

/*************
 * Utilities
 ************/

/**
 * Error handling
 *
 * @function
 */
function handleErrors() {
    var args = Array.prototype.slice.call(arguments);

    notify.onError({
        title: 'Task Failed [<%= error.message %>',
        message: 'See console.',
        sound: 'Sosumi' // See: https://github.com/mikaelbr/node-notifier#all-notification-options-with-their-defaults
    }).apply(this, args);

    gutil.beep(); // Beep 'sosumi' again

    // Prevent the 'watch' task from stopping
    this.emit('end');
}


/*************
 * CSS Tasks
 ************/

/**
 * PostCSS Task Handler
 */
gulp.task('postcss', function(){

    return gulp.src('assets/sass/style.scss')

    // Error handling
        .pipe(plumber({
            errorHandler: handleErrors
        }))

        // Wrap tasks in a sourcemap
        .pipe( sourcemaps.init())

        .pipe( sass({
            includePaths: [].concat( bourbon ),
            errLogToConsole: true,
            outputStyle: 'expanded' // Options: nested, expanded, compact, compressed
        }))

        // Generates pixel fallbacks for rem units.
        .pipe( pixrem() )

        .pipe( postcss([
            autoprefixer({
                browsers: ['last 2 versions']
            }),
            mqpacker({
                sort: true
            }),
        ]))

        // creates the sourcemap
        .pipe(sourcemaps.write('./'))

        .pipe(gulp.dest('./'))
        .pipe(browserSync.stream());

});

gulp.task('css:minify', ['postcss'], function() {
    return gulp.src('style.css')
    // Error handling
        .pipe(plumber({
            errorHandler: handleErrors
        }))

        .pipe( cssMinify({
            safe: true
        }))
        .pipe(rename('style.min.css'))
        .pipe(gulp.dest('./'))
});

gulp.task('sass:lint', ['css:minify'], function() {
    gulp.src([
        'assets/sass/style.scss',
        '!assets/sass/base/html5-reset/_normalize.scss',
        '!assets/sass/utilities/animate/**/*.*'
    ])
        .pipe(sassLint())
        .pipe(sassLint.format())
        .pipe(sassLint.failOnError())
});

/********************
 * All Tasks Listeners
 *******************/

gulp.task('watch', function () {
    // Kick off BrowserSync.
    browserSync.init({
        proxy: "www.wpsite.dev"
    });

    gulp.watch('assets/sass/**/*.scss', ['styles']);
    gulp.watch('./**/*.php',browserSync.reload);
});

/**
 * Individual tasks.
 */
// gulp.task('scripts', [''])
gulp.task('styles', ['sass:lint'] );
gulp.task('default',['sass:lint', 'watch']);