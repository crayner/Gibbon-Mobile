'use strict';

import React from "react"
import PropTypes from 'prop-types'
import SchoolDayClosed from './SchoolDayClosed'

export default function TimetableRender(props) {
    const {
        content,
        ...otherProps
    } = props

    if (content.schoolOpen === false)
    {
        return (
            <SchoolDayClosed content={content} {...otherProps}/>
        )
    }

    const error = typeof(content.error) === 'string' ? <div className={'row'}><div className={'col-12 alert-danger'}><p>{content.error}</p></div></div> : '' ;
    console.log(content)

    return (
        <span>
            {error}

        </span>
    )
}

TimetableRender.propTypes = {
    content: PropTypes.object.isRequired,
}

TimetableRender.defaultProps = {}
