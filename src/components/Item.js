import "./Item.css";

const Item = (props) => {

    const getClasses = () => {
        let classes = 'wapuu_card__item';
        if (props.wapuu.char[props.category].key.includes(props.item.meta.key)) {
          classes += ' selected';
        } else if(props.item.meta.price > 0) {
          classes = 'wapuu_card__item wapuu_card__locked';
        }
        return classes;
    }

    const getTooltip = () => {
        let tooltip = undefined
        if(props.item.meta.price > 0) {
          tooltip = 'Price: ' + props.item.meta.price;
        }
        return tooltip;
    }

    return (
        <div onClick={props.handleItem} category={props.category} data-key={props.item.key} className={getClasses()}>
            <img onClick={handleItem} className='wapuu_card__item_img' src={props.item.preview}/>
            {
                getTooltip() !== undefined ?
                <div className="wapuu_card__item_tooltiptext"><span>{getTooltip()}</span></div>
                : ''
            }
        </div>
    )
}

