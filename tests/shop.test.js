// @ts-check
const fs = require( 'fs' );
const { spawnSync } = require( 'node:child_process' );
const { test, expect } = require( '@playwright/test' );

const TEST_USER = process.env.TEST_USER || 'admin';
const TEST_PASS = process.env.TEST_PASS || 'password';

test.beforeEach( async ( { page } ) => {
	await page.goto( '/wp-login.php', { waitUntil: 'networkidle' } );
	await expect( page ).toHaveTitle( /Log In/ );

	/** initiate login process */
	await page.fill( '#user_login', TEST_USER );
	await page.fill( '#user_pass', TEST_PASS );
	await page.click( '#wp-submit' );

	/** correct redirect to dashboard */
	await page.waitForLoadState( 'networkidle' );
	await expect( page ).toHaveTitle( /Dashboard/ );
} );
test( 'categories and items are loaded', async ( { page } ) => {
	await page.goto( '/wp-admin/admin.php?page=wapuugotchi__shop', {
		waitUntil: 'networkidle',
	} );
	await expect(
		await page.locator( '.wapuugotchi_shop__category' ).count()
	).toBeGreaterThan( 1 );
	await expect(
		await page.locator( '.wapuugotchi_shop__item' ).count()
	).toBeGreaterThan( 1 );
} );

test( 'categories clickable', async ( { page } ) => {
	await page.goto( '/wp-admin/admin.php?page=wapuugotchi__shop', {
		waitUntil: 'networkidle',
	} );
	await expect( page ).toHaveTitle( /WapuuGotchi/ );
	await page
		.locator( '.wapuugotchi_shop__categories > div:nth-child(1)' )
		.click();
	await page.waitForSelector(
		'.wapuugotchi_shop__categories > div:nth-child(1).selected',
		{ state: 'visible' }
	);

	await page
		.locator( '.wapuugotchi_shop__categories > div:nth-child(2)' )
		.click();
	await page.waitForSelector(
		'.wapuugotchi_shop__categories > div:nth-child(2).selected',
		{ state: 'visible' }
	);
	await expect(
		page.locator( '.wapuugotchi_shop__categories > div:nth-child(1)' )
	).not.toHaveClass( /selected/ );

	await page
		.locator( '.wapuugotchi_shop__categories > div:nth-child(3)' )
		.click();
	await page.waitForSelector(
		'.wapuugotchi_shop__categories > div:nth-child(3).selected',
		{ state: 'visible' }
	);
	await expect(
		page.locator( '.wapuugotchi_shop__categories > div:nth-child(2)' )
	).not.toHaveClass( /selected/ );

	await page
		.locator( '.wapuugotchi_shop__categories > div:nth-child(4)' )
		.click();
	await page.waitForSelector(
		'.wapuugotchi_shop__categories > div:nth-child(4).selected',
		{ state: 'visible' }
	);
	await expect(
		page.locator( '.wapuugotchi_shop__categories > div:nth-child(3)' )
	).not.toHaveClass( /selected/ );
} );

test( 'items clickable', async ( { page } ) => {
	await page.goto( '/wp-admin/admin.php?page=wapuugotchi__shop', {
		waitUntil: 'networkidle',
	} );
	await expect( page ).toHaveTitle( /WapuuGotchi/ );
	await page.locator( '.wapuugotchi_shop__items > div:nth-child(1)' ).click();
	await page.waitForSelector(
		'.wapuugotchi_shop__items > div:nth-child(1).selected',
		{ state: 'visible' }
	);

	await page.locator( '.wapuugotchi_shop__items > div:nth-child(2)' ).click();
	await page.waitForSelector(
		'.wapuugotchi_shop__items > div:nth-child(2).selected',
		{ state: 'visible' }
	);
	await expect(
		page.locator( '.wapuugotchi_shop__items > div:nth-child(1)' )
	).not.toHaveClass( /selected/ );

	await page.locator( '.wapuugotchi_shop__items > div:nth-child(3)' ).click();
	await page.waitForSelector(
		'.wapuugotchi_shop__items > div:nth-child(3).selected',
		{ state: 'visible' }
	);
	await expect(
		page.locator( '.wapuugotchi_shop__items > div:nth-child(2)' )
	).not.toHaveClass( /selected/ );

	await page.locator( '.wapuugotchi_shop__items > div:nth-child(4)' ).click();
	await page.waitForSelector(
		'.wapuugotchi_shop__items > div:nth-child(4).selected',
		{ state: 'visible' }
	);
	await expect(
		page.locator( '.wapuugotchi_shop__items > div:nth-child(3)' )
	).not.toHaveClass( /selected/ );
} );

test( 'items purchasable', async ( { page } ) => {
	await page.goto( '/wp-admin/admin.php?page=wapuugotchi__shop', {
		waitUntil: 'networkidle',
	} );
	await expect( page ).toHaveTitle( /WapuuGotchi/ );
	await page.locator( '#category_caps' ).click();
	await expect(
		page.locator( '.wapuugotchi_shop__items > div:nth-child(2)' )
	).not.toHaveClass( /selected/ );
	await expect(
		page.locator( '.wapuugotchi_shop__items > div:nth-child(2)' )
	).not.toHaveClass( /free/ );
	await page.locator( '.wapuugotchi_shop__items > div:nth-child(2)' ).click();
	await page.waitForLoadState( 'networkidle' );
	await page.getByRole( 'button', { name: 'OK' } ).click();
	await page.waitForLoadState( 'networkidle' );
	await page.waitForSelector(
		'.wapuugotchi_shop__items > div:nth-child(2).free',
		{ state: 'visible' }
	);
	await page.locator( '.wapuugotchi_shop__items > div:nth-child(2)' ).click();
	await page.waitForLoadState( 'networkidle' );
	await page.waitForSelector(
		'.wapuugotchi_shop__items > div:nth-child(2).selected',
		{ state: 'visible' }
	);
} );
