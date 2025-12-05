import { __, sprintf } from '@wordpress/i18n';
import './log-active-quests.scss';
import PearlIcon from './pearl-icon';

export default function LogActiveQuests( { quests = [] } ) {
	if ( ! quests.length ) {
		return (
			<div className="wapuugotchi-quests__card is-empty">
				<p className="wapuugotchi-quests__meta">
					{ __( 'No active quests at the moment.', 'wapuugotchi' ) }
				</p>
			</div>
		);
	}

	return (
		<div className="wapuugotchi-quests__list">
			{ quests.map( ( value, index ) => {
				const rewardLabel = sprintf(
					/* translators: %s: amount of pearls rewarded for the quest. */
					__( '+%s pearls', 'wapuugotchi' ),
					value.pearls
				);

				return (
					<div
						key={ index }
						className="wapuugotchi-quests__card is-active"
					>
						<div className="wapuugotchi-quests__card-header">
							<div>
								<h3>{ value.title }</h3>
								<p className="wapuugotchi-quests__meta">
									{ __( 'Status: Active', 'wapuugotchi' ) }
								</p>
							</div>
							<div className="wapuugotchi-quests__pill wapuugotchi-quests__pill--success">
								<PearlIcon className="wapuugotchi-quests__pearl-icon" />
								<span>{ rewardLabel }</span>
							</div>
						</div>
					</div>
				);
			} ) }
		</div>
	);
}
