const {interaction} = require('stylelint-config-clean-order/src/groups/interaction');
const {positioning} = require('stylelint-config-clean-order/src/groups/positioning');
const {layout} = require('stylelint-config-clean-order/src/groups/layout');
const {boxModel} = require('stylelint-config-clean-order/src/groups/box-model');
const {typography} = require('stylelint-config-clean-order/src/groups/typography');
const {apperance} = require('stylelint-config-clean-order/src/groups/apperance');
const {svgPresentation} = require('stylelint-config-clean-order/src/groups/svg-presentation');
const {transition} = require('stylelint-config-clean-order/src/groups/transition');

const propertyGroups = [
  ['all'],
  interaction,
  positioning,
  layout,
  boxModel,
  typography,
  apperance,
  svgPresentation,
  transition
];

const propertiesOrder = propertyGroups.map((properties) => ({
  noEmptyLineBetween: true,
  emptyLineBefore: 'never', // Don't add empty lines between order groups.
  properties
}));

module.exports = {
  'extends': [
    'stylelint-config-standard',
    'stylelint-config-sass-guidelines',
    'stylelint-config-clean-order'
  ],
  'rules': {
    'max-nesting-depth': 3,
    'at-rule-empty-line-before': [
      'always',
      {
        ignore: [
          'first-nested',
          'blockless-after-same-name-blockless',
          'after-comment'
        ]
      }
    ],
    'order/properties-order': [propertiesOrder, {severity: 'warning', unspecified: 'bottomAlphabetical'}],
    'scss/at-rule-no-unknown': null,
    'selector-no-qualifying-type': null,
    'media-query-no-invalid': null
  }
};
