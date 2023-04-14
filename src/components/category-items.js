import "./category-items.scss";

import CategoryItem from "./category-item";

export default function CategoryItems({
	itemList,
	selectedCategory,
	handleItem,
}) {
	return (
		<div className="wapuu_card__items">
			{itemList.map((item, index) => (
				<CategoryItem
					handleItem={handleItem}
					selectedCategory={selectedCategory}
					item={item}
					key={item.meta.key}
				/>
			))}
		</div>
	);
}
