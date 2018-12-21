'use strict';

import React from "react"
import PropTypes from 'prop-types'
import {translateMessage} from '../Component/MessageTranslator'
import DateHeader from './DateHeader'
import TimetableControls from './TimetableControls'

export default function SchoolDayClosed(props) {
    const {
        content,
        translations,
        ...otherProps
    } = props

    const error = typeof(content.error) === 'string' ? <div className={'row'}><div className={'col-12 alert-danger'}><p>{content.error}</p></div></div> : '' ;

    const name = Object.keys(content.specialDay).length === 0 ? translateMessage(translations, 'School Closed') : content.specialDay.name
    const description = Object.keys(content.specialDay).length === 0 ? '' : content.specialDay.description

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
                translations={translations}
            />
            <div className={'row'}>
                <div className={'col-10 offset-1 card'}>
                    <div style={{height: content.timeDiff + 'px', margin: "0 -15px"}} className={'schoolDayClosed d-flex justify-content-center align-self-center"'}><span style={{position: 'relative', top: '45%'}} title={description + 'This is a test description'}>{name}</span></div>
                </div>
            </div>
        </span>
    )
}

SchoolDayClosed.propTypes = {
    content: PropTypes.object.isRequired,
    translations: PropTypes.object.isRequired,
}

SchoolDayClosed.defaultProps = {}
