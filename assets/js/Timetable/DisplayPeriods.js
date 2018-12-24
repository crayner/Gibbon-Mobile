'use strict';

import React from "react"
import PropTypes from 'prop-types'
import DisplayPeriod from './DisplayPeriod'

export default function DisplayPeriods(props) {
    const {
        content,
        ...otherProps
    } = props

    let today = new Date()
    today.setHours(0, 0, 0, 0);
    const day = new Date(content.date.date)

    today = today === day
    const periods = Object.keys(content.day.TTColumn.timetableColumnRows).map(key => {
        const period = content.day.TTColumn.timetableColumnRows[key]
        return (<DisplayPeriod {...otherProps} period={period} key={key} today={today} />)
    })


    return (
        <div className={'col-8 card'}>
            {periods}
        </div>
    )
}

DisplayPeriods.propTypes = {
    content: PropTypes.object.isRequired,
}

DisplayPeriods.defaultProps = {}
