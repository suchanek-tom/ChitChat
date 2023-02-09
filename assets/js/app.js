import React from 'react';
import ReactDom from 'react-dom';
import store from './store'
import { Provider } from 'react-redux';
import { MemoryRouter } from 'react-router-dom';

import * as actionCreators from './actions/conversations'

import App from './components/App';

//store.dispatch(actionCreators.setUsername(document.querySelector('#app').dataset.username));

ReactDom.render(
(
    <Provider store={store}>
        <MemoryRouter>
            <App/>
        </MemoryRouter>
    </Provider>
),
document.getElementById('app'));