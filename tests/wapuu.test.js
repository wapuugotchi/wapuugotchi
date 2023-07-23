// @ts-check
const { test, expect } = require('@playwright/test')
const TEST_USER = process.env.TEST_USER || 'admin'
const TEST_PASS = process.env.TEST_PASS || 'password'

test.describe('avatar', () => {
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

  test('avatar exist', async ({page}) => {
    await page.goto('/wp-admin/', {waitUntil: 'networkidle'})
    await expect(page).toHaveTitle(/Dashboard/)
    const wapuu = await page.locator('#wapuugotchi__avatar')
    await expect(wapuu).toHaveCount(1)
    await expect(wapuu.locator('svg')).toHaveCount(1)
  })
})
