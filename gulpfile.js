'use strict';

var gulp = require('gulp'),
    sass = require('gulp-sass'),
    minify = require('gulp-minify'),
    minifyCss = require('gulp-minify-css'),
    autoprefixer = require('gulp-autoprefixer'),
    sourcemaps = require('gulp-sourcemaps'),
    concat = require('gulp-concat'),
    rename = require('gulp-rename'),
    del = require('del'),
    plumber = require('gulp-plumber');


// Clean dist folder
gulp.task('clean', del.bind(null, ['public/dist']));

// Compile and Automatically Prefix Stylesheets
gulp.task('sass', function () {
    return gulp.src(['public/src/sass/*.sass'])
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
        .pipe(gulp.dest('public/src/css'));
});

// Optimize Js
gulp.task('scripts', function () {
    gulp.src([
        'public/src/vendor/fancybox/source/jquery.fancybox.js',
        'public/src/js/mediabrowser-opener.js'
    ])
        .pipe(concat('mediabrowser-include.js'))
        .pipe(minify({
            ext: {
                src: '.js',
                min: '.min.js'
            }
        }))
        .pipe(gulp.dest('public/dist'));

    gulp.src([
        'public/src/vendor/jquery/dist/jquery.js',
        'public/src/vendor/handlebars/handlebars.js',
        'public/src/vendor/jquery-file-upload/js/vendor/jquery.ui.widget.js',
        'public/src/vendor/jquery-truncate/jquery.truncate.js',
        'public/src/vendor/blockui/jquery.blockUI.js',
        'public/src/vendor/jquery-file-upload/js/jquery.iframe-transport.js',
        'public/src/vendor/jquery-file-upload/js/jquery.fileupload.js',
        'public/src/vendor/jquery-file-upload/js/jquery.fileupload-process.js',
        'public/src/vendor/jquery-file-upload/js/jquery.fileupload-validate.js',
        'public/src/js/ajax.js',
        'public/src/js/mediabrowser.js'
    ])
        .pipe(concat('mediabrowser.js'))
        .pipe(minify({
            ext: {
                src: '.js',
                min: '.min.js'
            }
        }))
        .pipe(gulp.dest('public/dist'));
});

// Optimize Css
gulp.task('styles', ['sass'], function () {
    gulp.src([
        'public/src/vendor/fancybox/source/jquery.fancybox.css'
    ])
        .pipe(concat('mediabrowser-include.css'))
        .pipe(gulp.dest('public/dist'))
        .pipe(minifyCss())
        .pipe(rename({suffix: '.min'}))
        .pipe(gulp.dest('public/dist'));

    gulp.src([
        'public/src/vendor/jquery-file-upload/css/jquery.fileupload.css',
        'public/src/css/mediabrowser.css'
    ])
        .pipe(concat('mediabrowser.css'))
        .pipe(gulp.dest('public/dist'))
        .pipe(minifyCss())
        .pipe(rename({suffix: '.min'}))
        .pipe(gulp.dest('public/dist'));
});

// Copy vendor assets
gulp.task('copy-vendor-assets', function(){
    return gulp.src([
        'public/src/vendor/fancybox/source/*.gif',
        'public/src/vendor/fancybox/source/*.png'
    ])
        .pipe(gulp.dest('public/dist'));
});



// DEFAULT
gulp.task('default', ['watch']);


gulp.task('watch', function () {
    gulp.watch(['public/src/sass/*.scss'], ['sass']);
});

