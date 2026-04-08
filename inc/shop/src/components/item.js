import './item.scss';
import Pearl from './assets/pearl_black.svg';

import { useCallback, useState } from '@wordpress/element';
import { dispatch, useSelect } from '@wordpress/data';
import { __ } from '@wordpress/i18n';

import { STORE_NAME } from '../store';

export default function Item( { uuid, item, index } ) {
	const [ loaded, setLoaded ] = useState( false );
	const { wapuu, balance, selectedCategory } = useSelect( ( select ) => {
		return {
			wapuu: select( STORE_NAME ).getWapuu(),
			balance: select( STORE_NAME ).getBalance(),
			selectedCategory: select( STORE_NAME ).getSelectedCategory(),
		};
	} );

	const handleItemClick = useCallback( () => {
		const avatarConfig = wapuu?.char?.[ selectedCategory ];
		if ( item.meta.price === 0 ) {
			const isItemSelected = avatarConfig?.key?.includes( uuid );
			const canDeselect =
				( avatarConfig?.key?.length ?? 0 ) > avatarConfig?.min;
			const canSelect =
				( avatarConfig?.key?.length ?? 0 ) < avatarConfig?.max;

			const updateKeys = ( newKeys ) => {
				dispatch( STORE_NAME ).setWapuu( {
					...wapuu,
					char: {
						...wapuu.char,
						[ selectedCategory ]: { ...avatarConfig, key: newKeys },
					},
				} );
			};

			if ( isItemSelected && canDeselect ) {
				updateKeys( avatarConfig.key.filter( ( k ) => k !== uuid ) );
			} else if ( ! isItemSelected && canSelect ) {
				updateKeys( [ ...avatarConfig.key, uuid ] );
			} else if ( ! isItemSelected && ! canSelect ) {
				updateKeys( [ ...avatarConfig.key.slice( 0, -1 ), uuid ] );
			}
		} else if ( item.meta.price <= balance ) {
			dispatch( STORE_NAME ).showItemDetail( uuid );
		}
	}, [ balance, item, selectedCategory, uuid, wapuu ] );

	const isSelected = wapuu?.char?.[ selectedCategory ]?.key?.includes( uuid );
	const canAfford = item?.meta?.price <= balance;

	return (
		<div
			onClick={ handleItemClick }
			className={ `${
				isSelected
					? 'wapuugotchi_shop__item selected'
					: 'wapuugotchi_shop__item'
			}${ item?.meta?.price === 0 ? ' free' : '' }${
				loaded ? ' is-loaded' : ''
			}` }
			style={ { transitionDelay: loaded ? '0ms' : `${ index * 40 }ms` } }
		>
			<img
				src={ item.preview }
				alt=""
				onLoad={ () => setLoaded( true ) }
				onError={ () => setLoaded( true ) }
			/>
			{ isSelected && (
				<div className="wapuugotchi_shop__owned_badge">
					{ __( 'Selected', 'wapuugotchi' ) }
				</div>
			) }
			{ item?.meta?.colored === 1 && (
				<span className="wapuugotchi_shop__colored_hint">
					<svg
						xmlns="http://www.w3.org/2000/svg"
						viewBox="-150 -150 300 300"
						aria-hidden="true"
						focusable="false"
					>
						<path
							d="M0,0 L0,-140 A140,140 0 0,1 70,-121 Z"
							fill="#FF0000"
						/>
						<path
							d="M0,0 L70,-121 A140,140 0 0,1 121,-70 Z"
							fill="#FF7F00"
						/>
						<path
							d="M0,0 L121,-70 A140,140 0 0,1 140,0 Z"
							fill="#FFFF00"
						/>
						<path
							d="M0,0 L140,0 A140,140 0 0,1 121,70 Z"
							fill="#7FFF00"
						/>
						<path
							d="M0,0 L121,70 A140,140 0 0,1 70,121 Z"
							fill="#00FF00"
						/>
						<path
							d="M0,0 L70,121 A140,140 0 0,1 0,140 Z"
							fill="#00FF7F"
						/>
						<path
							d="M0,0 L0,140 A140,140 0 0,1 -70,121 Z"
							fill="#00FFFF"
						/>
						<path
							d="M0,0 L-70,121 A140,140 0 0,1 -121,70 Z"
							fill="#007FFF"
						/>
						<path
							d="M0,0 L-121,70 A140,140 0 0,1 -140,0 Z"
							fill="#0000FF"
						/>
						<path
							d="M0,0 L-140,0 A140,140 0 0,1 -121,-70 Z"
							fill="#7F00FF"
						/>
						<path
							d="M0,0 L-121,-70 A140,140 0 0,1 -70,-121 Z"
							fill="#FF00FF"
						/>
						<path
							d="M0,0 L-70,-121 A140,140 0 0,1 0,-140 Z"
							fill="#FF007F"
						/>
					</svg>
				</span>
			) }
			{ item?.meta?.price > 0 && (
				<div
					className={ `wapuugotchi_shop__pill ${
						canAfford
							? 'wapuugotchi_shop__pill--success'
							: 'wapuugotchi_shop__pill--muted'
					}` }
				>
					<img
						className="wapuugotchi_shop__pearl-icon"
						src={ Pearl }
						alt=""
					/>
					<span>{ item.meta.price }</span>
				</div>
			) }
		</div>
	);
}
