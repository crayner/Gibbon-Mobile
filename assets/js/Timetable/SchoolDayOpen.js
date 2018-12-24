'use strict';

import React from "react"
import PropTypes from 'prop-types'
import DateHeader from './DateHeader'
import TimetableControls from './TimetableControls'
import TimeDisplayColumn from './TimeDisplayColumn'
import DisplayPeriods from './DisplayPeriods'

export default function SchoolDayOpen(props) {
    const {
        content,
        translations,
        ...otherProps
    } = props

    const error = typeof(content.error) === 'string' ? <div className={'row'}><div className={'col-12 alert-danger'}><p>{content.error}</p></div></div> : '' ;

    return (
        <span>
            {error}
            <TimetableControls
                {...otherProps}
                changeDate={otherProps.changeDate}
                translations={translations}
                content={content.date}
                schoolYear={content.schoolYear}
            />
            <DateHeader
                {...otherProps}
                content={content.date}
                day={content.day}
                weekNumber={content.week}
                translations={translations}
            />
            <div className={'row'}>
                <TimeDisplayColumn {...otherProps} content={content} />
                <DisplayPeriods {...otherProps} content={content} translations={translations} />
            </div>
        </span>
    )
}

SchoolDayOpen.propTypes = {
    content: PropTypes.object.isRequired,
    translations: PropTypes.object.isRequired,
}

SchoolDayOpen.defaultProps = {}
