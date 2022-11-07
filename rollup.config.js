import Flutter from 'flutter';
import postcssComments from 'postcss-discard-comments';
import autoprefixer from 'autoprefixer';

const plugins = [
  postcssComments({removeAll: true}),
  autoprefixer()
];

Flutter
  .setInputPath('assets/entry.ts')
  .setOutputPath('main.js', 'resources/main.min.js', {inlineDynamicImports: true})
  .typescript()
  .svelte()
  .json()
  .resolve(['svelte'])
  .commonJs()
  .postCss({plugins: plugins});

export default Flutter.getRollupConfig();
