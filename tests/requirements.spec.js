// @ts-check
const { test, expect } = require('@playwright/test');
const { TEST_USER, TEST_PASS, TEST_URL } = process.env;

test.beforeEach(async ({ page }) => {
  // Login process
  await page.goto(TEST_URL + '/wp-login.php', { waitUntil: 'networkidle' });
  await expect(page).toHaveTitle(/Log In/);
  await page.fill('#user_login', TEST_USER);
  await page.fill('#user_pass', TEST_PASS);
  await page.click('#wp-submit');
  await page.waitForLoadState('networkidle');
  await expect(page).toHaveTitle(/Dashboard/);
});

test('Is plugin active', async ({ page }) => {
  console.log(`Is plugin active`);
  // Is plugin active
  await page.goto('http://localhost:8076/wp-admin/plugins.php', { waitUntil: 'networkidle' });
  await expect(page).toHaveTitle(/Plugins/);
  const plugin = page.locator('[data-slug="wapuugotchi"][data-plugin="wapuugotchi/wapuugotchi.php"]');
  await expect(plugin).toHaveClass('active')
});

test('does wapuu exist', async ({ page }) => {
  console.log(`does wapuu exist`);
  // the default wapuu is set on dashboard. (default wapuu)
  await page.goto('http://localhost:8076/wp-admin', { waitUntil: 'networkidle' });
  await expect(page).toHaveTitle(/Dashboard/);
  const wapuu = await page.locator('#wapuugotchi');
  await expect(wapuu).toHaveCount(1);
  await expect(wapuu.locator('img')).toHaveCount(2);
});

test('does menu exist', async ({ page }) => {
  console.log(`does menu exist`);
  const menu = await page.locator('.wp-menu-name').getByText('Wapuugotchi');
  await expect(menu).toHaveCount(1);
  await menu.click();
  await expect(page).toHaveTitle(/Wapuugotchi/);
});