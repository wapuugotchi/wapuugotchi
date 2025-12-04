import { useSelect } from '@wordpress/data';
import { STORE_NAME } from '../store';
import Card from './card';
import Header from './header';
import './app.scss';

export default function App() {
	const { cards } = useSelect( ( select ) => ( {
		cards: select( STORE_NAME ).getCards(),
	} ) );

	return (
		<div className="wapuugotchi-support wapuugotchi-support__page">
			<Header />
			<div className="wapuugotchi-support__grid">
				{ cards?.map( ( card, index ) => (
					<Card key={ index } { ...card } />
				) ) }
			</div>
		</div>
	);
}
