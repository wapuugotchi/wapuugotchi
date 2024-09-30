/**
 * Adjusts the position and size of the story container element.
 *
 * @param {HTMLElement} storyContainer - The story container element to adjust.
 */
export const adjustStoryContainer = ( storyContainer ) => {
	const adminMenu = document.getElementById( 'adminmenuback' );
	const adminBar = document.getElementById( 'wpadminbar' );

	if ( adminMenu && adminBar && storyContainer ) {
		const adminMenuWidth = adminMenu.offsetWidth;
		const adminBarHeight = adminBar.offsetHeight;

		storyContainer.style.top = `${ adminBarHeight }px`;
		storyContainer.style.left = `${ adminMenuWidth }px`;
		storyContainer.style.bottom = `0`;
		storyContainer.style.right = `0`;
		storyContainer.style.position = 'fixed';
	}
};

/**
 * Sets up observers to monitor changes in the admin menu and admin bar,
 * and adjusts the story container accordingly.
 * @param {HTMLElement} storyContainer - The story container element to adjust.
 */
export const setupObservers = ( storyContainer ) => {
	const adminMenu = document.getElementById( 'adminmenuback' );
	const adminBar = document.getElementById( 'wpadminbar' );

	if ( adminMenu && adminBar ) {
		let lastAdminBarHeight = adminBar.offsetHeight;
		let lastAdminMenuWidth = adminMenu.offsetWidth;

		const resizeObserver = new ResizeObserver( () => {
			const currentAdminBarHeight = adminBar.offsetHeight;
			const currentAdminMenuWidth = adminMenu.offsetWidth;
			if (
				currentAdminBarHeight !== lastAdminBarHeight ||
				currentAdminMenuWidth !== lastAdminMenuWidth
			) {
				lastAdminBarHeight = currentAdminBarHeight;
				lastAdminMenuWidth = currentAdminMenuWidth;
				adjustStoryContainer( storyContainer );
			}
		} );
		resizeObserver.observe( adminMenu );
		resizeObserver.observe( adminBar );

		const mutationObserver = new MutationObserver( () => {
			adjustStoryContainer( storyContainer );
		} );
		mutationObserver.observe( adminMenu, {
			attributes: true,
			childList: true,
			subtree: true,
		} );
		mutationObserver.observe( adminBar, {
			attributes: true,
			childList: true,
			subtree: true,
		} );

		// Cleanup observers on component unmount
		return () => {
			resizeObserver.disconnect();
			mutationObserver.disconnect();
		};
	}
};
