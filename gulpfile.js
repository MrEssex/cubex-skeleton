const gulp = require('gulp');
const sass = require('gulp-sass')(require('sass'));
const sourceMaps = require('gulp-sourcemaps');
const postcss = require('gulp-postcss');
const autoprefixer = require('autoprefixer');
const glob = require('gulp-sass-glob');
const terser = require('gulp-terser');
const gulpIf = require('gulp-if');
const rename = require('gulp-rename');
const rollup = require('@rollup/stream');
const source = require('vinyl-source-stream');
const buffer = require('vinyl-buffer');
const resolve = require('@rollup/plugin-node-resolve');
const typescript = require('@rollup/plugin-typescript');
const commonjs = require('@rollup/plugin-commonjs');
const fg = require('fast-glob');

const env = process.env.NODE_ENV || 'development';

let rollupCache;

function isProduction() {
  return env === 'production';
}

function styles(input, output, useGlob = false, name = '') {
  return gulp
    .src(input)
    .pipe(gulpIf(isProduction(), sourceMaps.init()))
    .pipe(
      sass.sync({
        importer: useGlob ? glob : undefined,
        includePaths: ['./assets/scss', './node_modules', './src'],
        outputStyle: !isProduction() ? 'compressed' : 'expanded'
      })
    )
    .pipe(postcss([autoprefixer]))
    .pipe(
      rename(function (path) {
        if (name) {
          path.basename = name;
        }
        path.basename += '.min';
      })
    )
    .pipe(
      gulpIf(!isProduction(), sourceMaps.write('./', { addComment: false }))
    )
    .pipe(gulp.dest(output));
}

function globStyles() {
  return styles('./src/**/*.scss', './src/', true);
}

function baseStyle() {
  return styles('./assets/scss/index.scss', './resources', false, 'main');
}

function scripts(input, output, name = '') {
  const filename = input.split('/').pop();
  const options = {
    input: input,
    output: {
      name: filename,
      format: 'iife',
      sourcemap: true
    },
    plugins: [resolve(), typescript({ sourceMap: true }), commonjs()],
    cache: rollupCache
  };

  return rollup(options)
    .pipe(source(filename))
    .pipe(buffer())
    .pipe(gulpIf(!isProduction(), sourceMaps.init()))
    .pipe(
      rename(function (path) {
        if (name) {
          path.basename = name;
        }
        path.basename += '.min';
        path.extname = '.js';
      })
    )
    .pipe(gulpIf(isProduction(), terser({ format: { comments: false } })))
    .pipe(
      gulpIf(!isProduction(), sourceMaps.write('./', { addComment: false }))
    )
    .pipe(gulp.dest(output));
}

function baseScript() {
  return scripts('./assets/ts/index.ts', './resources', 'main');
}

function globScripts() {
  const globs = fg.sync('./src/**/*.ts');

  globs.map(function (file) {
    console.log(file);
    const filename = file.split('/').pop();
    const output = file.replace(filename, '');
    return scripts(file, output);
  });

  return Promise.resolve();
}

gulp.task('watch', function (done) {
  gulp.watch(
    ['./assets/scss/**/*.scss', './src/**/*.scss'],
    { ignoreInitial: false },
    gulp.series('styles')
  );
  gulp.watch(
    ['./assets/ts/**/*.ts', './src/**/*.ts'],
    { ignoreInitial: false },
    gulp.series('scripts')
  );

  done();
});

gulp.task('styles', gulp.series(baseStyle, globStyles));
gulp.task('scripts', gulp.series(baseScript, globScripts));
gulp.task('default', gulp.parallel('styles', 'scripts'));
