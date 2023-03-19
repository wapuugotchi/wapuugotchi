# wapuugotchi

## setup

1. npm ci
1. npm run build
1. npm run env start

## tipps
### Use CLI
``npm run env run cli user list``

### Third party plugins
To provide custom items, you can add an url to retrieve new items.
Use
``` do_action('wapuugotchi_add_source' 'https://<URL_TO_YOUR_JSON>'); ```

Under this URL, a valid json-file is expetected, that follows the schema for wapuugotchi collections. Find more information on that schema at https://wapuugotchi.com

Please find an example for a valid JSON at https://api.wapuugotchi.com/collection


