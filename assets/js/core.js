'use strict';

import React from 'react'
import { render } from 'react-dom'
import "bootstrap/dist/css/bootstrap.min.css";
import "bootstrap/dist/js/bootstrap.bundle";
import "./vendor/FontAwesome/all"
import "../css/Form/form.scss"
import "../css/App.scss"
import CoreControl from './Core/CoreControl'

render(
    <CoreControl
        {...window.CORE_PROPS}
    />,
    document.getElementById('coreRender')
)
