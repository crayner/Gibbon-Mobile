'use strict';

import React from 'react'
import { render } from 'react-dom'
import SlideMenuApp from './SlideMenu/SlideMenuApp'
import '@trendmicro/react-sidenav/dist/react-sidenav.css';

const tray = document.getElementById('slideMenu')

if (tray === null)
    render(<div>&nbsp;</div>, document.getElementById('dumpStuff') )
else
    render(
        <SlideMenuApp
            {...window.MENU_PROPS}
        />,
        tray
    )
