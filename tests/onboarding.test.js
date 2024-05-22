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

test( 'tour is executable an complete', async ( { page } ) => {
	await page.goto( '/wp-admin/admin.php?page=wapuugotchi__tour', {
		waitUntil: 'networkidle',
	} );
	await expect( page ).toHaveTitle( /WapuuGotchi/ );
	await expect(
		await page
			.locator(
				'#wapuugotchi_onboarding__overlay #wapuugotchi_onboarding__navigation'
			)
			.count()
	).toBe( 1 );
	await expect(
		await page
			.locator(
				'#wapuugotchi_onboarding__overlay .wapuugotchi_onboarding__guide_text'
			)
			.count()
	).toBe( 1 );
	await expect(
		await page.locator( '#wapuugotchi_onboarding__overlay svg' ).count()
	).toBe( 1 );

	await expect(
		await page
			.locator(
				'#wapuugotchi_onboarding__overlay .wapuugotchi_onboarding__focus'
			)
			.count()
	).toBe( 1 );
	await expect(
		await page
			.locator(
				'#wapuugotchi_onboarding__overlay .wapuugotchi_onboarding__focus_overlay'
			)
			.count()
	).toBe( 1 );
} );

test( 'navigation is initiated', async ( { page } ) => {
	await page.goto( '/wp-admin/admin.php?page=wapuugotchi__tour', {
		waitUntil: 'networkidle',
	} );
	await expect( page ).toHaveTitle( /WapuuGotchi/ );
	await expect(
		await page
			.locator(
				'#wapuugotchi_onboarding__overlay #wapuugotchi_onboarding__navigation'
			)
			.count()
	).toBe( 1 );

	await page.waitForSelector(
		'#wapuugotchi_onboarding__navigation .wapuugotchi_onboarding__navigation_stop',
		{ state: 'visible' }
	);
	await page.waitForSelector(
		'#wapuugotchi_onboarding__navigation .wapuugotchi_onboarding__navigation_last',
		{ state: 'visible' }
	);
	await page.waitForSelector(
		'#wapuugotchi_onboarding__navigation .wapuugotchi_onboarding__navigation_play',
		{ state: 'visible' }
	);
	await page.waitForSelector(
		'#wapuugotchi_onboarding__navigation .wapuugotchi_onboarding__navigation_next',
		{ state: 'visible' }
	);

	await expect(
		await page.locator(
			'#wapuugotchi_onboarding__navigation .wapuugotchi_onboarding__navigation_stop span'
		)
	).not.toHaveClass( /disabled/ );
	await expect(
		await page.locator(
			'#wapuugotchi_onboarding__navigation .wapuugotchi_onboarding__navigation_last span'
		)
	).toHaveClass( /disabled/ );
	await expect(
		await page.locator(
			'#wapuugotchi_onboarding__navigation .wapuugotchi_onboarding__navigation_play span'
		)
	).toHaveClass( /disabled/ );
	await expect(
		await page.locator(
			'#wapuugotchi_onboarding__navigation .wapuugotchi_onboarding__navigation_next span'
		)
	).not.toHaveClass( /disabled/ );
} );

test( 'tour is closeable', async ( { page } ) => {
	await page.goto( '/wp-admin/admin.php?page=wapuugotchi__tour', {
		waitUntil: 'networkidle',
	} );
	await expect( page ).toHaveTitle( /WapuuGotchi/ );
	await expect(
		await page
			.locator(
				'#wapuugotchi_onboarding__overlay #wapuugotchi_onboarding__navigation'
			)
			.count()
	).toBe( 1 );
	await expect(
		await page
			.locator(
				'#wapuugotchi_onboarding__navigation .wapuugotchi_onboarding__navigation_stop'
			)
			.count()
	).toBe( 1 );
	await page
		.locator(
			'#wapuugotchi_onboarding__navigation .wapuugotchi_onboarding__navigation_stop'
		)
		.click( { waitUntil: 'networkidle' } );
	await expect( page ).toHaveTitle( /Dashboard/ );
} );

test.only( 'step forward and backwards works', async ( { page } ) => {
	await page.goto( '/wp-admin/admin.php?page=wapuugotchi__tour', {
		waitUntil: 'networkidle',
	} );
	await expect( page ).toHaveTitle( /WapuuGotchi/ );
	await expect(
		await page
			.locator(
				'#wapuugotchi_onboarding__overlay #wapuugotchi_onboarding__navigation'
			)
			.count()
	).toBe( 1 );

	await expect(
		await page.locator(
			'#wapuugotchi_onboarding__navigation .wapuugotchi_onboarding__navigation_last span'
		)
	).toHaveClass( /disabled/ );
	await expect(
		await page.locator(
			'#wapuugotchi_onboarding__navigation .wapuugotchi_onboarding__navigation_next span'
		)
	).not.toHaveClass( /disabled/ );

	await page
		.locator(
			'#wapuugotchi_onboarding__navigation .wapuugotchi_onboarding__navigation_next'
		)
		.click();
	await expect(
		await page.locator(
			'#wapuugotchi_onboarding__navigation .wapuugotchi_onboarding__navigation_last span'
		)
	).not.toHaveClass( /disabled/ );
	await expect(
		await page.locator(
			'#wapuugotchi_onboarding__navigation .wapuugotchi_onboarding__navigation_next span'
		)
	).not.toHaveClass( /disabled/ );

	await page
		.locator(
			'#wapuugotchi_onboarding__navigation .wapuugotchi_onboarding__navigation_last'
		)
		.click();
	await expect(
		await page.locator(
			'#wapuugotchi_onboarding__navigation .wapuugotchi_onboarding__navigation_last span'
		)
	).toHaveClass( /disabled/ );
	await expect(
		await page.locator(
			'#wapuugotchi_onboarding__navigation .wapuugotchi_onboarding__navigation_next span'
		)
	).not.toHaveClass( /disabled/ );
} );
