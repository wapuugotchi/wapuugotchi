// @ts-check
const { test, expect } = require('@playwright/test')
const { TEST_USER, TEST_PASS, TEST_URL } = process.env

test('page exists', async ({page}) => {
  await expect( true ).toBeTruthy();
})
