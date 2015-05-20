var gulp = require("gulp");
var del = require("del");
var less = require("gulp-less");
var rename = require("gulp-rename");
var minifycss = require("gulp-minify-css");
var notify = require("gulp-notify");
var copy = require("gulp-copy");

gulp.task("clean", function(cb) {
    del(["public/dist/*"], cb);
});

gulp.task("styles", function() {
    return gulp.src("public/src/styles/app.less")
        .pipe(less())
        .on("error", function(err) {
            console.log(err.message);
            this.emit("end");
        })
        .pipe(gulp.dest("public/dist"))
        .pipe(rename({ suffix: ".min" }))
        .pipe(minifycss())
        .pipe(gulp.dest("public/dist"))
        .pipe(notify({ message: "Styles task complete"}));
});

gulp.task("copyJQueryJs", function() {
    return gulp.src("node_modules/jquery/dist/jquery.min.*")
        .pipe(copy("public/dist", { prefix: 3 }));
});

gulp.task("copyBootstrapJs", function() {
    return gulp.src("node_modules/bootstrap/dist/js/bootstrap.min.js")
        .pipe(copy("public/dist", { prefix: 4 }));
});

gulp.task("js", function() {
    gulp.start("copyJQueryJs", "copyBootstrapJs");
    notify({ message: "Js task complete" });
});

gulp.task("default", ["clean"], function() {
    gulp.start("styles", "js");
});

gulp.task("watch", function() {
    gulp.watch("public/src/**/*.less", ["styles"]);
});
