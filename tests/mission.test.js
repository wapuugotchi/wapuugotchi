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

test( 'Mission - Map exists', async ( { page } ) => {
	await page.goto( '/wp-admin/admin.php?page=wapuugotchi', {
		waitUntil: 'networkidle',
	} );
	await expect( page ).toHaveTitle( /WapuuGotchi/ );
	await page.waitForSelector( '.wapuugotchi_missions__map svg', {
		state: 'visible',
	} );

	await expect(
		await page.locator( '.wapuugotchi_missions__map svg #mission_1' )
	).toHaveClass( /active/ );
	await expect(
		await page.locator( '.wapuugotchi_missions__map svg #mission_2' )
	).not.toHaveClass( /active/ );
	await expect(
		await page.locator( '.wapuugotchi_missions__map svg #mission_3' )
	).not.toHaveClass( /active/ );
	await expect(
		await page.locator( '.wapuugotchi_missions__map svg #mission_4' )
	).not.toHaveClass( /active/ );
	await expect(
		await page.locator( '.wapuugotchi_missions__map svg #mission_5' )
	).not.toHaveClass( /active/ );
} );

test( 'Mission - misstion story exists', async ( { page } ) => {
	await page.goto( '/wp-admin/admin.php?page=wapuugotchi', {
		waitUntil: 'networkidle',
	} );
	await expect( page ).toHaveTitle( /WapuuGotchi/ );

	const description = page.locator(
		'.wapuugotchi_missions__description p'
	);
	await expect( description ).toBeVisible();
	await expect( description ).not.toHaveText( '' );
} );

test( 'Mission - progress element exists', async ( { page } ) => {
	await page.goto('/wp-admin/admin.php?page=wapuugotchi', {
		waitUntil: 'networkidle',
	});
	await expect(page).toHaveTitle(/WapuuGotchi/);
	const progressPill = page.locator('.wapuugotchi_missions__pill');
	await expect(progressPill).toBeVisible();
	await expect(progressPill).toContainText(/checkpoints unlocked/i);
} );

test( 'Mission - Game is callable', async ( { page } ) => {
	await page.goto( '/wp-admin/admin.php?page=wapuugotchi', {
		waitUntil: 'networkidle',
	} );
	await expect( page ).toHaveTitle( /WapuuGotchi/ );
	await expect(
		await page.locator( '.wapuugotchi_mission__overlay' )
	).toHaveClass( /hidden/ );
	await page
		.locator( '#mission_section .active' )
		.click( { waitUntil: 'networkidle' } );
	await expect(
		await page.locator( '.wapuugotchi_mission__overlay' )
	).not.toHaveClass( /hidden/ );
} );
