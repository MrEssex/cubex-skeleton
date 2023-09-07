/** @type {import('mocha')} */
module.exports = {
  extensions: ['ts'],
  spec: 'assets/**/*.spec.ts',
  require: ['ts-node/register'],
  timeout: 10000,
  nodeOptions: [
    'experimental-specifier-resolution=node',
    'loader=ts-node/esm',
  ],
};
