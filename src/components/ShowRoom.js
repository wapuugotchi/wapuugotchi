import { useEffect, useState } from "@wordpress/element";

import "./ShowRoom.css";

const ShowRoom = (props) => {
  const [svg, setSvg] = useState(null);

  const onSvgCreationCompleted = (svg) => {
    setSvg(svg);
  };

	const get_image_list = () => {
		let result = [];
		Object.keys(props.wapuu.char).map((category) => {
			props.wapuu.char[category].key.map((WapuuItem) => {
				props.collection[category].map((CollectionItem) => {
					if (WapuuItem === CollectionItem.key) {
						result.push(CollectionItem);
					}
				});
			});
		});
		return result;
	};

	useEffect(() => {
		fetch("https://api.wapuugotchi.com/fur/classic/image.svg")
			.then((res) => res.text())
			.then((text) => {
				let svg = new DOMParser().parseFromString(text, "image/svg+xml");
				// console.log(svg)
			});

		fetch("https://api.wapuugotchi.com/balls/classic/image.svg")
			.then((res) => res.text())
			.then((text) => {
				let svg = new DOMParser().parseFromString(text, "image/svg+xml");
        // console.log(svg)
        // onSvgCreationCompleted(svg.innerHTML);
        // console.log(svg)
        // onSvgCreationCompleted(svg.documentElement);
				// console.log(svg.querySelector('.Body--group').innerHTML)
			});
	});

	return (
		<div className="wapuu_show_room"></div>
	);
};
export default ShowRoom;
