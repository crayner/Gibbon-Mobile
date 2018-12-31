'use strict';

import React from "react"
import PropTypes from 'prop-types'
import {translateMessage} from '../Component/MessageTranslator'

export default function DateHeader(props) {
    const {
        content,
        day,
        weekNumber,
        translations,
        columns,
        showPersonalCalendar,
        showSchoolCalendar,
        showSpaceBookingCalendar,
        ...otherProps
    } = props

    const date = new Date(content.date)

    let style = {}
    style.backgroundColor = 'rgba(0,0,0,.03)'
    style.color = 'black'

    let name = new Intl.DateTimeFormat(otherProps.locale.replace('_', '-'), {
        weekday: 'short',
        timezone: content.date.timezone,
    }).format(date)

    if (Object.keys(day).length > 0) {
        style.backgroundColor = '#' + day.colour
        style.color = '#' + day.fontColour
        name = day.name + ' (' + day.nameShort + ')'
    }

    let columnContent = [];

    for(let x=2; x<=4; x++){
        if (columns[x] === 'personal')
            columnContent.push(<div className={'col-' + (12/columns.number)} key={x}>{translateMessage(translations, 'Personal Calendar')}</div>)
        if (columns[x] === 'school')
            columnContent.push(<div className={'col-' + (12/columns.number)} key={x}>{translateMessage(translations, 'School Calendar')}</div>)
        if (columns[x] === 'space')
            columnContent.push(<div className={'col-' + (12/columns.number)} key={x}>{translateMessage(translations, 'Bookings')}</div>)
    }

    return (
        <div className={'row'}>
            <div className={'col-2 offset-1 card card-header text-center font-weight-bold'}>
                {translateMessage(translations,'Week')}&nbsp;{weekNumber}
                <i>{translateMessage(translations,'Time')}</i>
            </div>
            <div className={'col-8 card card-header text-center font-weight-bold'} style={style}>
                {name}
                <br />
                {new Intl.DateTimeFormat(otherProps.locale.replace('_', '-'), {
                    year: 'numeric',
                    month: 'short',
                    day: '2-digit',
                    timezone: content.date.timezone,
                }).format(date)}
                <div className={'row'}>
                    <div className={'col-' + (12/columns.number)} key={'1'}>
                    </div>
                    {columnContent}
                </div>
            </div>
        </div>
    )
}

DateHeader.propTypes = {
    content: PropTypes.object.isRequired,
    columns: PropTypes.object.isRequired,
    day: PropTypes.object,
    translations: PropTypes.object.isRequired,
    weekNumber: PropTypes.number.isRequired,
    showPersonalCalendar: PropTypes.bool.isRequired,
    showSchoolCalendar: PropTypes.bool.isRequired,
    showSpaceBookingCalendar: PropTypes.bool.isRequired,
}

DateHeader.defaultProps = {
    day: {},
}

