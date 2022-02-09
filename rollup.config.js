import postcss from 'rollup-plugin-postcss';
import resolve from '@rollup/plugin-node-resolve';
import typescript from '@rollup/plugin-typescript';
import {terser} from 'rollup-plugin-terser';

// `yarn watch` -> `production` is false
// `yarn build` -> `production` is true
// eslint-disable-next-line no-undef
const production = !process.env.ROLLUP_WATCH;

const commonPlugins = [
  resolve(), // tells Rollup how to find node_modules packages
  typescript({
    'sourceMap': !production
  }), // run typescript compiler
  production && terser() // minify, but only in production
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
    postcss(
      {
        extract:   true,
        minimize:  production,
        sourceMap: !production
      }), // Extract css from js
    ...commonPlugins
  ]
};
