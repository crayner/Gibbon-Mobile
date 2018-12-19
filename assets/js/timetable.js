'use strict';

import React from 'react'
import { render } from 'react-dom'
import TimetableApp from './Timetable/TimetableApp'

const target = document.getElementById('tt')

if (target === null)
    render(
        <span></span>, document.getElementById('dumpStuff')
    )
else
    render(
        <TimetableApp
            {...window.TIMETABLE_PROPS}
        />,
        target
    )
