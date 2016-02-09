'use strict';

var gulp = require('gulp'),
    sass = require('gulp-sass'),
    minify = require('gulp-minify'),
    cssnano = require('gulp-cssnano'),
    autoprefixer = require('gulp-autoprefixer'),
    sourcemaps = require('gulp-sourcemaps'),
    concat = require('gulp-concat'),
    rename = require('gulp-rename'),
    del = require('del'),
    plumber = require('gulp-plumber');


// Clean dist folder
gulp.task('clean', del.bind(null, ['resources/assets/dist']));

// Compile and Automatically Prefix Stylesheets
gulp.task('sass', function () {
    return gulp.src(['resources/assets/src/sass/*.sass'])
        .pipe(plumber())
        .pipe(sourcemaps.init())
        .pipe(sass({style: 'expanded'}))
        .pipe(autoprefixer({
            browsers: ['last 3 versions', 'IE >= 9'],
            cascade: false
        }))
        .pipe(sourcemaps.write('.', {
            includeContent: false,
            sourceRoot: '../sass'
        }))
        .pipe(gulp.dest('resources/assets/src/css'));
});

// Optimize Js
gulp.task('scripts', function () {
    gulp.src([
        'resources/assets/src/vendor/fancybox/source/jquery.fancybox.js',
        'resources/assets/src/js/mediabrowser-opener.js'
    ])
        .pipe(concat('mediabrowser-include.js'))
        .pipe(minify({
            ext: {
                src: '.js',
                min: '.min.js'
            }
        }))
        .pipe(gulp.dest('resources/assets/dist'));

    gulp.src([
        'resources/assets/src/vendor/jquery/dist/jquery.js',
        'resources/assets/src/vendor/handlebars/handlebars.js',
        'resources/assets/src/vendor/jquery-file-upload/js/vendor/jquery.ui.widget.js',
        'resources/assets/src/vendor/jquery-truncate/jquery.truncate.js',
        'resources/assets/src/vendor/blockui/jquery.blockUI.js',
        'resources/assets/src/vendor/jquery-file-upload/js/jquery.iframe-transport.js',
        'resources/assets/src/vendor/jquery-file-upload/js/jquery.fileupload.js',
        'resources/assets/src/vendor/jquery-file-upload/js/jquery.fileupload-process.js',
        'resources/assets/src/vendor/jquery-file-upload/js/jquery.fileupload-validate.js',
        'resources/assets/src/js/ajax.js',
        'resources/assets/src/js/mediabrowser.js'
    ])
        .pipe(concat('mediabrowser.js'))
        .pipe(minify({
            ext: {
                src: '.js',
                min: '.min.js'
            }
        }))
        .pipe(gulp.dest('resources/assets/dist'));
});

// Optimize Css
gulp.task('styles', ['sass'], function () {
    gulp.src([
        'resources/assets/src/vendor/fancybox/source/jquery.fancybox.css'
    ])
        .pipe(concat('mediabrowser-include.css'))
        .pipe(gulp.dest('resources/assets/dist'))
        .pipe(cssnano())
        .pipe(rename({suffix: '.min'}))
        .pipe(gulp.dest('resources/assets/dist'));

    gulp.src([
        'resources/assets/src/vendor/jquery-file-upload/css/jquery.fileupload.css',
        'resources/assets/src/css/mediabrowser.css'
    ])
        .pipe(concat('mediabrowser.css'))
        .pipe(gulp.dest('resources/assets/dist'))
        .pipe(cssnano())
        .pipe(rename({suffix: '.min'}))
        .pipe(gulp.dest('resources/assets/dist'));
});

// Copy vendor assets
gulp.task('copy-vendor-assets', function () {
    return gulp.src([
        'resources/assets/src/vendor/fancybox/source/*.gif',
        'resources/assets/src/vendor/fancybox/source/*.png'
    ])
        .pipe(gulp.dest('resources/assets/dist'));
});


// DEFAULT
gulp.task('default', ['watch']);


gulp.task('watch', function () {
    gulp.watch(['resources/assets/src/sass/*.scss'], ['sass']);
});

