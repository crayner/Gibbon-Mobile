'use strict';

import React from "react"
import PropTypes from 'prop-types'
import DateHeader from './DateHeader'
import TimetableControls from './TimetableControls'
import TimeDisplayColumn from './TimeDisplayColumn'
import DisplayPeriods from './DisplayPeriods'

export default function OtherCalendarContent(props) {
    const {
        content,
        translations,
        ...otherProps
    } = props

console.log(content)

    return (
        <span>
        </span>
    )
}

OtherCalendarContent.propTypes = {
    content: PropTypes.object.isRequired,
    translations: PropTypes.object.isRequired,
}

OtherCalendarContent.defaultProps = {}
