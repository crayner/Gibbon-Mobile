'use strict';

import React, { Component } from 'react'
import PropTypes from 'prop-types'
import {fetchJson} from '../Component/fetchJson'
import TimetableRender from './TimetableRender'
import {getDateString} from '../Component/getDateString'
import AttendanceRender from '../Attendance/AttendanceRender'
import {openPage} from '../Component/openPage'

export default class TimetableApp extends Component {
    constructor (props) {
        super(props)
        this.otherProps = {...props}
        this.locale = this.otherProps.locale
        const today = new Date()
        this.state = {
            day: {
                date: {
                    date: getDateString(today),
                    colour: '#e4e4e4',
                    fontColour: '#666666',
                },
            },
            events: [],
            tooltipOpen: {},
            showPersonalCalendar: false,
            showSchoolCalendar: false,
            showSpaceBookingCalendar: false,
            schoolOpen: true,
            loadEvents: true,
            showStatus: 'timetable',
            messages: [],
        }

        this.days = {}
        this.preLoad = []
        this.preLoadIsOn = false
        this.schoolYear = this.otherProps.schoolYear
        this.daysOfWeek = this.otherProps.daysOfWeek
        this.person = this.otherProps.person
        this.changeDate = this.changeDate.bind(this)
        this.toggleTooltip = this.toggleTooltip.bind(this)
        this.togglePersonalCalendar = this.togglePersonalCalendar.bind(this)
        this.toggleSchoolCalendar = this.toggleSchoolCalendar.bind(this)
        this.toggleSpaceBookingCalendar = this.toggleSpaceBookingCalendar.bind(this)
        this.takeAttendance = this.takeAttendance.bind(this)
        this.takeStudentAttendance = this.takeStudentAttendance.bind(this)
    }

    componentDidMount () {
        this.getDay(this.state.day, true)
        let date = this.state.day.date.date
        for(let x=0; x<5; x++)
        {
            date = this.decrementDate(date)
            if (! this.days.hasOwnProperty(date) && ! this.preLoad.includes(date))
                this.preLoad.push(date)
        }
        this.startPreLoad()
    }

    isDateInSchoolYear(date) {
        this.direction = ! this.direction
        if (date < getDateString(this.schoolYear.firstDay.date))
            return false
        if (date > getDateString(this.schoolYear.lastDay.date))
            return false
        this.direction = ! this.direction
        return true
    }

    selectAnotherDay(day){
        if (this.direction)
            this.getDay(this.incrementDate(day), true)
        else {
            this.getDay(this.decrementDate(day), false)
        }
    }

    getDay(day) {
        let date = new Date()
        if (typeof(day) === 'object' && day.hasOwnProperty('date')) {
            date = new Date(day.date.date)
        }

        else if (typeof(day) === 'object' && typeof date.getMonth === 'function') {
            date = day
        }

        else if (typeof(day) === 'string')
        {
            date = new Date(day)
        }

        date = getDateString(date)

        if (! this.isDateInSchoolYear(date)) {
            this.selectAnotherDay(date)
            return
        }
        if (this.days.hasOwnProperty(date)) {
            if (this.days[date].valid) {
                this.setPreLoadDates(this.days[date].day.date.date)
                this.setState({
                    day: this.days[date].day,
                    events: this.days[date].events,
                    schoolOpen: this.days[date].schoolOpen,
                    showStatus: 'timetable',
                })
            } else {
                this.selectAnotherDay(date)
                return
            }
        } else {
            if (this.isNotASchoolDay(date)) {
                this.selectAnotherDay(date)
                return
            }
            this.loadTimetable(date)
        }
    }

    isNotASchoolDay(date)
    {
        let day = new Date(date)
        day = day.getDay() > 0 ? day.getDay() : 7
        let theDay = Object.keys(this.daysOfWeek).filter(key => {
            const item = this.daysOfWeek[key]
            if (item.sequenceNumber === day)
                return item
        })
        theDay = this.daysOfWeek[theDay]
        if (theDay.schoolDay === 'N')
            return true
        return false
    }

    loadTimetable(date){
        this.setState({
            loadEvents: true,
            showStatus: 'timetable',
        })
        fetchJson('/timetable/' + date + '/' + this.person + '/display/', {method: 'GET'}, this.locale)
            .then(data => {
                if (data.content.valid === 'error')
                    return
                if (data.content.day !== this.state.day) {
                    const newDate = getDateString(data.content.day.date.date)
                    this.days[newDate] = data.content
                    if (date !== newDate) {
                        this.insertEmptyDay(date)
                    }
                    this.setPreLoadDates(data.content.day.date.date)
                    this.setState({
                        day: data.content.day,
                        events: data.content.events,
                        schoolOpen: data.content.schoolOpen,
                        loadEvents: false,
                    })
                }
            })
    }

    insertEmptyDays(newDate, date) {
        while (newDate !== date) {
            this.days[newDate] = {
                schoolOpen: false,
                day: {
                    date: {date: newDate},
                    colour: '#e4e4e4',
                    fontColour: '#666666',
                },
                events: [],
                valid: false,
            }
            newDate = this.incrementDate(newDate)
        }
    }

