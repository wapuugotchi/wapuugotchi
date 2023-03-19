// @ts-check
const { test, expect } = require('@playwright/test')

const TEST_USER = process.env.TEST_USER || 'admin'
const TEST_PASS = process.env.TEST_PASS || 'password'

test.beforeEach(async ({page}) => {
  await page.goto( '/wp-login.php' );
  await page.fill( 'input[name="log"]', TEST_USER );
  await page.fill( 'input[name="pwd"]', TEST_PASS );
  await page.click( 'input[type="submit"]' );
});

test('external collection is displayed', async ({page}) => {
  await page.goto( '/wp-admin/admin.php?page=wapuugotchi' );
  await expect( await page.locator( '.wapuu_card__item' ).count() ).toBeGreaterThan( 1 );
});
