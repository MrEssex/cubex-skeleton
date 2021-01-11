import {terser} from 'rollup-plugin-terser';
import typescript from 'rollup-plugin-typescript2';
import resolve from '@rollup/plugin-node-resolve';
import commonjs from '@rollup/plugin-commonjs';
import postcss from 'rollup-plugin-postcss';
import postcssPresetEnv from 'postcss-preset-env/index.js';

process.chdir(__dirname);

module.exports = {
  input:   './src/_resources/entry.ts',
  output:  {
    file:      './resources/main.min.js',
    format:    'iife',
    sourcemap: true,
    name:      'main'
  },
  plugins: [
    postcss(
      {
        extract:   true,
        minimize:  true,
        plugins:   [
          postcssPresetEnv({browsers: ['defaults', 'not ie > 0']}),
        ],
        sourceMap: true,
      }),
    resolve({browser: true, preferBuiltins: false}),
    commonjs(),
    typescript(),
    terser({
             output: {
               comments: false
             }
           })
  ],
};
