'use strict';

import React from "react"
import PropTypes from 'prop-types'
import DateHeader from './DateHeader'
import TimetableControls from './TimetableControls'
import TimeDisplayColumn from './TimeDisplayColumn'
import DisplayPeriods from './DisplayPeriods'
import AllDayEvents from './AllDayEvents'
import OtherCalendarContent from './OtherCalendarContent'
import {translateMessage} from '../Component/MessageTranslator'

export default function SchoolDayOpen(props) {
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
                day={content.day}
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
                                <DisplayPeriods {...otherProps} content={content} translations={translations} />
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

SchoolDayOpen.propTypes = {
    content: PropTypes.object.isRequired,
    columns: PropTypes.object.isRequired,
    translations: PropTypes.object.isRequired,
    showPersonalCalendar: PropTypes.bool.isRequired,
    showSchoolCalendar: PropTypes.bool.isRequired,
    showSpaceBookingCalendar: PropTypes.bool.isRequired,
}
