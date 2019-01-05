'use strict';

import React from "react"
import TimetableControls from './TimetableControls'
import DateHeader from './DateHeader'
import DayEvents from './DayEvents'

export default function TimetableRender(props) {
    const {
        ...otherProps
    } = props

    return (
        <div className={'container-fluid timetable'}>
            <TimetableControls {...otherProps} />
            <DateHeader {...otherProps} />
            <DayEvents {...otherProps} />
        </div>
    )
}


