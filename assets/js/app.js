/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import '../css/app.css';

// Need jQuery? Install it with "yarn add jquery", then uncomment to import it.
// import $ from 'jquery';

import React from 'react';
import { render } from 'react-dom';
import { Provider } from 'react-redux';
import HumApp from "./Hum/HumApp";
import store from "./Hum/redux/store";


render(
    <Provider store={store}>
        <HumApp humData={"Here's your data!"}/>,
    </Provider>,
    document.getElementById('react-app')
);
