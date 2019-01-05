'use strict';

import React from "react"
import PropTypes from 'prop-types'
import ButtonManager from '../Component/Button/ButtonManager'
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome'
import { faCalendar, faUser } from '@fortawesome/free-regular-svg-icons'
import { faSchool, faCubes, faCalendarDay } from '@fortawesome/free-solid-svg-icons'
import DatePicker from 'react-date-picker'
import {translateMessage} from '../Component/MessageTranslator'

export default function TimetableControls(props) {
    const {
        day,
        schoolYear,
        togglePersonalCalendar,
        toggleSchoolCalendar,
        toggleSpaceBookingCalendar,
        allowPersonalCalendar,
        allowSchoolCalendar,
        allowSpaceBookingCalendar,
        translations,
        changeDate,
        ...otherProps
    } = props

    const date = new Date(day.date.date)

    let picker = {};
    picker.value = date
    picker.minDate = new Date(schoolYear.firstDay.date)
    picker.maxDate = new Date(schoolYear.lastDay.date)
    picker.clearIcon = null
    picker.calendarIcon = <FontAwesomeIcon icon={faCalendar} />
    picker.onChange = (e) => changeDate(picker,e)
    picker.style = {}

    const today = {
        icon: faCalendarDay,
        type: 'misc',
        colour: 'info',
        attr: {'data-date': picker.value, 'data-type': 'today'},
        mergeClass: 'btn-sm',
        title: translateMessage(translations, 'Today'),
        disabled: false,
    }

    const personal = {
        icon: faUser,
        type: 'misc',
        colour: 'primary',
        mergeClass: 'btn-sm',
        title: translateMessage(translations, 'Personal Calendar'),
    }

    const school = {
        icon: faSchool,
        type: 'misc',
        colour: 'success',
        mergeClass: 'btn-sm',
        title: translateMessage(translations, 'School Calendar'),
    }

    const space = {
        icon: faCubes,
        type: 'misc',
        colour: 'warning',
        mergeClass: 'btn-sm',
        title: translateMessage(translations, 'Bookings'),
    }

    return (
        <div className={'row'}>
            <div className={'col-10 offset-1'}>
                <div className="input-group">
                    <div className="input-group-prepend">
                        <ButtonManager button={{...today}} miscButtonHandler={() => changeDate('today')} />
                    </div>
                    <DatePicker {...picker} />
                    <div className="input-group-append">
                        {allowPersonalCalendar ? <ButtonManager button={{...personal}} miscButtonHandler={() => togglePersonalCalendar()} /> : ''}
                        {allowSchoolCalendar ? <ButtonManager button={{...school}} miscButtonHandler={() => toggleSchoolCalendar()} /> : ''}
                        {allowSpaceBookingCalendar ? <ButtonManager button={{...space}} miscButtonHandler={() => toggleSpaceBookingCalendar()} /> : ''}
                    </div>
                </div>
            </div>
        </div>
    )
}

TimetableControls.propTypes = {
    day: PropTypes.object.isRequired,
    changeDate: PropTypes.func.isRequired,
    togglePersonalCalendar: PropTypes.func.isRequired,
    toggleSpaceBookingCalendar: PropTypes.func.isRequired,
    toggleSchoolCalendar: PropTypes.func.isRequired,
    translations: PropTypes.object.isRequired,
    schoolYear: PropTypes.object.isRequired,
    allowPersonalCalendar: PropTypes.bool.isRequired,
    allowSchoolCalendar: PropTypes.bool.isRequired,
    allowSpaceBookingCalendar: PropTypes.bool.isRequired,
}
