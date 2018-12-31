'use strict';

import React, { Component } from 'react'
import PropTypes from 'prop-types'
import {fetchJson} from '../Component/fetchJson'
import {translateMessage} from '../Component/MessageTranslator'
import TimetableRender from './TimetableRender'

export default class TimetableApp extends Component {
    constructor (props) {
        super(props)

        this.translations = props.translations
        this.locale = props.locale
        this.person = props.person
        this.otherProps = {...props}
        this.state = {
            date: 'today',
            content: {},
            tooltipOpen: {},
            showPersonalCalendar:false,
            showSchoolCalendar: false,
            showSpaceBookingCalendar: false,
            schoolCalendar: {},
            hasAllDaySchoolEvents: false,
            hasAllDayPersonalEvents: false,
            columns: {
                number: 1,
                2: false,
                3: false,
                4: false,
            },
        }

        this.timeout = 120000
        this.changeDate = this.changeDate.bind(this)
        this.toggleTooltip = this.toggleTooltip.bind(this)
        this.togglePersonalCalendar = this.togglePersonalCalendar.bind(this)
        this.toggleSchoolCalendar = this.toggleSchoolCalendar.bind(this)
        this.toggleSpaceBookingCalendar = this.toggleSpaceBookingCalendar.bind(this)
        this.allocateColumns = this.allocateColumns.bind(this)
        this.hasAllDayEvents = this.hasAllDayEvents.bind(this)
    }

    componentDidMount () {
        this.loadTimetable(10, this.state.date)
        this.loadSchoolTimetable(100, this.state.date, this.state.showSchoolCalendar)
    }

    componentWillUnmount() {
        clearTimeout(this.timetableLoad);
        clearTimeout(this.timetableSchoolLoad);
    }

    loadTimetable(timeout, date){
        this.timetableLoad = setTimeout(() => {
            fetchJson('/timetable/' + date + '/' + this.person + '/display/', {method: 'GET'}, this.locale)
                .then(data => {
                    if (data.content.render === true && data.content !== this.state.content) {
                        date = this.getDateString(data.content.date.date)
                        this.setState({
                            date: date,
                            content: data.content,
                        })
                    }
                    this.loadTimetable(this.timeout, date)
                })
        }, timeout)
    }

    loadSchoolTimetable(timeout, date, display){
        if (display) {
            this.timetableSchoolLoad = setTimeout(() => {
                fetchJson('/timetable/' + date + '/school/', {method: 'GET'}, this.locale)
                    .then(data => {
                        if (data.content !== this.state.schoolCalendar) {
                            const hasAllDayEvents = this.hasAllDayEvents(data.content)
                            this.setState({
                                hasAllDaySchoolEvents: hasAllDayEvents,
                                schoolCalendar: data.content,
                            })
                        }
                        this.loadSchoolTimetable(this.timeout, date)
                    })
            }, timeout)
        } else {
            this.timetableSchoolLoad = null
        }
    }

    getDateString(date)
    {
        if (typeof(date) === 'string')
            date = new Date(date)
        return date.getFullYear() + '-' + ('0' + (date.getMonth() + 1)).slice(-2) + '-' + ('0' + date.getDate()).slice(-2)
    }

    changeDate(change, e){
        let date = change
        if (typeof(date) === 'object')
            date = this.getDateString(e)

        if (date === 'prev')
            date = 'prev-' + this.state.date
        if (date === 'next')
            date = 'next-' + this.state.date

        clearTimeout(this.timetableLoad);
        clearTimeout(this.timetableSchoolLoad);
        this.setState({
            content: {},
        })
        this.loadTimetable(10, date);
        this.loadSchoolTimetable(101, date, this.state.showSchoolCalendar);
    }

    togglePersonalCalendar() {
        let state = {...this.state}
        state.showPersonalCalendar = ! state.showPersonalCalendar
        const columns = this.allocateColumns(state)
        this.setState({
            showPersonalCalendar: ! this.state.showPersonalCalendar,
            columns: columns,
        })
    }

    toggleSchoolCalendar() {
        clearTimeout(this.timetableSchoolLoad);
        let state = {...this.state}
        state.showSchoolCalendar = ! state.showSchoolCalendar
        const columns = this.allocateColumns(state)
        this.loadSchoolTimetable(1, this.state.date, ! this.state.showSchoolCalendar)
        let hasAllDaySchoolEvents = this.state.hasAllDaySchoolEvents
        if (state.showSchoolCalendar === false) {
            hasAllDaySchoolEvents = false
        }
        this.setState({
            showSchoolCalendar: ! this.state.showSchoolCalendar,
            columns: columns,
            hasAllDaySchoolEvents: hasAllDaySchoolEvents,
        })
    }

    toggleSpaceBookingCalendar() {
        let state = {...this.state}
        state.showSpaceBookingCalendar = ! state.showSpaceBookingCalendar
        const columns = this.allocateColumns(state)
        this.setState({
            showSpaceBookingCalendar: ! this.state.showSpaceBookingCalendar,
            columns: columns,
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

    hasAllDayEvents(content)
    {
        if (content.length > 0)
        {
            let result = content.filter(event => {
                return event.eventType === 'All Day'
            })
            if (result.length > 0) {
                return true
            }
        }
        return false
    }

    allocateColumns(state){
        let columns = {
            number: 1,
            2: false,
            3: false,
            4: false,
        }

        if (state.showPersonalCalendar) {
            ++columns.number
            columns[columns.number] = 'personal'
        }
        if (state.showSchoolCalendar) {
            ++columns.number
            columns[columns.number] = 'school'
        }
        if (state.showSpaceBookingCalendar) {
            ++columns.number
            columns[columns.number] = 'space'
        }
        return columns
    }


    render () {
        return (
            <div>
                <div className={'row border-bottom'}>
                    <div className="col-12">
                        <p className="text-lg-left text-uppercase">{translateMessage(this.translations,"My Timetable")}</p>
                    </div>
                </div>
                {Object.keys(this.state.content).length === 0 ?
                    <div>
                        <div className={'row'}>
                            <div className="col-12">
                                <div className="progress" title={translateMessage(this.translations, 'Loading')}>
                                    <div className="progress-bar progress-bar-striped bg-info progress-bar-animated" role="progressbar" style={{width: "100%"}}
                                         aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                        <div className={'row'}>
                            <div className="col-12">
                                <div className={'text-center'}>{translateMessage(this.translations, 'Loading')}...</div>
                            </div>
                        </div>
                    </div>
                : <TimetableRender
                        {...this.state}
                        {...this.otherProps}
                        translations={this.translations}
                        locale={this.locale}
                        toggleTooltip={this.toggleTooltip}
                        changeDate={this.changeDate}
                        togglePersonalCalendar={this.togglePersonalCalendar}
                        toggleSchoolCalendar={this.toggleSchoolCalendar}
                        toggleSpaceBookingCalendar={this.toggleSpaceBookingCalendar}
                        allocateColumns={this.allocateColumns}
                    /> }
            </div>
        )
    }
}

TimetableApp.propTypes = {
    translations: PropTypes.object.isRequired,
    locale: PropTypes.string,
    person: PropTypes.number.isRequired,
}

TimetableApp.defaultProps = {
    locale: 'en_GB',
}
