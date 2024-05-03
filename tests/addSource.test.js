// @ts-check
const { test, expect } = require('@playwright/test')
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
});

test('collection is displayed', async ({page}) => {
	await page.goto('/wp-admin/admin.php?page=wapuugotchi', {waitUntil: 'networkidle'});
	await expect(await page.locator('.wapuugotchi_shop__category').count()).toBeGreaterThan(1);
	await expect(await page.locator('.wapuugotchi_shop__item').count()).toBeGreaterThan(1);
});
