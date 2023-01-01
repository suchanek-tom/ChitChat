import React from 'react';
import ReactDom from 'react-dom';
//import store from 'store';
import { Provider } from 'react-redux';
import {MemoryRouter} from 'react-router-dom';

import App from './components/App';


ReactDom.render(
(
        <App/>
),
document.getElementById('app')

);