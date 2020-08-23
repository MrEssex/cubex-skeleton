import {terser} from 'rollup-plugin-terser';
import resolve from '@rollup/plugin-node-resolve';
import commonjs from '@rollup/plugin-commonjs';
import babel from '@rollup/plugin-babel';
import postcss from 'rollup-plugin-postcss';
import flexbugs from 'postcss-flexbugs-fixes';
import postcssPresetEnv from 'postcss-preset-env/index.js';
import scss from 'rollup-plugin-scss';
import dartSass from 'dart-sass';

process.chdir(__dirname);

const defaultBrowsers = ['defaults', 'not ie > 0'];

const defaultCfg = {
  input: './src/_resources/js/entry.js',
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
          postcssPresetEnv({browsers: defaultBrowsers}),
        ],
        sourceMap: true,
      }),

    //js
    resolve({browser: true, preferBuiltins: false}),
    commonjs(),
    babel(
      {
        babelHelpers: 'bundled',
        babelrc: false,
        exclude: [/\/core-js\//],
        presets: [
          [
            '@babel/preset-typescript'
          ],
          [
            '@babel/preset-env',
            {
              corejs: 3,
              modules: false,
              useBuiltIns: 'usage',
              targets: defaultBrowsers,
            },
          ],
        ],
      }),
    terser(),
  ],
};

const ieBrowsers = ['ie > 9', '> 0.02%', 'last 2 versions', 'Firefox ESR'];

const ieConfig = {
  input: './src/_resources/js/entry_ie.js',
  output: {
    file: './resources/main.ie.min.js',
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
          flexbugs(),
          postcssPresetEnv({browsers: ieBrowsers, autoprefixer: {grid: 'no-autoplace'}}),
        ],
        sourceMap: true,
      }),
    //js
    resolve({browser: true, preferBuiltins: false}),
    commonjs(),
    babel(
      {
        babelHelpers: 'bundled',
        babelrc: false,
        exclude: [/\/core-js\//],
        presets: [
          [
            '@babel/preset-env',
            {
              corejs: 3,
              modules: false,
              useBuiltIns: 'usage',
              targets: ieBrowsers,
            },
          ],
        ],
      }),
    terser(),
  ],
};

export default [defaultCfg, ieConfig];
