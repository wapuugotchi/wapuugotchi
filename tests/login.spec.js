// @ts-check
const { test, expect } = require('@playwright/test');

test('Test login process', async ({ page }) => {
  await page.goto('http://localhost:8076/wp-login.php', { waitUntil: 'networkidle' });

  // Login process
  await expect(page).toHaveTitle(/Log In/);
  await page.fill('#user_login', 'admin');
  await page.fill('#user_pass', 'admin');
  await page.click('#wp-submit');
  await page.waitForLoadState('networkidle');
  await expect(page).toHaveTitle(/Dashboard/);

  // Is plugin active
  await page.goto('http://localhost:8076/wp-admin/plugins.php', { waitUntil: 'networkidle' });
  await expect(page).toHaveTitle(/Plugins/);
  const plugin = await page.getByRole('cell', { name: 'Wapuugotchi Deactivate Wapuugotchi' }).getByText('Wapuugotchi')
  await expect(plugin).toHaveCount(1)

  // the default wapuu is set on dashboard. (default wapuu)
  await page.goto('http://localhost:8076/wp-admin', { waitUntil: 'networkidle' });
  await expect(page).toHaveTitle(/Dashboard/);
  const wapuu = await page.locator('#wapuugotchi');
  await expect(wapuu).toHaveCount(1);
  await expect(wapuu.locator('img')).toHaveCount(2);


});