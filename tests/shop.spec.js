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
test('shop exists', async ({ page }) => {
  console.log(`shop exists`);
  await page.goto('http://localhost:8076/wp-admin/admin.php?page=wapuugotchi', { waitUntil: 'networkidle' });
  await expect(page).toHaveTitle(/Wapuugotchi/);
  await expect(page.locator('.wapuu_shop')).toHaveCount(1);
  await expect(page.locator('.wapuu_card')).toHaveCount(1);
  await expect(page.locator('.wapuu_card__categories')).toHaveCount(1);
  await expect(page.locator('.wapuu_card__items')).toHaveCount(1);
  await expect(page.locator('.wapuu_show_room')).toHaveCount(1);
  await expect(page.locator('.wapuu_show_room__image')).toHaveCount(2);
});
test('shop categories selectable', async ({ page }) => {
  console.log(`shop categories selectable`);
  await page.goto('http://localhost:8076/wp-admin/admin.php?page=wapuugotchi', { waitUntil: 'networkidle' });
  await expect(page).toHaveTitle(/Wapuugotchi/);
  const categories = await page.locator('.wapuu_card__categories');
  await expect(categories.locator('[category="fur"]')).toHaveClass(/selected/);
  await expect(categories.locator('[category="cap"]')).not.toHaveClass(/selected/);
  await categories.locator('[category="cap"]').click();
  await expect(categories.locator('[category="cap"]')).toHaveClass(/selected/);
  await expect(categories.locator('[category="item"]')).not.toHaveClass(/selected/);
  await categories.locator('[category="item"]').click();
  await expect(categories.locator('[category="item"]')).toHaveClass(/selected/);
  await expect(categories.locator('[category="coat"]')).not.toHaveClass(/selected/);
  await categories.locator('[category="coat"]').click();
  await expect(categories.locator('[category="coat"]')).toHaveClass(/selected/);
  await expect(categories.locator('[category="pant"]')).not.toHaveClass(/selected/);
  await categories.locator('[category="pant"]').click();
  await expect(categories.locator('[category="pant"]')).toHaveClass(/selected/);
  await expect(categories.locator('[category="shoe"]')).not.toHaveClass(/selected/);
  await categories.locator('[category="shoe"]').click();
  await expect(categories.locator('[category="shoe"]')).toHaveClass(/selected/);
  await expect(categories.locator('[category="ball"]')).not.toHaveClass(/selected/);
  await categories.locator('[category="ball"]').click();
  await expect(categories.locator('[category="ball"]')).toHaveClass(/selected/);
});
test('shop item select', async ({ page }) => {
  console.log(`shop item select`);
  await page.goto('http://localhost:8076/wp-admin/admin.php?page=wapuugotchi', { waitUntil: 'networkidle' });
  await expect(page).toHaveTitle(/Wapuugotchi/);
  const categories = await page.locator('.wapuu_card__categories');
  await categories.locator('[category="cap"]').click();
  await expect(categories.locator('[category="cap"]')).toHaveClass(/selected/);

  const items = await page.locator('.wapuu_card__items');
  await expect(page.locator('.wapuu_show_room__image')).toHaveCount(2);
  await items.locator(".wapuu_card__item").first().click();
  await expect(page.locator('.wapuu_show_room__image')).toHaveCount(3)
  await items.locator(".wapuu_card__item").first().click();
  await expect(page.locator('.wapuu_show_room__image')).toHaveCount(2)
});
test('shop config cleanup', async ({ page }) => {
  console.log(`shop config cleanup`);
  await page.goto('http://localhost:8076/wp-admin/admin.php?page=wapuugotchi', { waitUntil: 'networkidle' });
  await expect(page).toHaveTitle(/Wapuugotchi/);
  const categories = await page.locator('.wapuu_card__categories');
  await categories.locator('[category="cap"]').click();
  await expect(categories.locator('[category="cap"]')).toHaveClass(/selected/);

  const items = await page.locator('.wapuu_card__items');
  await expect(page.locator('.wapuu_show_room__image')).toHaveCount(2);
  await items.locator(".wapuu_card__item").first().click();
  await expect(page.locator('.wapuu_show_room__image')).toHaveCount(3)
  await page.click('button.wapuu_shop__reset')
  await expect(page.locator('.wapuu_show_room__image')).toHaveCount(2)
});