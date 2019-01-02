'use strict';

import React from "react"
import PropTypes from 'prop-types'
import {translateMessage} from '../Component/MessageTranslator'
import DateHeader from './DateHeader'
import TimetableControls from './TimetableControls'
import TimeDisplayColumn from './TimeDisplayColumn'
import AllDayEvents from './AllDayEvents'
import OtherCalendarContent from './OtherCalendarContent'

export default function SchoolDayClosed(props) {
    const {
        content,
        columns,
        translations,
        showPersonalCalendar,
        showSchoolCalendar,
        showSpaceBookingCalendar,
        ...otherProps
    } = props


    const error = typeof(content.error) === 'string' ? <div className={'row'}><div className={'col-12 alert-danger'}><p>{content.error}</p></div></div> : '' ;

    const name = Object.keys(content.specialDay).length === 0 ? translateMessage(translations, 'School Closed') : content.specialDay.name
    const description = Object.keys(content.specialDay).length === 0 ? '' : content.specialDay.description

    let offset = ''
    let additional = ''
    if (columns.number > 1)
    {
        offset = (<div style={{height: content.timeOffset + 'px', margin: "0 -15px"}}></div>)
        additional = (<div style={{height: content.timeAdditional + 'px', margin: "0 -15px"}}></div>)
    }

    return (
        <div id={'timetable'}>
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
                columns={columns}
                weekNumber={content.week}
                translations={translations}
                showPersonalCalendar={showPersonalCalendar}
                showSchoolCalendar={showSchoolCalendar}
                showSpaceBookingCalendar={showSpaceBookingCalendar}
            />
            <div className={'displayCalendar'}>
                <AllDayEvents
                    {...otherProps}
                    content={content}
                    translations={translations}
                    columns={columns}
                    showPersonalCalendar={showPersonalCalendar}
                    showSchoolCalendar={showSchoolCalendar}
                />
                <div className={'row'}>
                    <TimeDisplayColumn {...otherProps} content={content} columns={columns} />
                    <div className={'col-8 card'}>
                        <div className={'row'}>
                            <div className={'col-' + (12/columns.number)}>
                                {offset}
                                <div style={{height: content.timeDiff + 'px', margin: "0 -15px"}} className={'schoolDayClosed d-flex justify-content-center align-self-center"'}><span style={{position: 'relative', top: '45%'}} title={description}>{name}</span></div>
                                {additional}
                            </div>
                            <OtherCalendarContent
                                {...otherProps}
                                content={content}
                                columns={columns}
                                translations={translations}
                                showPersonalCalendar={showPersonalCalendar}
                                showSchoolCalendar={showSchoolCalendar}
                                showSpaceBookingCalendar={showSpaceBookingCalendar}
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    )
}

SchoolDayClosed.propTypes = {
    content: PropTypes.object.isRequired,
    columns: PropTypes.object.isRequired,
    translations: PropTypes.object.isRequired,
    showPersonalCalendar: PropTypes.bool.isRequired,
    showSchoolCalendar: PropTypes.bool.isRequired,
    showSpaceBookingCalendar: PropTypes.bool.isRequired,
}
