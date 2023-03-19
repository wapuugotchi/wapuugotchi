import { createReduxStore, register } from "@wordpress/data";

const STORE_NAME = 'wapuugotchi/wapuugotchi';

const DEFAULT_STATE = {  };

/*
  await wp.data.dispatch('wapuugotchi/wapuugotchi').setFoo('huhu')

  wp.data.select('wapuugotchi/wapuugotchi').getFoo()

  import { useSelect } from "@wordpress/data";
  import { STORE_NAME } from './store.js'; 

  function Wapuutchi(props) {
    const foo = useSelect( select => select( STORE_NAME ).getFoo(), [] );


    return <div>{foo}</div>;
  }
*/

function evalCategories(collections) {
  let categories = Object.values(collections).map(_=>_.collections)
    .reduce((acc, curr) => {
      acc.push(...curr);
      return acc;
    }, []
  );

  categories = categories.reduce((acc, curr) => { 
      if( !acc[curr.caption]) {
          // collect only categories with at least a single item
          if(!curr.items.length) { 
            acc[curr.caption]=curr.image;
          } 
      }
      return acc;
    }, 
    {}
  );

  return categories;
}

function create(initial_state = DEFAULT_STATE) {
  const store = createReduxStore(STORE_NAME, {
    /* 
      don't know if we need it right know
      but will be very useful if we need async actions
    */  
    // __experimentalUseThunks: true,
    reducer(state = {}, { type, payload }) {
      switch (type) {
        case "SET_COLLECTIONS": {
          return {
            ...state,
            collections: payload,
            categories : evalCategories(payload)
          };
        }
        case "SET_WAPUU": {
          return {
            ...state,
            wapuu : payload
          };
        }
      }

      return state;
    },
    actions : {
      setCollections(payload) {
        return {
          type: "SET_COLLECTIONS",
          payload,
        };
      },
      setWapuu(payload) {
        return {
          type: "SET_WAPUU",
          payload,
        };
      },  
    },
    selectors: {
      getState(state) {
        return state;
      },
      getCategories(state) {
        return state.categories;
      },
      getWapuu(state) {
        return state.wapuu;
      }
    },
    resolvers: {
      // getState() {
      //   debugger
      //   if(window['wapuugotchi/wapuugotchi-store-state-initial']===undefined) {
      //     throw new Error("Failed to access initial store data : window['wapuugotchi/wapuugotchi-store-state-initial'] is undefined !");
      //   }
      //   return {
      //     type: "SET_COLLECTIONS",
      //     payload: window['wapuugotchi/wapuugotchi-store-state-initial'],
      //   };
      // }      
    }
  });

  register(store);
}

create();

export { STORE_NAME };