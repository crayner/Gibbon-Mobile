'use strict';

import React from 'react'
import { render } from 'react-dom'
import ClickOutside from './SlideMenu/SlideMenuApp'
import '@trendmicro/react-sidenav/dist/react-sidenav.css';

const tray = document.getElementById('slideMenu')

if (tray === null)
    render(<div>&nbsp;</div>, document.getElementById('dumpStuff') )
else
    render(
        <ClickOutside
            {...window.MENU_PROPS}
        />,
        tray
    )
