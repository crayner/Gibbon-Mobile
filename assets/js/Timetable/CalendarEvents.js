'use strict';

import React from "react"
import PropTypes from 'prop-types'
import "bootstrap/scss/bootstrap.scss";
import "bootstrap/scss/bootstrap-grid.scss";
import { Tooltip } from 'reactstrap';
import { getTimeString } from '../Component/getTimeString'
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome'
import { translateMessage } from '../Component/MessageTranslator'
import { faEye } from '@fortawesome/free-solid-svg-icons'

export default function CalendarEvents(props) {
    const {
        content,
        colour,
        start,
        timeDiff,
        columnClass,
        toggleTooltip,
        tooltipOpen,
        translations,
    } = props

    if (content.length === 0)
        return ''
    const specifiedTimeEvents = content.filter(event => {
        return event.eventType === 'Specified Time'
    })
    if (specifiedTimeEvents.length === 0)
        return ''

    const eventContent = specifiedTimeEvents.map((event, key) => {
        const diff = Math.abs(new Date(event.start) - new Date(event.end)) / 60000
        const offset = Math.abs(new Date(start) - new Date(event.start)) / 60000
        const tooltipID = 'external' + event.id
        const isOpen = tooltipOpen.hasOwnProperty(tooltipID) ? tooltipOpen[tooltipID] : false

        const eventContent = (
            <span>
                <p>{event.summary}</p>
                <p>{getTimeString(event.start)} - {getTimeString(event.end)}</p>
                <p>{event.location}</p>
            </span>
        )

        return (<div id={tooltipID} className={'alert alert-' + colour + ' text-center externalCalendarEvent'} style={{height: diff + 'px', top: offset + 'px'}} key={key}>
            <FontAwesomeIcon style={{float: 'right'}} icon={faEye} onClick={() => window.open(event.link,'_blank')} size={'2x'} title={translateMessage(translations, 'View Details')} />
            {eventContent}
            <Tooltip target={tooltipID} className={'timetable-tooltip'} placement={'top'} isOpen={isOpen} toggle={() => toggleTooltip(tooltipID)} >
                {eventContent}
            </Tooltip>
        </div>)
    })

    return (
        <div style={{height: timeDiff + 'px'}} className={columnClass}>
            {eventContent}
        </div>
    )
}

CalendarEvents.propTypes = {
    content: PropTypes.array,
    colour: PropTypes.string.isRequired,
    start: PropTypes.string.isRequired,
    timeDiff: PropTypes.number.isRequired,
    columnClass: PropTypes.string.isRequired,
    toggleTooltip: PropTypes.func.isRequired,
    tooltipOpen: PropTypes.object.isRequired,
    translations: PropTypes.object.isRequired,
}

CalendarEvents.defaultProps = {
    content: [],
}
