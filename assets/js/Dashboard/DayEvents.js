'use strict';

import React from "react"
import PropTypes from 'prop-types'
import {translateMessage} from '../Component/MessageTranslator'
import {getTimeString} from '../Component/getTimeString'
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome'
import { faEye } from '@fortawesome/free-solid-svg-icons'
import {faUsers,faCheck} from '@fortawesome/free-solid-svg-icons'
import {getDateString} from '../Component/getDateString'
import NavItems from '../SlideMenu/NavItems'

export default function DayEvents(props) {
    const {
        translations,
        showPersonalCalendar,
        showSchoolCalendar,
        showSpaceBookingCalendar,
        events,
        takeAttendance,
        canTakeAttendance,
    } = props

    var countEventsNotDisplayed = 0;

    events.map((event) => {
        if (event.eventType === 'school' && ! showSchoolCalendar)
            countEventsNotDisplayed = countEventsNotDisplayed + 1;
        if (event.eventType === 'personal' && ! showPersonalCalendar)
            countEventsNotDisplayed = countEventsNotDisplayed + 1;
        if (event.eventType === 'booking' && ! showSpaceBookingCalendar)
            countEventsNotDisplayed = countEventsNotDisplayed + 1;
    })

    if ((events.length - countEventsNotDisplayed) <= 0)
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
        let specialDay = '';

        if (event.eventType === 'normal' || event.eventType === 'booking')
        {
            if (! event.schoolDay) {
                colour = 'alert-danger'
                if (event.name === '' || event.name === 'School Closed') {
                    event.name = translateMessage(translations, 'School Closed')
                }
                content.push(<p className={'font-weight-bold'} key={'name'}>{event.name}</p>)
                if (event.description) {
                    content.push(<p key={'description'}>{event.description}</p>)
                }
            } else {

                const today = new Date()
                if (getDateString(event.dayDate.date) === getDateString(today))
                {
                    const timeNow = getTimeString(today)
                    if (timeNow >= getTimeString(event.start.date) && timeNow <getTimeString(event.end.date)) {
                        colour = colour.replace('alert-light', 'alert-success');
                    }
                }


                const stuff = canTakeAttendance && event.links.attendance && eventDateInPast(event) ? (
                    <span style={{float: 'right'}} className="fa-layers fa-fw fa-2x attendanceIcon" title={translateMessage(translations,'Take Attendance by Class')} onClick={() => takeAttendance(event)}>
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

        let headerContent = translateMessage(translations, 'All Day Event')
        if (!event.allDayEvent && event.start)
            headerContent = getTimeString(event.start.date)
        if (event.specialDay) {
            if (event.specialDayType === 'School Closure') {
                headerContent = translateMessage(translations, 'School Closure')
                specialDay = ' specialDay'
            }
        }

        return (
            <div className={'row'} key={event.id}>
                <div className={'col-2 text-center card' + specialDay}>
                    {headerContent}
                </div>
                <div className={'col-10 card ' + colour + specialDay}>
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
    canTakeAttendance: PropTypes.bool,
}

DayEvents.defaultProps = {
    canTakeAttendance: false,
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
