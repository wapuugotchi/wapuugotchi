import Categories from './categories';
import Items from './items';
import './right-side.scss';

export default function RightSide() {
	return (
		<div className="wapuugotchi_shop__customizer_right">
			<Categories />
			<Items />
		</div>
	);
}
