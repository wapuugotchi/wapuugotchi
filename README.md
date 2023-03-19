# wapuugotchi

## setup

1. `nvm use` (or `nvm install` if the node version is not yet locally available)
1. `npm ci`
1. `npm run build`
1. `npm run env start`
  
  To start WordPress it with xdebug support : `npm run env start -- --xdebug`

## tipps
### Use CLI
``npm run env run cli user list``


### Third party plugins
To provide custom items, you can add an url to retrieve new items. You can call the wapuugotchi_add_source action at first on admin_init, with a higher priority than ten.
Use
```
add_action( 'admin_init', function() {
    do_action('wapuugotchi_add_source' 'https://<URL_TO_YOUR_JSON>');
}, 20 );
```

Under this URL, a valid json-file is expetected, that follows the schema for wapuugotchi collections. Find more information on that schema at https://wapuugotchi.com

Please find an example for a valid JSON at https://api.wapuugotchi.com/collection

