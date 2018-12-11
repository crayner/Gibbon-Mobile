'use strict';

import React from 'react'
import { render } from 'react-dom'
import TrayApp from './NotificationTray/TrayApp'

render(
    <TrayApp
        {...window.TRAY_PROPS}
    />,
    document.getElementById('notificationTray')
)
