import Category from "./category";
import CategoryItems from "./category-items";

import "./categories.scss";

export default function Categories({
	categories,
	setSelectedCategory,
	selectedCategory,
	itemList,
	handleItem,
}) {
	return (
		<>
			<div className="wapuu_card__categories">
				{Object.keys(categories).map((index) => (
					<Category
						key={index}
						slug={index}
						category={categories[index]}
						handleSelection={setSelectedCategory}
						selectedCategory={selectedCategory}
					/>
				))}
			</div>
			<CategoryItems
				itemList={itemList}
				selectedCategory={selectedCategory}
				handleItem={handleItem}
			/>
		</>
	);
}
