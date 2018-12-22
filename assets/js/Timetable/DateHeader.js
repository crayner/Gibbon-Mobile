'use strict';

import React from "react"
import PropTypes from 'prop-types'
import {translateMessage} from '../Component/MessageTranslator'

export default function DateHeader(props) {
    const {
        content,
        weekNumber,
        translations,
        ...otherProps
    } = props

    const date = new Date(content.date)

    return (
        <div className={'row'}>
            <div className={'col-2 offset-1 card card-header text-center font-weight-bold'}>
                {translateMessage(translations,'Week')}&nbsp;{weekNumber}
                <i>{translateMessage(translations,'Time')}</i>
            </div>
            <div className={'col-8 card card-header text-center font-weight-bold'}>
                {new Intl.DateTimeFormat(otherProps.locale.replace('_', '-'), {
                    weekday: 'short',
                    timezone: content.date.timezone,
                }).format(date)}
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
    translations: PropTypes.object.isRequired,
    weekNumber: PropTypes.number.isRequired,
}
