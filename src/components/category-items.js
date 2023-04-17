import "./category-items.scss";

import CategoryItem from "./category-item";

export default function CategoryItems({ getItemList, selectedCategory }) {
	const itemList = getItemList();

	return (
		<div className="wapuu_card__items">
			{itemList.map((item, index) => (
				<CategoryItem
					selectedCategory={selectedCategory}
					item={item}
					key={item.meta.key}
				/>
			))}
		</div>
	);
}
