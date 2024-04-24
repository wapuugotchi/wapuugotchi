import './navigation.scss';
import { dispatch, useSelect } from '@wordpress/data';
import { STORE_NAME } from '../store';
import { useEffect } from '@wordpress/element';
import GlobalNavigation from './global-navigation';

export default function Navigation() {
	const { index, pageConfig, nextPage } = useSelect( ( select ) => {
		return {
			index: select( STORE_NAME ).getIndex(),
			pageConfig: select( STORE_NAME ).getPageConfig(),
			nextPage: select( STORE_NAME ).getNextPage(),
		};
	} );

	useEffect( () => {
		window.onkeyup = ( e ) => {
			if ( isGutenbergGuideActive() === true ) {
				e.preventDefault();
				e.stopPropagation();
				switch ( e.key ) {
					case 'ArrowRight':
						nextStep();
						break;
					case 'ArrowLeft':
						lastStep();
						break;
					case 'Escape':
						stop();
						break;
					case ' ':
						startAnimation();
						break;
				}
			}
		};
	} );

	const isGutenbergGuideActive = () => {
		if (
			wp?.data
				?.select( 'core/edit-post' )
				?.isFeatureActive( 'welcomeGuide' ) !== true
			//&& wp?.data?.select( 'core/preferences' )?.get( 'core/edit-widgets', 'welcomeGuide' ) !== true
		) {
			return true;
		}
		return false;
	};

	const getIndex = () => {
		const pageKeyList = Object.keys( pageConfig );
		return pageKeyList?.indexOf( index?.toString() );
	};

	const fadeOut = () => {
		const fadeOutElement = document.getElementById( 'wapuugotchi__avatar' );
		if ( ! fadeOutElement ) {
			return false;
		}
		const fadeOutEffect = setInterval( function () {
			if ( ! fadeOutElement.style.opacity ) {
				fadeOutElement.style.opacity = 1;
			}
			if ( fadeOutElement.style.opacity > 0 ) {
				fadeOutElement.style.opacity -= 0.1;
			} else {
				clearInterval( fadeOutEffect );
			}
		}, 10 );

		return true;
	};
	fadeOut();

	const nextStep = () => {
		const keyList = Object.keys( pageConfig );
		const indexPosition = keyList?.indexOf( index.toString() );

		if ( indexPosition >= 0 && keyList?.length > indexPosition ) {
			const nextIndex = keyList[ indexPosition + 1 ];
			const button = document.querySelector(
				'button.wapuugotchi_onboarding__navigation_next span'
			);
			if ( pageConfig?.[ nextIndex ] !== undefined ) {
				if ( button.classList.contains( 'disabled' ) === false ) {
					dispatch( STORE_NAME ).setIndex( nextIndex );
				}
			} else if ( typeof nextPage === 'string' ) {
				redirectToPage( nextPage );
			} else {
				stop();
			}
		}
	};

	const lastStep = () => {
		const keyList = Object.keys( pageConfig );
		const indexPosition = keyList?.indexOf( index.toString() );

		if ( indexPosition > 0 ) {
			const nextIndex = keyList[ indexPosition - 1 ];
			const button = document.querySelector(
				'button.wapuugotchi_onboarding__navigation_last span'
			);
			if ( pageConfig?.[ nextIndex ] !== undefined ) {
				if ( button.classList.contains( 'disabled' ) === false ) {
					dispatch( STORE_NAME ).setIndex( nextIndex );
				}
			}
		}
	};
	const redirectToPage = ( file = '' ) => {
		if ( ! file ) {
			return false;
		}

		const dir = window.location.href.substring(
			0,
			window.location.href.lastIndexOf( 'wp-admin' )
		);
		const url = new URL( dir + 'wp-admin/' + file );
		url.searchParams.append( 'onboarding_mode', 'tour' );
		window.location = url.toString();
		return true;
	};

	const stop = () => {
		const dir = window.location.href.substring(
			0,
			window.location.href.lastIndexOf( 'wp-admin' )
		);
		const url = new URL( dir + 'wp-admin/' );
		window.location = url.toString();
	};

	const startAnimation = () => {
		if ( getTargetsCount() > 1 ) {
			dispatch( STORE_NAME ).setAnimated( true );
			handleLoader();
		}
	};

	const getTargetsCount = () => {
		let count = 0;
		if ( Array.isArray( pageConfig?.[ index ]?.target_list ) ) {
			count = pageConfig[ index ].target_list.length;
		}
		return count;
	};

	const handleLoader = () => {
		// Loader handling
		const loader = document.querySelector(
			'.wapuugotchi_onboarding__loader'
		);
		const nextButton = document.querySelector(
			'button.wapuugotchi_onboarding__navigation_next span'
		);
		const lastButton = document.querySelector(
			'button.wapuugotchi_onboarding__navigation_last span'
		);
		const playButton = document.querySelector(
			'button.wapuugotchi_onboarding__navigation_play'
		);
		if (
			Number.isInteger( pageConfig?.[ index ]?.freeze ) &&
			pageConfig?.[ index ]?.freeze > 0
		) {
			//show loader and disable next and last button
			loader.style.display = 'block';
			nextButton.classList.add( 'disabled' );
			lastButton.classList.add( 'disabled' );
			playButton.classList.add( 'invisible' );
			setTimeout( function () {
				//hide loader and enable next and last button
				loader.style.display = 'none';
				nextButton.classList.remove( 'disabled' );
				lastButton.classList.remove( 'disabled' );
				playButton.classList.remove( 'invisible' );
			}, pageConfig[ index ].freeze );
		}
	};

	return (
		<>
			<div id="wapuugotchi_onboarding__navigation">
				<button
					className="wapuugotchi_onboarding__navigation_stop"
					onClick={ stop }
				>
					<span className="dashicons dashicons-no"></span>
				</button>
				<button
					className="wapuugotchi_onboarding__navigation_last"
					onClick={ lastStep }
				>
					<span
						className={
							'dashicons dashicons-controls-back' +
							( getIndex() === 0 ? ' disabled' : '' )
						}
					></span>
				</button>
				<button
					className="wapuugotchi_onboarding__navigation_play"
					onClick={ startAnimation }
				>
					<span
						className={
							'dashicons dashicons-controls-play' +
							( getTargetsCount() <= 1 ? ' disabled' : '' )
						}
					></span>
				</button>
				<button
					className="wapuugotchi_onboarding__navigation_next"
					onClick={ nextStep }
				>
					<span className="dashicons dashicons-controls-forward"></span>
				</button>
				<div className="wapuugotchi_onboarding__loader"></div>
				<GlobalNavigation />
			</div>
		</>
	);
}
