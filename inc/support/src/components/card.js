export default function Card( {
	title,
	description,
	list = [],
	button,
	meta,
	small,
	highlight = false,
} ) {
	return (
		<div
			className={ `wapuugotchi-support__card${
				highlight ? ' is-highlight' : ''
			}` }
		>
			<h2>{ title }</h2>
			<p>{ description }</p>
			{ meta ? (
				<p className="wapuugotchi-support__meta">{ meta }</p>
			) : null }
			{ list?.length ? (
				<ul>
					{ list.map( ( item, index ) => (
						<li key={ index }>{ item }</li>
					) ) }
				</ul>
			) : null }
			{ button ? (
				<div className="wapuugotchi-support__actions">
					<a
						className={ `button ${
							button.type === 'primary' ? 'button-primary' : ''
						}` }
						href={ button.href }
						target="_blank"
						rel="noreferrer"
					>
						{ button.label }
					</a>
				</div>
			) : null }
			{ small ? (
				<p className="wapuugotchi-support__small">{ small }</p>
			) : null }
		</div>
	);
}
