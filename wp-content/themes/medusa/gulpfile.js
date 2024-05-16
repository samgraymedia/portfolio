const gulp = require("gulp");
const sass = require("gulp-sass")(require("sass"));
const sassGlob = require("gulp-sass-glob");
const postcss = require("gulp-postcss");
const autoprefixer = require("autoprefixer");
const cssnano = require("cssnano");
const sourcemaps = require("gulp-sourcemaps");
const rename = require("gulp-rename");
const babel = require("gulp-babel");
const concat = require("gulp-concat");
const terser = require("gulp-terser");

const paths = {
  styles: {
    src: "sass/main.scss",
    dest: "dist/",
  },
  scripts: {
    src: "js/**/*.js",
    dest: "dist/",
  },
};

function styles() {
  return gulp
    .src(paths.styles.src)
    .pipe(sourcemaps.init())
    .pipe(sassGlob()) // Enable glob support
    .pipe(sass().on("error", sass.logError))
    .pipe(postcss([autoprefixer(), cssnano()]))
    .pipe(
      rename({
        basename: "main",
        suffix: ".min",
      })
    )
    .pipe(sourcemaps.write("."))
    .pipe(gulp.dest(paths.styles.dest));
}

function scripts() {
  return gulp
    .src(paths.scripts.src)
    .pipe(sourcemaps.init())
    .pipe(
      babel({
        presets: ["@babel/preset-env"],
      })
    )
    .pipe(concat("main.js"))
    .pipe(terser())
    .pipe(
      rename({
        suffix: ".min",
      })
    )
    .pipe(sourcemaps.write("."))
    .pipe(gulp.dest(paths.scripts.dest));
}

function watch() {
  gulp.watch("sass/**/*.scss", styles);
  gulp.watch(paths.scripts.src, scripts);
}

exports.styles = styles;
exports.scripts = scripts;
exports.watch = watch;

const build = gulp.series(gulp.parallel(styles, scripts), watch);
gulp.task("default", build);
