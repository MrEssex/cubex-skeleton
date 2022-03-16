import postcss from 'rollup-plugin-postcss';
import resolve from '@rollup/plugin-node-resolve';
import typescript from '@rollup/plugin-typescript';
import tailwindcss from 'tailwindcss';
import autoprefixer from 'autoprefixer';
import {terser} from 'rollup-plugin-terser';

// eslint-disable-next-line no-undef
const production = !process.env.ROLLUP_WATCH;

const commonPlugins = [
  resolve(),
  typescript({'sourceMap': !production}),
  production && terser()
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
        sourceMap: !production,
        plugins:   [tailwindcss, autoprefixer]
      }),
    ...commonPlugins
  ]
};
