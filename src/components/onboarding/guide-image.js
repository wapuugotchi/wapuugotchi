import './guide-image.scss';

export default function GuideImage( param ) {
	return (
		<>
			<img src={ param?.image } width="312" height="240" alt="" />
		</>
	);
}
