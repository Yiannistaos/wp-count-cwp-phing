/*=============================================
=            CONSTANTS                        =
=============================================*/
const gulp = require('gulp');
const mirror = require('mirror-folder'); // https://github.com/mafintosh/mirror-folder
const uglify = require('gulp-uglify');
const uglifycss = require('gulp-uglifycss');
const rename = require('gulp-rename');
const fs = require('fs');
// var sass = require('gulp-sass');
var replace = require('gulp-string-replace');

/*****************************
 * BEGIN: MINIFY CSS + JS
 *****************************/
var css_admin_files = ['count-cwp/admin/css/admin.css'];
var js_admin_files = [
    'count-cwp/admin/js/admin.js',
    'count-cwp/admin/js/tinymce-keyup.js',
];
var css_public_files = ['count-cwp/public/css/public.css'];
var js_public_files = ['count-cwp/public/js/public.js'];

// Gulp task to minify CSS files
gulp.task('minify_admin_css', function () {
    return gulp
        .src(css_admin_files) // or other selection
        .pipe(uglifycss())
        .pipe(
            rename({
                suffix: '.min',
            })
        )
        .pipe(gulp.dest('count-cwp/admin/css/'));
});
gulp.task('minify_public_css', function () {
    return gulp
        .src(css_public_files) // or other selection
        .pipe(uglifycss())
        .pipe(
            rename({
                suffix: '.min',
            })
        )
        .pipe(gulp.dest('count-cwp/public/css/'));
});

// Gulp task to minify JavaScript files
gulp.task('minify_admin_js', function () {
    return (
        gulp
            .src(js_admin_files)
            // Minify the file
            .pipe(uglify())
            // Output
            .pipe(
                rename({
                    suffix: '.min',
                })
            )
            .pipe(gulp.dest('count-cwp/admin/js/'))
    );
    done();
});
gulp.task('minify_public_js', function () {
    return (
        gulp
            .src(js_public_files)
            // Minify the file
            .pipe(uglify())
            // Output
            .pipe(
                rename({
                    suffix: '.min',
                })
            )
            .pipe(gulp.dest('count-cwp/public/js/'))
    );
    done();
});

/*****************************
 * END: MINIFY CSS + JS
 *****************************/

/*****************************
 * BEGIN: SASS
 *****************************/
/* var scss_admin_files = [
    'count-cwp/admin/css/admin.scss',
];
sass.compiler = require('node-sass');
gulp.task('saas_admin_scss', function () {
    return gulp.src(scss_admin_files)
        .pipe(sass().on('error', sass.logError))
        .pipe(gulp.dest("count-cwp/admin/css/"));
    done();
});

var scss_public_files = [
    'count-cwp/public/css/public.scss',
];
sass.compiler = require('node-sass');
gulp.task('saas_public_scss', function () {
    return gulp.src(scss_public_files)
        .pipe(sass().on('error', sass.logError))
        .pipe(gulp.dest("count-cwp/public/css/"));
    done();
}); */
/*****************************
 * END SASS
 *****************************/

/*****************************
 * BEGIN: MIRROR-FOLDER
 *****************************/
/**
 *
 * Folder Mirroring
 *
 */

gulp.task('mirror', function (done) {
    function ignore(file) {
        // ignore any files with secret in them
        if (file.indexOf('.git') > -1) return true;
        return false;
    }

    var json = JSON.parse(fs.readFileSync('mirror.json'));

    for (var i = 0; i < json.mirrors.length; i++) {
        var p = mirror(json.mirrors[i].src, json.mirrors[i].dst, {
            live: true,
            dereference: true,
            ignore: null,
        });

        p.on('put', function (src, dst) {
            // console.log('adding', dst.name)
        });

        p.on('del', function (dst) {
            console.log('deleting', dst.name);
        });

        p.on('ignore', function (src, dst) {
            console.log('ignoring', dst.name);
        });

        p.on('skip', function (src, dst) {
            // console.log('skip', dst.name)
        });

        p.on('error', function (err) {
            if (err) throw err;
        });
    }

    done();
});
/*****************************
 * END: MIRROR-FOLDER
 *****************************/

