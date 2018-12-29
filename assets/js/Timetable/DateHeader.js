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
        showPersonalCalendar,
        showSchoolCalendar,
        ...otherProps
    } = props

    const date = new Date(content.date)

    let columns = 1
    if (showPersonalCalendar)
        columns = columns + 1
    if (showSchoolCalendar)
        columns = columns + 1

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
                    <div className={'col-' + (12/columns)}>
                    </div>
                    {showPersonalCalendar === true ? <div className={'col-' + (12/columns)}>
                        {translateMessage(translations, 'Personal Calendar')}
                    </div> : ''}
                    {showSchoolCalendar === true ? <div className={'col-' + (12/columns)}>
                        {translateMessage(translations, 'School Calendar')}
                    </div> : ''}
                </div>
            </div>
        </div>
    )
}

DateHeader.propTypes = {
    content: PropTypes.object.isRequired,
    day: PropTypes.object,
    translations: PropTypes.object.isRequired,
    weekNumber: PropTypes.number.isRequired,
    showPersonalCalendar: PropTypes.bool.isRequired,
    showSchoolCalendar: PropTypes.bool.isRequired,
}

DateHeader.defaultProps = {
    day: {},
}

