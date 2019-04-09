'use strict';

import React from 'react'
import { render } from 'react-dom'
import '../css/Dashboard/dashboard.scss'
import TimetableApp from './Dashboard/TimetableApp'
import DashboardApp from './Dashboard/DashboardApp'

const target = document.getElementById('dashboard')

console.log(window.DASHBOARD_PROPS.dashboardName)
if (target === null)
    render(
        <span></span>, document.getElementById('dumpStuff')
    )

if (window.DASHBOARD_PROPS.dashboardName === 'Staff Dashboard')
    render(
        <TimetableApp
            {...window.DASHBOARD_PROPS}
        />,
        target
    )
if (window.DASHBOARD_PROPS.dashboardName === 'Student Dashboard')
    render(
        <TimetableApp
            {...window.DASHBOARD_PROPS}
        />,
        target
    )
if (window.DASHBOARD_PROPS.dashboardName === 'Parent Dashboard')
    render(
        <DashboardApp
            {...window.DASHBOARD_PROPS}
        />,
        target
    )
render(
    <span></span>, document.getElementById('dumpStuff')
)

