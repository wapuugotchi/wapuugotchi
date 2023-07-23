// @ts-check
const { test, expect } = require('@playwright/test')
const TEST_USER = process.env.TEST_USER || 'admin'
const TEST_PASS = process.env.TEST_PASS || 'password'

test.describe('Shop', () => {

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

  test('page exists', async ({page}) => {
    /** enter page */
    await page.goto(' /wp-admin/admin.php?page=wapuugotchi', {waitUntil: 'networkidle'})
    await expect(page).toHaveTitle(/Wapuugotchi/)

    /** check if the core elements of the page are present. */
    await expect(page.locator('.wapuu_shop')).toBeVisible()
    await expect(page.locator('.wapuu_card')).toBeVisible()
    await expect(page.locator('.wapuu_card__categories')).toBeVisible()
    await expect(page.locator('.wapuu_card__items')).toBeVisible()
    const showRoom = await page.locator('.wapuu_show_room')
	await expect(page.locator('.wapuu_show_room')).toBeVisible()
    await expect(showRoom.locator('svg')).toHaveCount(1)
  })

  test('categories selectable', async ({page}) => {
    await page.goto(' /wp-admin/admin.php?page=wapuugotchi', {waitUntil: 'networkidle'})
    await expect(page).toHaveTitle(/Wapuugotchi/)

    /** loop through all the categories and try to select them */
    const selector = await page.locator('.wapuu_card__categories')
    const categories = ['caps','items','coats','balls', 'fur']
    for (const category of categories) {
      await expect(selector.locator('[data-category="' + category + '"]')).not.toHaveClass(/selected/)
      await selector.locator('[data-category="' + category + '"]').click()
      await expect(selector.locator('[data-category="' + category + '"]')).toHaveClass(/selected/)
    }
  })

  test.skip('items selectable', async ({page}) => {
    await page.goto(' /wp-admin/admin.php?page=wapuugotchi', {waitUntil: 'networkidle'})
    await expect(page).toHaveTitle(/Wapuugotchi/)

    /** select specific category */
    const categories = await page.locator('.wapuu_card__categories')
    await categories.locator('[data-category="caps"]').click()
    await expect(categories.locator('[data-category="caps"]')).toHaveClass(/selected/)

    /** select the first item and expect change in the mirror */
    const items = await page.locator('.wapuu_card__items')
    await items.locator(".wapuu_card__item").first().click()
    await expect(page.locator('.wapuu_show_room__image')).toHaveCount(3)
    await items.locator(".wapuu_card__item").first().click()
    await expect(page.locator('.wapuu_show_room__image')).toHaveCount(2)
  })

  test('cleanup executable', async ({page}) => {
    await page.goto(' /wp-admin/admin.php?page=wapuugotchi', {waitUntil: 'networkidle'})
    await expect(page).toHaveTitle(/Wapuugotchi/)

    /** select specific category */
    const categories = await page.locator('.wapuu_card__categories')
    await categories.locator('[data-category="caps"]').click()
    await expect(categories.locator('[data-category="caps"]')).toHaveClass(/selected/)

    /** Select the first item and run cleanup */
    const items = await page.locator('.wapuu_card__items')
	const showRoom = await page.locator('.wapuu_show_room')
    await items.locator(".wapuu_card__item").first().click()
	await expect(showRoom.locator('svg')).toHaveCount(1)
  })
})
