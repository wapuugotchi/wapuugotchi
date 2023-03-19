// @ts-check
const { spawnSync } = require('node:child_process');
const { test, expect } = require('@playwright/test')

const TEST_USER = process.env.TEST_USER || 'admin'
const TEST_PASS = process.env.TEST_PASS || 'password'


test('collection is displayed', async ({page}) => {
  await login( page )
  await page.goto( '/wp-admin/admin.php?page=wapuugotchi' );
  await expect( await page.locator( '.wapuu_card__item' ).count() ).toBeGreaterThan( 1 );
});

test.skip('user has one post posted', async ({page}) => {
  wpcommand('post create -- --post_type=post --post_title="Test Post" --post_status=publish');
  //clean();
  await login( page )
  await page.goto( '/wp-admin/' );
  await expect( await page.locator( '#wapuugotchi' ) ).toContainText( 'Danke für deine Beiträge!' );
});


///////////////////////////////////////////////
// Helpers
///////////////////////////////////////////////

/**
 * Cleans the test instance.
 */
function clean() {
  const result = spawnSync('npm', 'run env clean'.split(' '));

  if (result.status !== 0) {
    throw "Clean operation failed.";
  }
}

/**
 * Runs a WP-CLI command.
 * @param {string} command WP-CLI command without wp prefix.
 * @returns Output of the command.
 */
function wpcommand( command ) {
  const result = spawnSync('npm', [ 'run', 'env', 'run', 'tests-cli' ].concat(command.split(' ')));

  if (result.status !== 0) {
    throw "WP-CLI command failed.";
  }
  
  return result.stdout.toString();
}

/**
 * Login to the WordPress site.
 * @param object page Page object from playwright.
 */
async function login( page ) {
  await page.goto( '/wp-login.php' );
  await page.fill( 'input[name="log"]', TEST_USER );
  await page.fill( 'input[name="pwd"]', TEST_PASS );
  await page.click( 'input[type="submit"]' );
}
