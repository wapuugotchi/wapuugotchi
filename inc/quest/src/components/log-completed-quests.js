import './log-completed-quests.scss';
import { __, sprintf } from '@wordpress/i18n';
import PearlIcon from './pearl-icon';

export default function LogCompletedQuests( { quests = [] } ) {
	if ( ! quests.length ) {
		return (
			<div className="wapuugotchi-quests__card is-empty">
				<p className="wapuugotchi-quests__meta">
					{ __( 'No completed quests yet.', 'wapuugotchi' ) }
				</p>
			</div>
		);
	}

	return (
		<div className="wapuugotchi-quests__list">
			{ quests.map( ( value, index ) => {
				const completionDate = sprintf(
					/* translators: %s: date when the quest was completed. */
					__( 'Completed on %s', 'wapuugotchi' ),
					value.date
				);
				const rewardLabel = sprintf(
					/* translators: %s: amount of pearls rewarded for the quest. */
					__( '%s pearls', 'wapuugotchi' ),
					value.pearls
				);

				return (
					<div
						key={ index }
						className="wapuugotchi-quests__card is-completed"
					>
						<div className="wapuugotchi-quests__card-header">
							<div>
								<h3>{ value.title }</h3>
								<p className="wapuugotchi-quests__meta">
									{ completionDate }
								</p>
							</div>
							<div className="wapuugotchi-quests__pill wapuugotchi-quests__pill--muted">
								<PearlIcon className="wapuugotchi-quests__pearl-icon" />
								<span>{ rewardLabel }</span>
							</div>
						</div>
						<p className="wapuugotchi-quests__status">
							{ __(
								'Reward already added to your balance.',
								'wapuugotchi'
							) }
						</p>
					</div>
				);
			} ) }
		</div>
	);
}
