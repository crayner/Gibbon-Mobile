'use strict';

import React from 'react'
import { render } from 'react-dom'
import "bootstrap/scss/bootstrap.scss";
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
