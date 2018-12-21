'use strict';

import React from "react"
import PropTypes from 'prop-types'

export default function DateHeader(props) {
    const {
        content,
        ...otherProps
    } = props

    const date = new Date(content.date)

    return (
        <div className={'row '}>
            <div className={'col-10 offset-1 card card-header text-center font-weight-bold'}>
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
}
