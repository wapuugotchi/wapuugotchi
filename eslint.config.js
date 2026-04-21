const wpPlugin = require( '@wordpress/eslint-plugin' );
const globals = require( 'globals' );

module.exports = [
	{
		ignores: [
			'**/.cache/**',
			'**/build/**',
			'**/node_modules/**',
			'**/vendor/**',
			'**/tests/**',
			'wp-env-home',
			'playwright.config.js',
			'src/util/whydidyouupdate.js',
		],
	},
	...wpPlugin.configs.recommended,
	{
		languageOptions: {
			globals: {
				...globals.browser,
				...globals.commonjs,
				...globals.es2021,
			},
		},
		rules: {
			'jsx-a11y/no-static-element-interactions': 'off',
			'jsx-a11y/click-events-have-key-events': 'off',
			'jsx-a11y/alt-text': 'off',
			'@wordpress/no-unsafe-wp-apis': 'off',
			'@wordpress/i18n-text-domain': [
				'error',
				{ allowedTextDomain: 'wapuugotchi' },
			],
		},
	},
];
