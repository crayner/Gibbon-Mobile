'use strict';

import React from "react"
import PropTypes from 'prop-types'
import SchoolDayClosed from './SchoolDayClosed'
import SchoolDayOpen from './SchoolDayOpen'

export default function TimetableRender(props) {
    const {
        content,
        ...otherProps
    } = props

    if (content.schoolOpen === false)
    {
        return (
            <SchoolDayClosed {...otherProps} content={content}/>
        )
    }

    return (
        <SchoolDayOpen {...otherProps} content={content} />
    )
}

TimetableRender.propTypes = {
    content: PropTypes.object.isRequired,
}

TimetableRender.defaultProps = {}
