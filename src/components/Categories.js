
import './Categories.css'

const Categories = (props) => {

  const handleNewWare = (event) => {
    event.preventDefault();
    document.querySelectorAll('.wapuu_card__category').forEach(category => {
      category.classList.remove('selected')
    });
    event.target.classList.add('selected')
      props.handleSelection(event.target.getAttribute('category')
    )
  }

  return (
    props.category === undefined ? '' :
      <div onClick={handleNewWare} category={props.slug} className={props.slug === props.selectedCategory ? 'wapuu_card__category selected' : 'wapuu_card__category'}>
        <img className='wapuu_category__image' src={props.category.image}/>
      </div>
  );
}

export default Categories;
