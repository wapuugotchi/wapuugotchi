# wapuugotchi

## setup

1. `nvm use` (or `nvm install` if the node version is not yet locally available)
1. `npm ci --no-fund`
1. `npm run build`
1. `npm run env start`

To start WordPress it with xdebug support : `npm run env start -- --xdebug`

## tips

### Use CLI

`npm run env run cli user list`

### Use tests

Run `npm test`.open .

Under this URL, a valid json-file is expected, that follows the schema for wapuugotchi collections. Find more information on that schema at [https://wapuugotchi.com](https://wapuugotchi.com)

Please find an example for a valid JSON at [https://api.wapuugotchi.com/collection](https://api.wapuugotchi.com/collection)

### Generate translation files

```bash
$wp i18n make-mo languages/ languages/
$wp i18n make-json languages --no-purge --pretty-print
