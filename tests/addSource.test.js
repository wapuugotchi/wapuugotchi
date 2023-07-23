// @ts-check
const fs = require('fs');
const { spawnSync } = require('node:child_process');
const { test, expect } = require('@playwright/test');

const TEST_USER = process.env.TEST_USER || 'admin'
const TEST_PASS = process.env.TEST_PASS || 'password'

test.beforeEach(async ({page}) => {
	await page.goto( '/wp-login.php', {waitUntil: 'networkidle'})
	await expect(page).toHaveTitle(/Log In/)

	/** initiate login process */
	await page.fill('#user_login', TEST_USER)
	await page.fill('#user_pass', TEST_PASS)
	await page.click('#wp-submit')

	/** correct redirect to dashboard */
	await page.waitForLoadState('networkidle')
	await expect(page).toHaveTitle(/Dashboard/)
})
test('collection is displayed', async ({page}) => {
  await page.goto( '/wp-admin/admin.php?page=wapuugotchi' );
  await expect( await page.locator( '.wapuu_card__item' ).count() ).toBeGreaterThan( 1 );
});

test.skip('set config', async ({page}) => {
  setTransientFromJSONFile( 'Foo', 'tests/config.json' );
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

/**
 * Sets transient from a file on local filesystem.
 * JSON will be converted to transient object.
 *
 * @param {string} name Name of the transient.
 * @param {string} filePath Path to JSON file.
 *
 */
function setTransientFromJSONFile( name, filePath ) {
  console.log( `Setting config ${filePath}` );
  const config = fs.readFileSync( filePath ).toString();
  const transient = {
    last_checked: Date.now(),
    data: JSON.parse( config )
  };
  const jsonString = JSON.stringify( transient ).replace( /"/g, '\\"' );
  wpcommand( `option update _transient_${name} "${jsonString}" -- --format=json` );
}
