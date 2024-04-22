import Menu from './menu';
import ShowRoom from './show-room';
import PaymentDialog from './payment-dialog';
import Header from './header';
import ControlPanel from './control-panel';
import Customizer from './customizer';
import Categories from './categories';
import Items from './items';

import './container.scss';
import RightSide from './right-side';
import LeftSide from './left-side';

export default function Container() {
	return (
		<div className="wapuugotchi_shop">
			<Header key="header" />
			<PaymentDialog key="payment-dialog" />
			<Customizer key="customizer">
				<LeftSide key="left-side">
					<Menu key="menu">
						<Categories key="categories" />
						<Items key="items" />
					</Menu>
				</LeftSide>
				<RightSide key="right-side">
					<ControlPanel key="control-panel" />
					<ShowRoom key="show-room" />
				</RightSide>
			</Customizer>
		</div>
	);
}
