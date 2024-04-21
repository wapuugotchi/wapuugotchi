import './category.scss';
import {dispatch, useSelect} from "@wordpress/data";
import {STORE_NAME} from "../store";

export default function Category({slug, meta}) {
	const {selectedCategory} = useSelect((select) => {
		return {
			selectedCategory: select(STORE_NAME).getSelectedCategory(),
		};
	});

	const handleSelectedCategory = async (event) => {
		dispatch(STORE_NAME).setSelectedCategory(slug);
	};
	return (
		meta && (
			<div
				onClick={() => handleSelectedCategory()}
				className={
					slug === selectedCategory
						? 'wapuugotchi_shop__category selected'
						: 'wapuugotchi_shop__category'
				}
			>
				<img className="wapuugotchi_shop__category_icon" src={meta.image}/>
			</div>
		)
	);
}
