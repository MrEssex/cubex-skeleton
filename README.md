[![Maintainability](https://api.codeclimate.com/v1/badges/1bc8095f00307c1b6d76/maintainability)](https://codeclimate.com/github/MrEssex/cubex-base/maintainability)
[![Test Coverage](https://api.codeclimate.com/v1/badges/1bc8095f00307c1b6d76/test_coverage)](https://codeclimate.com/github/MrEssex/cubex-base/test_coverage)

# Cubex Base

Playground for Learning Cubex. I recommended this as a template to build off.

## Table of Contents

- [Cubex Base](#cubex-base)
    * [Table of Contents](#table-of-contents)
    * [Requirements](#requirements)
    * [Action Secrets](#action-secrets)
        + [Workflows in GitHub](#workflows-in-github)
            - [CC_TEST_REPORTER_ID](#cc-test-reporter-id)
            - [COMPOSER_AUTH_JSON](#composer-auth-json)
            - [PAT (Personal Access Token)](#pat--personal-access-token-)
        + [Workflows in CircleCI](#workflows-in-circleci)
            - [CC_TEST_REPORTER_ID](#cc-test-reporter-id-1)

## Requirements

- Composer
- Node with Yarn Package Manager
- php ^7.4
- ext-apcu enabled

## Action Secrets

### Workflows in GitHub

All the secrets for the CircleCi and Github Workflows to work. These all go
in https://github.com/{org}/{repo}/settings/secrets/actions

#### CC_TEST_REPORTER_ID

1. From your Code Climate Dashboard, choose the repository and choose the Settings tab from the repo's main navigation
   list.
2. Select the Test Coverage tab. Your test coverage ID will be displayed on the page.

#### COMPOSER_AUTH_JSON

1. Create a personal access token for the Github account you wish to authenticate with.
2. Add the following JSON to a new Github Secret called COMPOSER_AUTH_JSON:

```json
{
  "http-basic": {
    "github.com": {
      "username": "<YOUR_GITHUB_USERNAME>",
      "password": "<YOUR_PERSONAL_ACCESS_TOKEN>"
    }
  }
}
```

#### PAT (Personal Access Token)

1. Create a Personal Token from GitHub global settings (https://github.com/settings/tokens)
2. Make sure this token has user, read and write permission for user and packages.
3. Then added a new Environment variable ‘PAT’ pasted the generated token as its value.

### Workflows in CircleCI

#### CC_TEST_REPORTER_ID

1. From your Code Climate Dashboard, choose the repository and choose the Settings tab from the repo's main navigation
   list.
2. Select the Test Coverage tab. Your test coverage ID will be displayed on the page.
