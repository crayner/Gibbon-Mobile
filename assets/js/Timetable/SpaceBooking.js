'use strict';

import React from "react"
import PropTypes from 'prop-types'
import "bootstrap/scss/bootstrap.scss";
import "bootstrap/scss/bootstrap-grid.scss";
import { Tooltip } from 'reactstrap';
import { getTimeString } from '../Component/getTimeString'
import {getDateString} from '../Component/getDateString'

export default function SpaceBooking(props) {
    const {
        content,
        start,
        timeDiff,
        columnClass,
        toggleTooltip,
        tooltipOpen,
    } = props

    if (content === false)
        return ''

    console.log(content)

    const eventContent = content.map((event, key) => {
        const diff = Math.abs(new Date(event.timeStart.date) - new Date(event.timeEnd.date)) / 60000
        const timeStart = getDateString(start) + ' ' + getTimeString(event.timeStart.date)
        const offset = Math.abs(new Date(start) - new Date(timeStart)) / 60000
        let tooltipID = 'space' + event.id + event.timeStart.date
        tooltipID = tooltipID.replace(/-/g, '')
        tooltipID = tooltipID.replace(/:/g, '')
        tooltipID = tooltipID.replace(/\./g, '')
        tooltipID = tooltipID.replace(/ /g, '')
        const isOpen = tooltipOpen.hasOwnProperty(tooltipID) ? tooltipOpen[tooltipID] : false

        return (<div id={tooltipID} className={'alert-warning text-truncate externalCalendarEvent'} style={{height: diff + 'px', top: offset + 'px'}} key={key}>
            <p className={'text-center'}>{event.name}</p>
            <p className={'text-center'}>{getTimeString(event.timeStart.date)} - {getTimeString(event.timeEnd.date)}</p>
            <p className={'text-center'}>{event.personName}</p>
            <Tooltip target={tooltipID} className={'timetable-tooltip'} placement={'top'} isOpen={isOpen} toggle={() => toggleTooltip(tooltipID)} >
                <p className={'text-center'}>{event.name}</p>
                <p className={'text-center'}>{getTimeString(event.timeStart.date)} - {getTimeString(event.timeEnd.date)}</p>
                <p className={'text-center'}>{event.personName}</p>
            </Tooltip>
        </div>)
    })

    return (
        <div style={{height: timeDiff + 'px'}} className={columnClass}>
            {eventContent}
        </div>
    )
}

SpaceBooking.propTypes = {
    content: PropTypes.oneOfType([
        PropTypes.bool,
        PropTypes.array,
    ]),
    start: PropTypes.string.isRequired,
    timeDiff: PropTypes.number.isRequired,
    columnClass: PropTypes.string.isRequired,
    toggleTooltip: PropTypes.func.isRequired,
    tooltipOpen: PropTypes.object.isRequired,
}

SpaceBooking.defaultProps = {
    content: false,
}
