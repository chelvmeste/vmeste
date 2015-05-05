// VMESTE GULPFILE
// -------------------------------------

// 1. LIBRARIES
// - - - - - - - - - - - - - - -

var gulp           = require('gulp'),
    rimraf         = require('rimraf'),
    runSequence    = require('run-sequence'),
    autoprefixer   = require('gulp-autoprefixer'),
    less           = require('gulp-less'),
    uglify         = require('gulp-uglify'),
    concat         = require('gulp-concat');

// 2. SETTINGS VARIABLES
// - - - - - - - - - - - - - - -

// Less will check these folders for files when you use @import.
var appLess = 'src/less/app.less';
var blindLess = 'src/less/blind.less';
// These files include js dependencies
var vendorJs = [
    'bower_components/jquery/dist/jquery.js',
    'bower_components/bootstrap/dist/js/bootstrap.js',
    'src/js/vendor/moment.js',
    'src/js/vendor/moment.ru.js',
    'src/js/vendor/bootstrap-datetimepicker.min.js',
    'src/js/vendor/nprogress.js',
    'src/js/vendor/mustache.js',
    'src/js/vendor/template.js',
    'src/js/vendor/typeahead.bundle.js',
    'src/js/vendor/map.js',
    'src/js/vendor/search.js'
];
// These files are for your app's JavaScript
var appJS = [
    'src/js/app/**/*.js'
];

// 3. TASKS
// - - - - - - - - - - - - - - -

// Cleans the build directory
gulp.task('clean', function(cb) {
    rimraf('./public/assets', cb);
});

// Copies user-created files
gulp.task('copy', function() {

    // Font-awesome
    gulp.src('./bower_components/bootstrap/fonts/**/*')
        .pipe(gulp.dest('./public/assets/fonts/'));
    // Open Sans fonts
    gulp.src('./src/fonts/**/*')
        .pipe(gulp.dest('./public/assets/fonts/'));
    // App JS
    gulp.src(appJS)
        .pipe(gulp.dest('./public/assets/js/'));
    // Images
    return gulp.src('./src/img/**/*')
        .pipe(gulp.dest('./public/assets/img/'));
});

// Compiles Less
gulp.task('less', function() {
    gulp.src(appLess)
        .pipe(less({
            style: 'nested',
            bundleExec: true
        }))
        .on('error', function(e) {
            console.log(e);
        })
        .pipe(autoprefixer({
            browsers: ['last 2 versions']
        }))
        .pipe(gulp.dest('./public/assets/css/'));
    return gulp.src(blindLess)
        .pipe(less({
            style: 'nested',
            bundleExec: true
        }))
        .on('error', function(e) {
            console.log(e);
        })
        .pipe(autoprefixer({
            browsers: ['last 2 versions']
        }))
        .pipe(gulp.dest('./public/assets/css/'));
});

// Compiles and copies JS
gulp.task('uglify', function() {
    // JavaScript
    return gulp.src(vendorJs)
        //.pipe(uglify({
        //  beautify: true,
        //  mangle: false
        //}).on('error', function(e) {
        //  console.log(e);
        //}))
        .pipe(concat('vendor.js'))
        .pipe(gulp.dest('./public/assets/js/'));
});


// Builds your entire app once, without starting a server
gulp.task('build', function() {
    runSequence('clean', ['copy', 'less', 'uglify'], function() {
        console.log("Successfully built.");
    })
});

// Default task: builds your app, starts a server, and recompiles assets when they change
gulp.task('default', ['build'], function() {
    // Watch Sass
    gulp.watch(['./src/less/**/*', './less/**/*'], ['less']);

    // Watch JavaScript
    gulp.watch(['./src/js/**/*'], ['uglify']);

});
