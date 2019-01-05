'use strict';

import React from "react"
import PropTypes from 'prop-types'
import {translateMessage} from '../Component/MessageTranslator'

export default function DateHeader(props) {
    const {
        day,
        translations,
        ...otherProps
    } = props

    const date = new Date(day.date.date)

    return (
        <div className={'row'}>
            <div className={'col-2 card card-header text-center font-weight-bold'}>
                {translateMessage(translations,'Week')}<br />{day.week}
            </div>
            <div className={'col-9 card card-header text-center font-weight-bold'} style={{color: '#' + day.fontColour, backgroundColor: '#' + day.colour}}>
                {day.name}
                <br />
                {new Intl.DateTimeFormat(otherProps.locale.replace('_', '-'), {
                    year: 'numeric',
                    month: 'short',
                    day: '2-digit',
                    timezone: day.date.timezone,
                }).format(date)}
            </div>
        </div>
    )
}

DateHeader.propTypes = {
    day: PropTypes.object,
    translations: PropTypes.object.isRequired,
}

DateHeader.defaultProps = {
    day: {},
}

