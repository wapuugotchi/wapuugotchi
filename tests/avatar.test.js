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

test( 'Check if avatar exists', async ( { page } ) => {
	await page.waitForSelector( '#wapuugotchi__avatar .wapuugotchi__svg svg', {
		state: 'visible',
	} );
} );

test( 'Check if bubble is displayed', async ( { page } ) => {
	await page.waitForSelector( '#wapuugotchi__avatar .wapuugotchi__bubble', {
		state: 'visible',
	} );
} );
