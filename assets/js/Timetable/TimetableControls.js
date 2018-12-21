'use strict';

import React from "react"
import PropTypes from 'prop-types'
import ButtonManager from '../Component/Button/ButtonManager'
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome'
import { faCalendar, faCalendarCheck, faCalendarPlus, faCalendarMinus } from '@fortawesome/free-regular-svg-icons'
import DatePicker from 'react-date-picker'
import {translateMessage} from '../Component/MessageTranslator'

export default function TimetableControls(props) {
    const {
        content,
        changeDate,
        translations,
        schoolYear,
        ...otherProps
    } = props

    const date = new Date(content.date)

    let picker = {};
    picker.value = date
    picker.minDate = new Date(schoolYear.firstDay.date)
    picker.maxDate = new Date(schoolYear.lastDay.date)
    picker.clearIcon = null
    picker.calendarIcon = <FontAwesomeIcon icon={faCalendar} />
    picker.onChange = (e) => changeDate(picker,e)
    picker.className = 'small'

    const prev = {
        icon: faCalendarMinus,
        type: 'misc',
        colour: 'info',
        attr: {'data-date': picker.value, 'data-type': 'prevDay'},
        title: translateMessage(translations, 'Previous Day'),
        mergeClass: 'btn-sm',
    }

    const home = {
        icon: faCalendarCheck,
        type: 'misc',
        colour: 'info',
        attr: {'data-date': picker.value, 'data-type': 'today'},
        mergeClass: 'btn-sm',
        title: translateMessage(translations, 'Today'),
        disabled: false,
    }

    const next = {
        icon: faCalendarPlus,
        type: 'misc',
        colour: 'info',
        mergeClass: 'btn-sm',
        attr: {'data-date': picker.value, 'data-type': 'nextDay'},
        title: translateMessage(translations, 'Next Day'),
    }

    return (
        <div className={'row'}>
            <div className={'col-10 offset-1'}>
                <div className="input-group">
                    <div className="input-group-prepend">
                        <ButtonManager button={{...prev}} miscButtonHandler={() => changeDate('prev')} />
                        <ButtonManager button={{...home}} miscButtonHandler={() => changeDate('today')} />
                    </div>
                    <DatePicker {...picker} />
                    <div className="input-group-append">
                        <ButtonManager button={{...next}} miscButtonHandler={() => changeDate('next')} />
                    </div>
                </div>
            </div>
        </div>
    )
}

TimetableControls.propTypes = {
    content: PropTypes.object.isRequired,
    changeDate: PropTypes.func.isRequired,
    translations: PropTypes.object.isRequired,
    schoolYear: PropTypes.object.isRequired,
}
