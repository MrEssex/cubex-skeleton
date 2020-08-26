import {terser} from 'rollup-plugin-terser';
import typescript from 'rollup-plugin-typescript2';
import resolve from '@rollup/plugin-node-resolve';
import commonjs from '@rollup/plugin-commonjs';
import postcss from 'rollup-plugin-postcss';
import postcssPresetEnv from 'postcss-preset-env/index.js';
import scss from 'rollup-plugin-scss';
import dartSass from 'dart-sass';

process.chdir(__dirname);

export default {
  input: './src/_resources/entry.ts',
  output: {
    file: './resources/main.min.js',
    format: 'iife',
    sourcemap: true,
  },
  plugins: [
    //css
    scss({
      runtime: dartSass
    }),
    postcss(
      {
        extract: true,
        minimize: true,
        plugins: [
          postcssPresetEnv({browsers: 'defaults'}),
        ],
        sourceMap: true,
      }),

    //js
    resolve({browser: true, preferBuiltins: false}),
    commonjs(),
    typescript(),
    terser({
      output: {
        comments: false,
      },
    })
  ],
};