import './guide-footer.scss';

export default function GuideFooter() {

	const guideNext = async () => {
		console.log('Next step!!!!!')
	};

	return (
		<>
			<div className="wapuugotchi_onboarding_guide__footer">
				<button className="components-button" onClick={ guideNext }>Next</button>
			</div>
		</>
	);
}
