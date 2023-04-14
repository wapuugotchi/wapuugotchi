import "./category.scss";

export default function Category({
	slug,
	category,
	selectedCategory,
	handleSelection,
}) {
	return (
		category && (
			<div
				onClick={() => handleSelection(slug)}
				category={slug}
				className={
					slug === selectedCategory
						? "wapuu_card__category selected"
						: "wapuu_card__category"
				}
			>
				<img className="wapuu_category__image" src={category.image} />
			</div>
		)
	);
}
