'use strict';

import React from "react"
import PropTypes from 'prop-types'
import {translateMessage} from '../Component/MessageTranslator'
import TimetableRender from './TimetableRender'

export default function DateHeader(props) {
    const {
        content,
        day,
        weekNumber,
        translations,
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

    return (
        <div className={'row'}>
            <div className={'col-2 offset-1 card card-header text-center font-weight-bold'}>
                {translateMessage(translations,'Week')}&nbsp;{weekNumber}
                <i>{translateMessage(translations,'Time')}</i>
            </div>
            <div className={'col-8 card card-header text-center font-weight-bold'} style={style} data-help="sfhkasdjghfijhfwnf iugdfiuwhdgf">
                {name}
                <br />
                {new Intl.DateTimeFormat(otherProps.locale.replace('_', '-'), {
                    year: 'numeric',
                    month: 'short',
                    day: '2-digit',
                    timezone: content.date.timezone,
                }).format(date)}
            </div>
        </div>
    )
}

DateHeader.propTypes = {
    content: PropTypes.object.isRequired,
    day: PropTypes.object,
    translations: PropTypes.object.isRequired,
    weekNumber: PropTypes.number.isRequired,
}

DateHeader.defaultProps = {
    day: {},
}

