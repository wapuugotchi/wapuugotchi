import { createReduxStore, register } from "@wordpress/data";

const STORE_NAME = 'wapuugotchi/wapuugotchi';

const DEFAULT_STATE = { foo : null };

/*
  await wp.data.dispatch('wapuugotchi/wapuugotchi').setFoo('huhu')

  wp.data.select('wapuugotchi/wapuugotchi').getFoo()
*/

function create(initial_state = DEFAULT_STATE) {
  const store = createReduxStore(STORE_NAME, {
    /* 
      don't know if we need it right know
      but will be very useful if we need async actions
    */  
    // __experimentalUseThunks: true,
    reducer(state = initial_state, { type, payload }) {
      switch (type) {
        case "SET_FOO": {
          return {
            ...state,
            foo: payload,
          };
        }
        case "SET_STATE": {
          return {
            ...payload,
          };
        }
      }

      return state;
    },
    actions : {
      setFoo(payload) {
        return {
          type: "SET_FOO",
          payload,
        };
      },
      setState(payload) {
        return {
          type: "SET_STATE",
          payload,
        };
      },  
    },
    selectors: {
      getFoo(state) {
        return state.foo;
      },
      getState(state) {
        return state;
      },
    },
    resolvers: {
      // getState() {
      //   debugger
      //   if(window['wapuugotchi/wapuugotchi-store-state-initial']===undefined) {
      //     throw new Error("Failed to access initial store data : window['wapuugotchi/wapuugotchi-store-state-initial'] is undefined !");
      //   }
      //   return {
      //     type: "SET_STATE",
      //     payload: window['wapuugotchi/wapuugotchi-store-state-initial'],
      //   };
      // }      
    }
  });

  register(store);
}

create();

export { STORE_NAME };