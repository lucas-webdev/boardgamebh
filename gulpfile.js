const gulp = require('gulp');
const sass = require('gulp-sass');
const autoprefixer = require('gulp-autoprefixer');
const gls = require('gulp-live-server');
const webpack = require("webpack");
const php = require('gulp-connect-php');
const browserSync = require('browser-sync').create();

gulp.task('php', function () {
    php.server({ base: './', port: 8010, keepalive: true });
});

gulp.task('browserSync', gulp.series('php'), function () {
    browserSync.init({
        proxy: "localhost:8010",
        baseDir: "./",
        open: true,
        notify: false

    });
});

gulp.task('dev', gulp.series('browserSync'), function () {
    gulp.watch('./lista/*.php', browserSync.reload);
});


gulp.task('sass', function () {
    return gulp.src(['./client/sass/**/*.scss'])
        .pipe(sass({
            outputStyle: 'compressed',
            errLogToConsole: true,
            onError: function (err) {
            }
        }))
        .pipe(autoprefixer('last 1 version'))
        .pipe(gulp.dest('./public/css'));
});
gulp.task('server', gulp.series('browserSync'), function () {
    var sources = [
        './public/index.html',
        './public/**/*.css',
        './public/**/*.js'
    ];

    var server = gls.static('./', '3001', process.env.IP);
    server.start();

    //use gulp.watch to trigger server actions(notify, start or stop)
    return gulp.watch(sources, function (file) {
        server.notify.apply(server, [file]);
    });
});

gulp.task('watch', function () {
    gulp.watch(['./client/sass/**/*.scss'], gulp.series("sass"));
    gulp.watch(['./client/scripts/**/*.js'], gulp.series("webpack"));
});

gulp.task("webpack", function (callback) {
    webpack({

        entry: "./client/scripts/app.js",

        output: {
            path: "./public/js",
            filename: "scripts.js"
        },

        devtool: 'source-map',

        plugins: [
            //new webpack.optimize.UglifyJsPlugin({minimize: true}) //uncomment if you want to uglify the output file
        ],

        module: {
            loaders: [
                {
                    test: /\.jsx?$/,
                    exclude: /(node_modules|bower_components)/,
                    loader: 'babel',
                    query: {
                        //    presets: ['es2015'] //uncomment if you want es2015 to ES5
                    }
                }
            ]
        }

    }, function (err, stats) {
        if (err) throw new gutil.PluginError("webpack", err);
        console.log("[webpack]", stats.toString({
            // output options
        }));
        callback();
    });
});


gulp.task('serve', gulp.series('watch', 'server'));