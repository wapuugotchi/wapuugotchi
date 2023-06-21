import "./category-items.scss";

import CategoryItem from "./category-item";

export default function CategoryItems({ getItemList, selectedCategory }) {
	let itemList = getItemList();
	itemList = itemList.sort((a, b) => {
		if(a.meta.priority < b.meta.priority) return -1;
		if(a.meta.priority > b.meta.priority) return 1;
		return 0;
	});

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
