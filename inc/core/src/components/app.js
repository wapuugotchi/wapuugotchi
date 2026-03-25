import { useSelect, useDispatch } from '@wordpress/data';
import { ToggleControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import { STORE_NAME } from '../store';
import './app.scss';

export default function App() {
	const { features, settings, saving } = useSelect( ( select ) => ( {
		features: select( STORE_NAME ).getFeatures(),
		settings: select( STORE_NAME ).getSettings(),
		saving: select( STORE_NAME ).isSaving(),
	} ) );
	const { saveSetting } = useDispatch( STORE_NAME );

	return (
		<div className="wapuugotchi-settings wapuugotchi-settings__page">
			<div className="wapuugotchi-settings__header">
				<div>
					<h1>
						{ __( '🐾 WapuuGotchi – Settings', 'wapuugotchi' ) }
					</h1>
					<p className="subtitle">
						{ __(
							'Enable or disable optional features of the WapuuGotchi plugin.',
							'wapuugotchi'
						) }
					</p>
				</div>
				{ saving && (
					<span className="wapuugotchi-settings__pill">
						{ __( 'Saving…', 'wapuugotchi' ) }
					</span>
				) }
			</div>
			<div className="wapuugotchi-settings__grid">
				{ features.map( ( feature ) => {
					const isEnabled = settings[ feature.key ] !== false;
					return (
						<div
							key={ feature.key }
							className={ `wapuugotchi-settings__card${
								! isEnabled ? ' is-disabled' : ' is-enabled'
							}` }
							onClick={ () =>
								saveSetting( feature.key, ! isEnabled )
							}
							role="button"
							tabIndex={ 0 }
							onKeyDown={ ( e ) => {
								if ( e.key === 'Enter' || e.key === ' ' ) {
									saveSetting( feature.key, ! isEnabled );
								}
							} }
						>
							<h2>{ feature.label }</h2>
							<p>{ feature.description }</p>
							{ /* eslint-disable-next-line jsx-a11y/click-events-have-key-events, jsx-a11y/no-static-element-interactions */ }
							<div onClick={ ( e ) => e.stopPropagation() }>
								<ToggleControl
									label={
										isEnabled
											? __( 'Enabled', 'wapuugotchi' )
											: __( 'Disabled', 'wapuugotchi' )
									}
									checked={ isEnabled }
									onChange={ ( value ) =>
										saveSetting( feature.key, value )
									}
								/>
							</div>
						</div>
					);
				} ) }
			</div>
		</div>
	);
}
