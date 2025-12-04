// @ts-check
const { test, expect } = require( '@playwright/test' );

const TEST_USER = process.env.TEST_USER || 'admin';
const TEST_PASS = process.env.TEST_PASS || 'password';

test.beforeEach( async ( { page } ) => {
	await page.goto( '/wp-login.php', { waitUntil: 'networkidle' } );
	await expect( page ).toHaveTitle( /Log In/ );

	await page.fill( '#user_login', TEST_USER );
	await page.fill( '#user_pass', TEST_PASS );
	await page.click( '#wp-submit' );

	await page.waitForLoadState( 'networkidle' );
	await expect( page ).toHaveTitle( /Dashboard/ );
} );

test( 'Support page renders with cards and header', async ( { page } ) => {
	await page.goto( '/wp-admin/admin.php?page=wapuugotchi__support', {
		waitUntil: 'networkidle',
	} );

	await expect( page.locator( '.wapuugotchi-support__header h1' ) ).toHaveText(
		/Support & Feedback/i
	);

	await expect(
		await page.locator( '.wapuugotchi-support__card' ).count()
	).toBeGreaterThanOrEqual( 4 );
} );

test( 'Support page highlight card and buttons exist', async ( { page } ) => {
	await page.goto( '/wp-admin/admin.php?page=wapuugotchi__support', {
		waitUntil: 'networkidle',
	} );

	await expect(
		page.locator( '.wapuugotchi-support__card.is-highlight' )
	).toBeVisible();

	await expect(
		await page
			.locator( '.wapuugotchi-support__card .button' )
			.count()
	).toBeGreaterThanOrEqual( 3 );
} );
