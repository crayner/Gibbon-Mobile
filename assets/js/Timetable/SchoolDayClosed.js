'use strict';

import React from "react"
import PropTypes from 'prop-types'
import {translateMessage} from '../Component/MessageTranslator'
import DateHeader from './DateHeader'
import TimetableControls from './TimetableControls'
import TimeDisplayColumn from './TimeDisplayColumn'
import AllDayEvents from './AllDayEvents'

export default function SchoolDayClosed(props) {
    const {
        content,
        translations,
        showPersonalCalendar,
        showSchoolCalendar,
        showSpaceBookingCalendar,
        ...otherProps
    } = props

    const error = typeof(content.error) === 'string' ? <div className={'row'}><div className={'col-12 alert-danger'}><p>{content.error}</p></div></div> : '' ;

    const name = Object.keys(content.specialDay).length === 0 ? translateMessage(translations, 'School Closed') : content.specialDay.name
    const description = Object.keys(content.specialDay).length === 0 ? '' : content.specialDay.description

    let columns = 1
    if (showPersonalCalendar)
        columns = columns + 1
    if (showSchoolCalendar)
        columns = columns + 1
    if (showSpaceBookingCalendar)
        columns = columns + 1

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
                weekNumber={content.week}
                translations={translations}
                showPersonalCalendar={showPersonalCalendar}
                showSchoolCalendar={showSchoolCalendar}
                showSpaceBookingCalendar={showSpaceBookingCalendar}
            />
            <AllDayEvents {...otherProps} translations={translations}/>
            <div className={'row'}>
                <TimeDisplayColumn {...otherProps} content={content} />
                <div className={'col-8 card'}>
                    <div className={'row'}>
                        <div className={'col-' + (12/columns)}>
                            <div style={{height: content.timeDiff + 'px', margin: "0 -15px"}} className={'schoolDayClosed d-flex justify-content-center align-self-center"'}><span style={{position: 'relative', top: '45%'}} title={description}>{name}</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </span>
    )
}

SchoolDayClosed.propTypes = {
    content: PropTypes.object.isRequired,
    translations: PropTypes.object.isRequired,
    showPersonalCalendar: PropTypes.bool.isRequired,
    showSchoolCalendar: PropTypes.bool.isRequired,
    showSpaceBookingCalendar: PropTypes.bool.isRequired,
}

SchoolDayClosed.defaultProps = {}
