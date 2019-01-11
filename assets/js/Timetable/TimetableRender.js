'use strict';

import React from "react"
import TimetableControls from './TimetableControls'
import DateHeader from './DateHeader'
import DayEvents from './DayEvents'
import {translateMessage} from '../Component/MessageTranslator'
import PropTypes from 'prop-types'
import Messages from '../Component/Messages/Messages'

export default function TimetableRender(props) {
    const {
        messages,
        loadEvents,
        translations,
        ...otherProps
    } = props

    const content = loadEvents ? (
        <div className={'container-fluid timetable'}>
            <div className={'row border-bottom'}>
                <div className="col-12">
                    <p className="text-lg-left text-uppercase">{translateMessage(translations, "My Timetable")}</p>
                </div>
            </div>
            <Messages messages={messages} />
            <div className={'row'}>
                <div className="col-12">
                    <div className="progress" title={translateMessage(translations, 'Loading')}>
                        <div className="progress-bar progress-bar-striped bg-info progress-bar-animated"
                             role="progressbar" style={{width: "100%"}}
                             aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
            <div className={'row'}>
                <div className="col-12">
                    <div className={'text-center'}>{translateMessage(translations, 'Loading')}...
                    </div>
                </div>
            </div>
        </div>
    ) : (
        <div className={'container-fluid timetable'}>
            <div className={'row border-bottom'}>
                <div className="col-12">
                    <p className="text-lg-left text-uppercase">{translateMessage(translations, "My Timetable")}</p>
                </div>
            </div>
            <Messages messages={messages} />
            <TimetableControls {...otherProps} translations={translations} />
            <DateHeader {...otherProps} translations={translations} />
            <DayEvents {...otherProps} translations={translations} />
        </div>
    )

    return (<section>{content}</section>)
}

TimetableRender.propTypes = {
    loadEvents: PropTypes.bool.isRequired,
    messages: PropTypes.array.isRequired,
    translations: PropTypes.object.isRequired,
}


