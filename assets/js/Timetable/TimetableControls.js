'use strict';

import React from "react"
import PropTypes from 'prop-types'
import ButtonManager from '../Component/Button/ButtonManager'
import { faCalendarPlus, faCalendarMinus, faUser } from '@fortawesome/free-regular-svg-icons'
import { faSchool, faCubes, faCalendarDay } from '@fortawesome/free-solid-svg-icons'
import DayPickerInput from 'react-day-picker/DayPickerInput'
import 'react-day-picker/lib/style.css';
import {translateMessage} from '../Component/MessageTranslator'
import {getDateString} from '../Component/getDateString'

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
        locale,
    } = props

    const date = new Date(day.date.date)

    let picker = {}
    picker.modifiers = {}
    picker.modifiers.from = new Date(schoolYear.firstDay.date)
    picker.modifiers.to = new Date(schoolYear.lastDay.date)
    picker.className = 'form-control form-control-lg'
    picker.value = getDateString(date)
    picker.inputProps = {
        className: 'form-control form-control-lg',
    }
    picker.dayPickerProps = {
        locale: locale,
        disabledDays: {
            daysOfWeek: [0, 6],
        },
        style: {
            zIndex: 2000,
        },
        showOutsideDays: true,
    }

    const prev = {
        icon: faCalendarMinus,
        iconAttr: {size: '2x'},
        type: 'misc',
        colour: 'info',
        attr: {'data-date': picker.value, 'data-type': 'prevDay'},
        title: translateMessage(translations, 'Previous Day'),
    }

    const home = {
        icon: faCalendarDay,
        type: 'misc',
        colour: 'info',
        attr: {'data-date': picker.value, 'data-type': 'today'},
        title: translateMessage(translations, 'Today'),
        iconAttr: {size: '2x'},
        disabled: false,
    }

    const next = {
        icon: faCalendarPlus,
        type: 'misc',
        colour: 'info',
        attr: {'data-date': picker.value, 'data-type': 'nextDay'},
        iconAttr: {size: '2x'},
        title: translateMessage(translations, 'Next Day'),
    }

    const personal = {
        icon: faUser,
        type: 'misc',
        colour: 'primary',
        iconAttr: {size: '2x'},
        title: translateMessage(translations, 'Personal Calendar'),
    }

    const school = {
        icon: faSchool,
        type: 'misc',
        colour: 'success',
        iconAttr: {size: '2x'},
        title: translateMessage(translations, 'School Calendar'),
    }

    const space = {
        icon: faCubes,
        type: 'misc',
        colour: 'warning',
        iconAttr: {size: '2x'},
        title: translateMessage(translations, 'Bookings'),
    }

    return (
        <div className={'row'}>
            <div className={'col-12'}>
                <div className="text-right input-group">
                    <div className="input-group-prepend">
                        <ButtonManager button={{...prev}} miscButtonHandler={() => changeDate('prev')} />
                        <ButtonManager button={{...home}} miscButtonHandler={() => changeDate('today')} />
                    </div>
                    <DayPickerInput {...picker} onDayChange={changeDate} />
                    <div className="input-group-append">
                        <ButtonManager button={{...next}} miscButtonHandler={() => changeDate('next')} />
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
    locale: PropTypes.string.isRequired,
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
