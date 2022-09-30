import postcss from 'rollup-plugin-postcss';
import resolve from '@rollup/plugin-node-resolve';
import postcssComments from 'postcss-discard-comments';
import autoprefixer from 'autoprefixer';
import commonjs from '@rollup/plugin-commonjs';
import typescript from '@rollup/plugin-typescript';
import tailwind from 'tailwindcss';
import {terser} from 'rollup-plugin-terser';

// `yarn watch` -> `production` is false
// `yarn build` -> `production` is true
// eslint-disable-next-line no-undef
const production = !process.env.ROLLUP_WATCH;

const commonPlugins = [
  resolve(), // tells Rollup how to find node_modules packages
  commonjs(),
  typescript({'sourceMap': !production}), // run typescript compiler
  commonjs({
    exclude:      'node_modules',
    ignoreGlobal: true
  }),
  production && terser() // minify, but only in production
];

const postcssPlugins = [
  autoprefixer(),
  postcssComments({'removeAll': true}),
  tailwind()
];

export default {
  input:   'assets/entry.ts',
  output:  {
    file:      'resources/main.min.js',
    name:      'main.js',
    format:    'iife', // immediately-invoked function expression — suitable for <script> tags
    sourcemap: !production
  },
  plugins: [
    ...commonPlugins,
    postcss(
      {
        extract:   true,
        minimize:  production,
        sourceMap: !production,
        plugins:   postcssPlugins
      }) // Extract css from js
  ]
};
