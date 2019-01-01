'use strict';

import React from "react"
import PropTypes from 'prop-types'
import DateHeader from './DateHeader'
import TimetableControls from './TimetableControls'
import TimeDisplayColumn from './TimeDisplayColumn'
import DisplayPeriods from './DisplayPeriods'
import CalendarEvents from './CalendarEvents'

export default function OtherCalendarContent(props) {
    const {
        content,
        columns,
        translations,
        showPersonalCalendar,
        showSchoolCalendar,
        showSpaceBookingCalendar,
        ...otherProps
    } = props

    if (! showPersonalCalendar && ! showSchoolCalendar && ! showSpaceBookingCalendar)
        return (<div></div>)

    let columnContent = []
    let cc = ''
    // Which column is it now.
    for(let x = 2; x <= columns.number; x++) {
        cc = ''
        if (columns[x] === 'school') {
            cc = (<CalendarEvents content={content.schoolCalendar} colour={'success'} key={'school'} start={content.timeStart.date} timeDiff={content.timeDiff + content.timeOffset} columnClass={'col-' + 12/(columns.number - 1)} />)
        }
        if (columns[x] === 'personal') {
            cc = (<CalendarEvents content={content.personalCalendar} colour={'primary'} key={'personal'} start={content.timeStart.date} timeDiff={content.timeDiff + content.timeOffset} columnClass={'col-' + 12/(columns.number - 1)} />)
        }
        if (columns[x] === 'space') {
            cc = (<CalendarEvents content={content.bookingCalendar} colour={'warning'} key={'space'} start={content.timeStart.date} timeDiff={content.timeDiff + content.timeOffset} columnClass={'col-' + 12/(columns.number - 1)} />)
        }
        if (cc !== '') {
            columnContent.push(cc)
        }
    }

    console.log(content,columns)
    const number = 12 - 12/columns.number
    return (
        <div className={'col-' + number}>
            <div className={'row'}>
                {columnContent}
            </div>
        </div>
    )
}

OtherCalendarContent.propTypes = {
    columns: PropTypes.object.isRequired,
    content: PropTypes.object.isRequired,
    translations: PropTypes.object.isRequired,
    showPersonalCalendar: PropTypes.bool.isRequired,
    showSchoolCalendar: PropTypes.bool.isRequired,
    showSpaceBookingCalendar: PropTypes.bool.isRequired,
}

OtherCalendarContent.defaultProps = {}