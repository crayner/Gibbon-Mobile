'use strict';

import React from "react"
import PropTypes from 'prop-types'
import DisplayPeriod from './DisplayPeriod'
import {getTimeString} from '../Component/getTimeString'

export default function CalendarEvents(props) {
    const {
        content,
        colour,
        start,
        timeDiff,
        columnClass,
        ...otherProps
    } = props

    return (
        <div style={{height: timeDiff + 'px'}} className={columnClass}>{getSpecifiedTimeEvents(content, colour, start)}</div>
    )
}

CalendarEvents.propTypes = {
    content: PropTypes.array,
    colour: PropTypes.string.isRequired,
    start: PropTypes.string.isRequired,
    timeDiff: PropTypes.number.isRequired,
    columnClass: PropTypes.string.isRequired,
}

CalendarEvents.defaultProps = {
    content: [],
}


function getSpecifiedTimeEvents(events, colour, start){
    if (typeof(events) === 'undefined' || events.length === 0)
        return ''
    const specifiedTimeEvents = events.filter(event => {
        return event.eventType === 'Specified Time'
    })
    return specifiedTimeEvents.map((event, key) => {
        const diff = Math.abs(new Date(event.start) - new Date(event.end)) / 60000
        const offset = Math.abs(new Date(start) - new Date(event.start)) / 60000

        return (<div className={'alert alert-' + colour + ' text-center'} style={{height: diff + 'px', margin: '0 -15px', position: 'relative', top: offset + 'px'}} key={key}>
            {event.summary}<br />
            {getTimeString(event.start)} - {getTimeString(event.end)}
        </div>)
    })
}
