// @ts-check
const { test, expect } = require('@playwright/test')
const { TEST_USER, TEST_PASS, TEST_URL } = process.env
test.describe('Shop', () => {
  test.beforeEach(async ({page}) => {
    /** enter page */
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
    await expect(page.locator('.wapuu_show_room')).toBeVisible()
    await expect(page.locator('.wapuu_show_room__image')).not.toHaveCount(0)
  })

  test('categories selectable', async ({page}) => {
    /** enter page */
    await page.goto(' /wp-admin/admin.php?page=wapuugotchi', {waitUntil: 'networkidle'})
    await expect(page).toHaveTitle(/Wapuugotchi/)

    /** loop through all the categories and try to select them */
    const selector = await page.locator('.wapuu_card__categories')
    const categories = ['cap','item','coat','pant','ball', 'fur']
    for (const category of categories) {
      await expect(selector.locator('[category="' + category + '"]')).not.toHaveClass(/selected/)
      await selector.locator('[category="' + category + '"]').click()
      await expect(selector.locator('[category="' + category + '"]')).toHaveClass(/selected/)
    }
  })

  test('items selectable', async ({page}) => {
    /** enter page */
    await page.goto(' /wp-admin/admin.php?page=wapuugotchi', {waitUntil: 'networkidle'})
    await expect(page).toHaveTitle(/Wapuugotchi/)

    /** select specific category */
    const categories = await page.locator('.wapuu_card__categories')
    await categories.locator('[category="cap"]').click()
    await expect(categories.locator('[category="cap"]')).toHaveClass(/selected/)

    /** select the first item and expect change in the mirror */
    const items = await page.locator('.wapuu_card__items')
    await items.locator(".wapuu_card__item").first().click()
    await expect(page.locator('.wapuu_show_room__image')).toHaveCount(3)
    await items.locator(".wapuu_card__item").first().click()
    await expect(page.locator('.wapuu_show_room__image')).toHaveCount(2)
  })

  test('cleanup executable', async ({page}) => {
    /** enter page */
    await page.goto(' /wp-admin/admin.php?page=wapuugotchi', {waitUntil: 'networkidle'})
    await expect(page).toHaveTitle(/Wapuugotchi/)

    /** select specific category */
    const categories = await page.locator('.wapuu_card__categories')
    await categories.locator('[category="cap"]').click()
    await expect(categories.locator('[category="cap"]')).toHaveClass(/selected/)

    /** Select the first item and run cleanup */
    const items = await page.locator('.wapuu_card__items')
    await items.locator(".wapuu_card__item").first().click()
    await expect(page.locator('.wapuu_show_room__image')).toHaveCount(3)
    await page.click('button.wapuu_shop__reset')
    await expect(page.locator('.wapuu_show_room__image')).toHaveCount(2)
  })
})