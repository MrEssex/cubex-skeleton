module.exports = {
  env: {
    browser: true,
    node: true,
    es2021: true
  },
  parserOptions: {
    sourceType: "module"
  },
  overrides: [
    {
      files: "*.ts",
      parser: "@typescript-eslint/parser",
      plugins: ["@typescript-eslint", "import"],
      parserOptions: {
        project: "./tsconfig.json"
      },
      extends: [
        "eslint:recommended",
        "plugin:@typescript-eslint/recommended",
        "plugin:@typescript-eslint/eslint-recommended",
        "plugin:@typescript-eslint/recommended-requiring-type-checking",
        "plugin:import/typescript",
        "airbnb-typescript/base"
      ],
      rules: {
        "no-plusplus": "off",
        "no-underscore-dangle": "off",
        "import/prefer-default-export": "off",
        "comma-dangle": ["error", "never"],
        "@typescript-eslint/comma-dangle": ["error", "never"]
      }
    }
  ]
};
