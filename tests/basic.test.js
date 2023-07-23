// @ts-check
const { test, expect } = require('@playwright/test')
const TEST_USER = process.env.TEST_USER || 'admin'
const TEST_PASS = process.env.TEST_PASS || 'password'

test.describe('basic', () => {
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

  test('plugin active', async ({page}) => {
    await page.goto('/wp-admin/plugins.php', {waitUntil: 'networkidle'})
    await expect(page).toHaveTitle(/Plugins/)

    /** check if the plugin is activated */
    const plugin = page.locator('[data-slug="wapuugotchi"]')
    await expect(plugin).toHaveClass('active')
  })

  test('menu exist', async ({page}) => {
    await page.goto('/wp-admin/', {waitUntil: 'networkidle'})
    await expect(page).toHaveTitle(/Dashboard/)

    /** menu element is clickable and the page is accessible */
    const menu = await page.locator('.wp-menu-name').getByText('Wapuugotchi')
    await expect(menu).toBeVisible();
    await menu.click()
    await page.waitForLoadState('networkidle')
    await expect(page).toHaveTitle(/Wapuugotchi/)
  })
})
