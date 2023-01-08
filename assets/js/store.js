import {createStore, applyMiddleware} from 'redux';
import thunk from 'redux-thunk';
import reducers from './redurcers/conversation';

let store = createStore(reducers, applyMiddleware(thunk))

export default store;