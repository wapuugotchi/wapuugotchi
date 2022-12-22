// @ts-check
const { test, expect } = require('@playwright/test');

test.beforeEach(async ({ page }) => {
  // Login process
  await page.goto('http://localhost:8076/wp-login.php', { waitUntil: 'networkidle' });
  await expect(page).toHaveTitle(/Log In/);
  await page.fill('#user_login', 'admin');
  await page.fill('#user_pass', 'admin');
  await page.click('#wp-submit');
  await page.waitForLoadState('networkidle');
  await expect(page).toHaveTitle(/Dashboard/);
});

test('Is plugin active', async ({ page }) => {
  // Is plugin active
  await page.goto('http://localhost:8076/wp-admin/plugins.php', { waitUntil: 'networkidle' });
  await expect(page).toHaveTitle(/Plugins/);
  const plugin = page.locator('[data-slug="wapuugotchi"][data-plugin="wapuugotchi/wapuugotchi.php"]');
  await expect(plugin).toHaveClass('active')
});

test('does wapuu exist', async ({ page }) => {
  // the default wapuu is set on dashboard. (default wapuu)
  await page.goto('http://localhost:8076/wp-admin', { waitUntil: 'networkidle' });
  await expect(page).toHaveTitle(/Dashboard/);
  const wapuu = await page.locator('#wapuugotchi');
  await expect(wapuu).toHaveCount(1);
  await expect(wapuu.locator('img')).toHaveCount(1);
});