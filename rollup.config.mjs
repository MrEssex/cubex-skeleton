import autoprefixer from 'autoprefixer';
import tailwind from 'tailwindcss';
import postcssComments from 'postcss-discard-comments';
import postcss from 'rollup-plugin-postcss';
import resolve from '@rollup/plugin-node-resolve';
import terser from '@rollup/plugin-terser';
import copy from 'rollup-plugin-copy';
import typescript from '@rollup/plugin-typescript';
import svelte from 'rollup-plugin-svelte';
import json from '@rollup/plugin-json';
import sveltePreprocess from 'svelte-preprocess';
import commonJs from '@rollup/plugin-commonjs';

const production = process.env.NODE_ENV === 'production';

const commonPlugins = [
  typescript({'sourceMap': !production}),
  svelte({
    preprocess: sveltePreprocess(),
    emitCss:    true
  }),
  json(),
  commonJs(),
  resolve({
    browser:        true,
    preferBuiltins: true,
    dedupe:         ['svelte']
  }),
  production && terser()
];

const postcssPlugins = [
  autoprefixer(),
  postcssComments({'removeAll': true}),
  tailwind()
];

export default {
  input:   'assets/index.ts',
  output:  {
    inlineDynamicImports: true,
    file:                 'resources/main.min.js',
    name:                 'main.js',
    format:               'iife',
    sourcemap:            !production
  },
  plugins: [
    ...commonPlugins,
    postcss({
      extract:   true,
      minimize:  production,
      sourceMap: !production,
      plugins:   postcssPlugins
    }),
    copy({
      targets: [
        {src: 'assets/font/*', dest: 'resources/font'},
        {src: 'assets/img/*', dest: 'resources/img'}
      ]
    })
  ]
};