/*****************************
 * BEGIN: Kanei replace tin _profeature sta xml files twn extensions
 * etsi wste na mporeis na paikseis topika
 *****************************/
gulp.task('removeprofeature', function (done) {
    setTimeout(function () {
        var options = {
            logs: {
                enabled: false,
            },
            searchValue: 'regex',
        };

        var json = JSON.parse(fs.readFileSync('mirror.json'));

        for (var i = 0; i < json.mirrors.length; i++) {
            //console.log(json.mirrors[i].dst + '/**/*');
            gulp.src([
                json.mirrors[i].dst + '/**/*.{php,xml,ini,txt,css,js,scss}',
            ])

                // GENERATOR
                .pipe(replace(/WP_PLUGIN_NAME_CLEAN/g, 'Count CWP'), options)
                .pipe(
                    replace(/WP_PLUGIN_NAME/g, 'Count CWP (Pro Gulp)'),
                    options
                )
                .pipe(replace(/WP_PLUGIN_URL/g, '###'), options)
                .pipe(
                    replace(
                        /WP_PLUGIN_SHORT_DESCRIPTION/g,
                        'Short description for Count CWP goes here'
                    ),
                    options
                )
                .pipe(
                    replace(
                        /WP_PLUGIN_LONG_DESCRIPTION/g,
                        'Long description for Count CWP goes here'
                    ),
                    options
                )
                .pipe(replace(/WP_PLUGIN_VERSION/g, '1.0.0'), options)
                .pipe(
                    replace(
                        /WP_PLUGIN_TEXT_DOMAIN_UNDERSCORE_FREE/g,
                        'login_as_user'
                    ),
                    options
                )
                .pipe(
                    replace(
                        /WP_PLUGIN_TEXT_DOMAIN_UNDERSCORE/g,
                        'login_as_user_pro'
                    ),
                    options
                ) // login_as_user_pro or login_as_user
                .pipe(
                    replace(/WP_PLUGIN_TEXT_DOMAIN_FREE/g, 'count-cwp'),
                    options
                ) // count-cwp
                .pipe(
                    replace(/WP_PLUGIN_TEXT_DOMAIN/g, 'count-cwp-pro'),
                    options
                ) // count-cwp-pro
                .pipe(replace(/WP_UPDATES_SUBDOMAIN/g, 'wp-updates'), options)
                .pipe(replace(/WP_RELEASE_TYPE/g, 'beta'), options)
                .pipe(replace(/WP_LICENSE_TYPE/g, 'free'), options)
                .pipe(
                    replace(
                        /WP_PLUGIN_UPPER_CAMEL_CASE_CLASS_NAME_FREE/g,
                        'CountCWP'
                    ),
                    options
                )
                .pipe(
                    replace(
                        /WP_PLUGIN_UPPER_CAMEL_CASE_CLASS_NAME/g,
                        'CountCWPPro'
                    ),
                    options
                ) // CountCWPPro or CountCWP
                .pipe(
                    replace(/WP_PLUGIN_UPPERCASE_DEFINE_NAME/g, 'CountCWPPRO'),
                    options
                ) // CountCWPPRO or COUNTCWP
                .pipe(replace(/WP_PLUGIN_DOCUMENTATION_URL/g, '#'), options)
                .pipe(replace(/WP_PLUGIN_SUPPORT_FORUM_URL/g, '#'), options)
                .pipe(
                    replace(/WP_PLUGIN_RATE_WORDPRESS_ORG_URL/g, '#'),
                    options
                )
                .pipe(
                    replace(/WP_PLUGIN_OTHER_WEB357_WP_PLUGINS_URL/g, '#'),
                    options
                )

                // README.txt
                .pipe(
                    replace(/WP_PLUGIN_CONTRIBUTORS/g, 'yiannistaos'),
                    options
                )
                .pipe(
                    replace(
                        /WP_PLUGIN_TAGS/g,
                        'loginasuser, web357, login, client, user'
                    ),
                    options
                )
                .pipe(replace(/WP_PLUGIN_REQUIRES_AT_LEAST/g, '4.6'), options)
                .pipe(replace(/WP_PLUGIN_TESTED_UP_TO/g, '5.2'), options)
                .pipe(replace(/WP_PLUGIN_REQUIRES_PHP/g, '5.4'), options)
                .pipe(
                    replace(
                        /WP_PLUGIN_INSTALLATION_INSTRUCTIONS/g,
                        'Installation instructions goes here...'
                    ),
                    options
                )
                .pipe(
                    replace(
                        /WP_PLUGIN_FAQ/g,
                        'Frequently asked questions goes here...'
                    ),
                    options
                )
                .pipe(
                    replace(/WP_PLUGIN_SCREENSHOTS/g, 'Screenshots here'),
                    options
                )
                .pipe(
                    replace(/WP_PLUGIN_CHANGELOG/g, 'Changelog here'),
                    options
                )
                .pipe(replace(/WP_PLUGIN_CHANGELOG_URL/g, '#'), options)

                // Panta douleueis tin PRO ekdosi
                .pipe(
                    replace(/\/\*begin:free\*\/[\s\S]*?\/*end:free\*\//gs, ''),
                    options
                ) // Einai PRO
                //.pipe(replace(/\/\*begin:pro\*\/[\s\S]*?\/*end:pro\*\//gs, ""),options) // Einai FREE

                .pipe(gulp.dest(json.mirrors[i].dst));
        }
    }, 4000);

    done();
});

// rename the pro file
gulp.task('rename_pro_file', function (done) {
    setTimeout(function () {
        var json = JSON.parse(fs.readFileSync('mirror.json'));

        for (var i = 0; i < json.mirrors.length; i++) {
            gulp.src([json.mirrors[i].dst + '/count-cwp.php'])
                .pipe(rename('count-cwp-pro.php'))
                .pipe(gulp.dest(json.mirrors[i].dst));
        }
    }, 4500);

    done();
});

// rename the pro file
gulp.task('rename_pro_language_files', function (done) {
    setTimeout(function () {
        var json = JSON.parse(fs.readFileSync('mirror.json'));

        for (var i = 0; i < json.mirrors.length; i++) {
            gulp.src([json.mirrors[i].dst + '/languages/**/*.{mo,po}'])
                .pipe(
                    rename({
                        dirname: 'languages',
                        prefix: 'count-cwp-pro-',
                        suffix: '',
                    })
                )
                .pipe(gulp.dest(json.mirrors[i].dst));

            gulp.src([json.mirrors[i].dst + '/languages/count-cwp.pot'])
                .pipe(
                    rename({
                        dirname: 'languages',
                        basename: 'count-cwp-pro',
                        prefix: '',
                        suffix: '',
                    })
                )
                .pipe(gulp.dest(json.mirrors[i].dst));
        }
    }, 5000);

    done();
});

/*****************************
 * END: Kanei replace tin _profeature
 *****************************/

/*****************************
 * BEGIN: WATCH
 *****************************/
gulp.task('watch', function () {
    // gulp.watch(scss_admin_files, gulp.series('saas_admin_scss'));
    // gulp.watch(scss_public_files, gulp.series('saas_public_scss'));
    gulp.watch(css_admin_files, gulp.series('minify_admin_css'));
    gulp.watch(js_admin_files, gulp.series('minify_admin_js'));
    gulp.watch(css_public_files, gulp.series('minify_public_css'));
    gulp.watch(js_public_files, gulp.series('minify_public_js'));
    //gulp.watch('./**/*.*', gulp.registry().get('mirror'));
    gulp.watch('./**/*.*', gulp.series('mirror'));
    //gulp.watch('./**/*.*', gulp.series('mirror', 'removeprofeature'));
    //gulp.watch('./**/*.*', gulp.series('rename_pro_file'));
    //gulp.watch('./**/*.*', gulp.series('rename_pro_language_files'));
});
/*****************************
 * END: WATCH
 *****************************/
