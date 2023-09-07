import resolve from '@rollup/plugin-node-resolve';
import terser from '@rollup/plugin-terser';
import typescript from 'rollup-plugin-typescript2';
import commonjs from '@rollup/plugin-commonjs';
import postcss from 'rollup-plugin-postcss';
import postcssComments from 'postcss-discard-comments';
import autoprefixer from 'autoprefixer';
import copy from 'rollup-plugin-copy';

const production = true;

export default {
  input: 'assets/entry.ts',
  output: {
    file: 'resources/main.min.js',
    name: 'main.js',
    format: 'iife',
    sourcemap: !production,
  },
  plugins: [
    resolve(),
    typescript({'sourceMap': !production}),
    commonjs(),
    production && terser({format: {comments: false}}),
    postcss({
      extract: true,
      minimize: production,
      sourceMap: !production,
      plugins: [
        autoprefixer(),
        postcssComments({removeAll: true}),
      ],
    }),
    copy({
      targets: [
        {src: 'assets/img/*', dest: 'resources/img'},
        {src: 'assets/font/*', dest: 'resources/font'},
      ],
    }),
  ],
};
