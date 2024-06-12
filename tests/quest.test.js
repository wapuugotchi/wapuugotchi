// @ts-check
const fs = require('fs');
const { spawnSync } = require('node:child_process');
const { test, expect } = require('@playwright/test');

const TEST_USER = process.env.TEST_USER || 'admin';
const TEST_PASS = process.env.TEST_PASS || 'password';

test.beforeEach(async ({ page }) => {
	await page.goto('/wp-login.php', { waitUntil: 'networkidle' });
	await expect(page).toHaveTitle(/Log In/);

	/** initiate login process */
	await page.fill('#user_login', TEST_USER);
	await page.fill('#user_pass', TEST_PASS);
	await page.click('#wp-submit');

	/** correct redirect to dashboard */
	await page.waitForLoadState('networkidle');
	await expect(page).toHaveTitle(/Dashboard/);
});

test('Active quests are displayed', async ({ page }) => {
	await page.goto('/wp-admin/admin.php?page=wapuugotchi__quests', { waitUntil: 'networkidle' });
	await expect(page).toHaveTitle(/WapuuGotchi/);
	await expect(await page.locator('.wapuugotchi_log__item.wapuugotchi_log__active').count()).toBeGreaterThan(0);
});

test('Completed quests are displayed', async ({ page }) => {
	await page.goto('/wp-admin/admin.php?page=wapuugotchi__quests', { waitUntil: 'networkidle' });
	await expect(page).toHaveTitle(/WapuuGotchi/);
	await expect(await page.locator('.wapuugotchi_log__item.wapuugotchi_log__completed').count()).toBeGreaterThan(0);
});

test('Check ', async ({ page }) => {
	await page.goto('/wp-admin/admin.php?page=wapuugotchi__quests', { waitUntil: 'networkidle' });
	await expect(page).toHaveTitle(/WapuuGotchi/);
	await page.waitForSelector('.wapuugotchi__bubble', { state: 'visible' });
	await expect(await page.locator('#wapuugotchi__avatar .wapuugotchi__bubble').textContent()).toMatch(/Thank you for giving me a home!/);
});



