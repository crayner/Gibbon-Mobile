'use strict';

import React from "react"
import PropTypes from 'prop-types'
import {translateMessage} from '../Component/MessageTranslator'
import {getTimeString} from '../Component/getTimeString'
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome'
import { faEye } from '@fortawesome/free-solid-svg-icons'
import {faUsers,faCheck} from '@fortawesome/free-solid-svg-icons'
import {getDateString} from '../Component/getDateString'

export default function DayEvents(props) {
    const {
        translations,
        showPersonalCalendar,
        showSchoolCalendar,
        showSpaceBookingCalendar,
        events,
        takeAttendance,
    } = props

    if (events.length === 0)
        return (<div className={'row'}>
            <div className={'col-12 alert alert-dark text-center'}>
                {translateMessage(translations, 'There are no records to display.')}
            </div>
        </div>)

    const content = events.map(event => {
        if (event.eventType === 'personal' && !showPersonalCalendar)
            return ''

        if (event.eventType === 'school' && !showSchoolCalendar)
            return ''

        if (event.eventType === 'booking' && !showSpaceBookingCalendar)
            return ''

        let colour = 'alert-light period'
        if (event.eventType === 'personal')
            colour = 'alert-primary'
        if (event.eventType === 'school')
            colour = 'alert-success'
        if (event.eventType === 'booking')
            colour = 'alert-warning'

        let content = []

        if (event.eventType === 'normal' || event.eventType === 'booking')
        {
            if (! event.schoolDay) {
                colour = 'alert-danger'
                if (event.name === '' || event.name === 'School Closed') {
                    event.name = translateMessage(translations, 'School Closed')
                }
                content.push(<p className={'font-weight-bold'} key={'name'}>{event.name}</p>)
            } else {

                const today = new Date()
                if (getDateString(event.dayDate.date) === getDateString(today))
                {
                    const timeNow = getTimeString(today)
                    if (timeNow >= getTimeString(event.start.date) && timeNow <getTimeString(event.end.date)) {
                        colour = colour.replace('alert-light', 'alert-success');
                    }
                }

                const stuff = event.links.attendance && eventDateInPast(event) ? (
                    <span style={{float: 'right'}} className="fa-layers fa-fw fa-2x" title={translateMessage(translations,'Take Attendance by Class')} onClick={() => takeAttendance(event)}>
                        <FontAwesomeIcon icon={faUsers} color={event.attendanceStatus} />
                        <FontAwesomeIcon icon={faCheck} color={'black'} transform={'shrink-3 down-3 right-6'} />
                    </span>
                ) : ''

                content.push(<p className={'font-weight-bold'} key={'name'}>{stuff}{event.name}</p>)
                content.push(<p className={'font-italic text-truncate'} key={'timeLocation'}>{getTimeString(event.start.date)} - {getTimeString(event.end.date)}{event.location !== '' ? (' @ ' + event.location) : ''}</p>)
                content.push(<p className={'font-weight-bold className'} key={'className'}>{event.className}</p>)
                if (event.phone !== '') {
                    content.push(<p key={'phone'}>{translateMessage(translations, 'Phone')}: {event.phone}</p>)
                }
            }
        }

        if (event.eventType === 'school' || event.eventType === 'personal')
        {
            content.push(<p className={'font-weight-bold'} key={'name'}><FontAwesomeIcon style={{float: 'right'}} icon={faEye} size={'2x'} onClick={() => window.open(event.links.external,'_blank')} title={translateMessage(translations, 'View Details')} />{event.name}</p>)
            if (event.allDayEvent && event.location !== '') {
                content.push(<p className={'font-italic text-truncate'} key={'location'}> @ {event.location}</p>)
            } else if (! event.allDayEvent && event.location !== '') {
                content.push(<p className={'font-italic text-truncate'} key={'timeLocation'}>{getTimeString(event.start.date)} - {getTimeString(event.end.date)}{event.location !== '' ? (' @ ' + event.location) : ''}</p>)

            }
        }

        return (
            <div className={'row'} key={event.id}>
                <div className={'col-2 text-center card'}>
                    {event.allDayEvent ?
                    translateMessage(translations, 'All Day Event')
                    : getTimeString(event.start.date) }
                </div>
                <div className={'col-10 card ' + colour}>
                    {content}
                </div>
            </div>
        )
    })

    return (
        <div>
            {content}
        </div>
    )
}

DayEvents.propTypes = {
    translations: PropTypes.object.isRequired,
    events: PropTypes.array.isRequired,
    showPersonalCalendar: PropTypes.bool.isRequired,
    showSchoolCalendar: PropTypes.bool.isRequired,
    showSpaceBookingCalendar: PropTypes.bool.isRequired,
    takeAttendance: PropTypes.func.isRequired,
}

function eventDateInPast(event){
    //To allow for server /client time slip, a 5 minute buffer is added.
    const date = new Date(getDateString(event.dayDate.date) + 'T' + getTimeString(event.start.date))
    const now = new Date()
    now.setMinutes(now.getMinutes() + 5)
    if (date < now)
        return true
    return false
}
