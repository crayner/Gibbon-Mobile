'use strict';

import React from "react"
import PropTypes from 'prop-types'
import {translateMessage} from '../Component/MessageTranslator'

export default function AllDayEvents(props) {
    const {
        translations,
        content,
        columns,
        hasAllDaySchoolEvents,
        showSchoolCalendar,
        showPersonalCalendar,
        hasAllDayPersonalEvents,
        ...otherProps
    } = props

    if (! (showSchoolCalendar && hasAllDaySchoolEvents) && ! (showPersonalCalendar && hasAllDayPersonalEvents))
        return (<div></div>)

    let columnContent = []
    let cc = ''
    for(let x = 1; x <= columns.number; x++) {
        cc = ''
        switch (x) {
            case 2:
                if (columns[x] === 'school' && hasAllDaySchoolEvents) {
                    cc = (<div className={'col-' + (12/columns.number)} key={'school' + x}>{getAllDayEvents(content.schoolCalendar, 'success')}</div>)
                }
                if (columns[x] === 'personal' && hasAllDayPersonalEvents) {
                    cc = (<div className={'col-' + (12/columns.number)} key={'personal' + x}>{getAllDayEvents(content.personalCalendar, 'primary')}</div>)
                }
                break;
            case 3:
                if (columns[x] === 'school' && hasAllDaySchoolEvents) {
                    cc = (<div className={'col-' + (12/columns.number)} key={'school' + x}>{getAllDayEvents(content.schoolCalendar, 'success')}</div>)
                }
                if (columns[x] === 'personal' && hasAllDayPersonalEvents) {
                    cc = (<div className={'col-' + (12/columns.number)} key={'personal' + x}>{getAllDayEvents(content.personalCalendar, 'primary')}</div>)
                }
                break;
            case 4:
                if (columns[x] === 'school' && hasAllDaySchoolEvents) {
                    cc = (<div className={'col-' + (12/columns.number)} key={'school' + x}>{getAllDayEvents(content.schoolCalendar, 'success')}</div>)
                }
                if (columns[x] === 'personal' && hasAllDayPersonalEvents) {
                    cc = (<div className={'col-' + (12/columns.number)} key={'personal' + x}>{getAllDayEvents(content.personalCalendar, 'primary')}</div>)
                }
                break;
        }
        if (cc === '') {
            cc = (<div className={'col-' + (12/columns.number)} key={x}></div>)
        }
        columnContent.push(cc)
    }

    return (
            <div className={'row'}>
                <div className={'offset-1 col-2 card text-center'}>
                    {translateMessage(translations, 'All Day%1$s Events', {"%1$s": ''})}
                </div>
                <div className={'col-8 card'}>
                    <div className={'row'}>
                        {columnContent}
                    </div>
                </div>
            </div>
    )
}

AllDayEvents.propTypes = {
    translations: PropTypes.object.isRequired,
    content: PropTypes.object.isRequired,
    columns: PropTypes.object.isRequired,
    hasAllDayPersonalEvents: PropTypes.bool.isRequired,
    hasAllDaySchoolEvents: PropTypes.bool.isRequired,
    showSchoolCalendar: PropTypes.bool.isRequired,
    showPersonalCalendar: PropTypes.bool.isRequired,
}

function getAllDayEvents(events, colour){
    const allDayEvents = events.filter(event => {
        return event.eventType === 'All Day'
    })
    return allDayEvents.map((event, key) => {
        return (<div className={'alert alert-' + colour + ' text-center'} key={key}>{event.summary}</div>)
    })
}