    incrementDate(date){
        date = new Date(date)
        date.setDate(date.getDate() + 1)
        date = getDateString(date)
        return date
    }

    decrementDate(date){
        date = new Date(date)
        date.setDate(date.getDate() - 1)
        date = getDateString(date)
        return date
    }

    dateDiffInDays(a, b) {
        a = new Date(a)
        b = new Date(b)
        // Discard the time and time-zone information.
        const utc1 = Date.UTC(a.getFullYear(), a.getMonth(), a.getDate());
        const utc2 = Date.UTC(b.getFullYear(), b.getMonth(), b.getDate());

        return Math.floor((utc2 - utc1) / (1000 * 60 * 60 * 24));
    }

    setPreLoadDates(date)
    {
        for(let x=0; x<5; x++)
        {
            date = this.incrementDate(date)
            if (! this.days.hasOwnProperty(date) && ! this.preLoad.includes(date))
                this.preLoad.push(date)
        }
        this.startPreLoad()
    }

    startPreLoad() {
        if (this.preLoadIsOn)
            return
        this.preLoadIsOn = true
        this.preLoadTimetableDays()
    }

    preLoadTimetableDays()
    {
        if (this.preLoad.length === 0) {
            this.preLoadIsOn = false
            return
        }

        let newDate = this.preLoad[0]
        this.preLoad.shift()

        if (! this.isDateInSchoolYear(newDate)) {
            this.preLoadTimetableDays()
            return
        }
        if (this.days.hasOwnProperty(newDate)) {
            this.preLoadTimetableDays()
            return
        }
        fetchJson('/timetable/' + newDate + '/' + this.person + '/display/', {method: 'GET'}, this.locale)
            .then(data => {
                if (data.content.day !== this.state.day) {
                    let date = getDateString(data.content.day.date.date)
                    if (newDate !== date)
                        this.insertEmptyDays(newDate, date)
                    this.days[date] = data.content
                }
                this.preLoadTimetableDays()
            })
    }

    changeDate(change){
        this.direction = true

        let date = change

        if (date === 'next') {
            date = this.incrementDate(this.state.day.date.date)
        }
        if (date === 'prev') {
            date = this.decrementDate(this.state.day.date.date)
            this.direction = false
        }

        if (date === 'today')
            date = getDateString(new Date())

        this.getDay(date);
    }

    togglePersonalCalendar() {
        this.setState({
            showPersonalCalendar: ! this.state.showPersonalCalendar,
        })
    }

    toggleSchoolCalendar() {
        this.setState({
            showSchoolCalendar: ! this.state.showSchoolCalendar,
        })
    }

    toggleSpaceBookingCalendar() {
        this.setState({
            showSpaceBookingCalendar: ! this.state.showSpaceBookingCalendar,
        })
    }

    toggleTooltip(toggleId) {
        let tooltipOpen = this.state.tooltipOpen
        if (tooltipOpen.hasOwnProperty(toggleId))
            tooltipOpen[toggleId] = !tooltipOpen[toggleId]
        else
            tooltipOpen[toggleId] = false

        this.setState({
            tooltipOpen: tooltipOpen,
        });
    }

    takeAttendance(url){
        this.setState({
            loadEvents: true,
            showStatus: 'attendance',
            attendance: {},
            messages: [],
        })
        fetchJson(url, {method: 'GET'}, this.locale)
            .then(data => {
                this.setState({
                    showStatus: 'attendance',
                    attendance: data.content,
                    messages: data.messages,
                    loadEvents: false,
                })
                if (data.redirect)
                    openPage('/', {}, this.locale)
            })
    }

    takeStudentAttendance(event, student){
        const value = event.currentTarget.value
        let attendance = {...this.state.attendance}
        const id = student.person.id
        if (attendance.students.hasOwnProperty(id)) {
            student.attendance.code = parseInt(value)
            attendance.students[id] = student
            this.setState({
                attendance: attendance,
            })
            if(attendance.type === 'courseClass'){
                fetchJson('/attendance/class/record/', {body: JSON.stringify(attendance), method: 'POST'}, this.locale)
                    .then(data => {
                        this.setState({
                            showStatus: 'attendance',
                            attendance: data.content,
                            messages: data.messages,
                        })
                    })
            }

        }

    }

    render () {
        if (this.state.showStatus === 'timetable') {
            return (
                <TimetableRender
                    {...this.otherProps}
                    {...this.state}
                    toggleTooltip={this.toggleTooltip}
                    changeDate={this.changeDate}
                    togglePersonalCalendar={this.togglePersonalCalendar}
                    toggleSchoolCalendar={this.toggleSchoolCalendar}
                    toggleSpaceBookingCalendar={this.toggleSpaceBookingCalendar}
                    takeAttendance={this.takeAttendance}
                />
            )
        }
        else if (this.state.showStatus === 'attendance') {
            return (
                <AttendanceRender
                    {...this.otherProps}
                    {...this.state}
                    takeStudentAttendance={this.takeStudentAttendance}
                />
            )
        }
    }
}

TimetableApp.propTypes = {
    locale: PropTypes.string,
}

TimetableApp.defaultProps = {
    locale: 'en_GB',
}
