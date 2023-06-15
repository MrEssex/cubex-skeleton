import autoprefixer from 'autoprefixer';
import tailwind from 'tailwindcss';
import postcssComments from 'postcss-discard-comments';
import postcss from 'rollup-plugin-postcss';
import resolve from '@rollup/plugin-node-resolve';
import terser from '@rollup/plugin-terser';
import copy from 'rollup-plugin-copy';
import typescript from '@rollup/plugin-typescript';

const production = process.env.NODE_ENV === 'production';

const commonPlugins = [
  resolve(),
  typescript({'sourceMap': !production}),
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
    file:      'resources/main.min.js',
    name:      'main.js',
    format:    'iife',
    sourcemap: !production
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
