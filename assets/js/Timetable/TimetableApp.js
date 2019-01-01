'use strict';

import React, { Component } from 'react'
import PropTypes from 'prop-types'
import {fetchJson} from '../Component/fetchJson'
import {translateMessage} from '../Component/MessageTranslator'
import TimetableRender from './TimetableRender'
import {getDateString} from '../Component/getDateString'

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
            showPersonalCalendar: false,
            showSchoolCalendar: false,
            showSpaceBookingCalendar: false,
            schoolCalendar: {},
            personalCalendar: {},
            hasAllDaySchoolEvents: false,
            hasAllDayPersonalEvents: false,
            columns: {
                number: 1,
                2: false,
                3: false,
                4: false,
            },
        }

        this.changeDate = this.changeDate.bind(this)
        this.toggleTooltip = this.toggleTooltip.bind(this)
        this.togglePersonalCalendar = this.togglePersonalCalendar.bind(this)
        this.toggleSchoolCalendar = this.toggleSchoolCalendar.bind(this)
        this.toggleSpaceBookingCalendar = this.toggleSpaceBookingCalendar.bind(this)
        this.allocateColumns = this.allocateColumns.bind(this)
        this.hasAllDayEvents = this.hasAllDayEvents.bind(this)
    }

    componentDidMount () {
        this.loadTimetable(this.state.date)
    }

    componentWillUnmount() {
    }

    loadTimetable(date){
        this.setState({
            content: {},
        })
        let state = {}
        fetchJson('/timetable/' + date + '/' + this.person + '/display/', {method: 'GET'}, this.locale)
            .then(data => {
                if (data.content.render === true && data.content !== this.state.content) {
                    date = getDateString(data.content.date.date)
                    state.date = date
                    state.content = data.content,
                    state.schoolCalendar = data.content.schoolCalendar
                    state.personalCalendar = data.content.personalCalendar
                    state.hasAllDaySchoolEvents = this.hasAllDayEvents(data.content.schoolCalendar)
                    state.hasAllDayPersonalEvents = this.hasAllDayEvents(data.content.personalCalendar)
                    this.setState({...state})
                }
            })
    }

    changeDate(change, e){
        let date = change
        if (typeof(date) === 'object')
            date = getDateString(e)

        if (date === 'prev')
            date = 'prev-' + this.state.date
        if (date === 'next')
            date = 'next-' + this.state.date

        this.loadTimetable(date);
    }

    togglePersonalCalendar() {
        let state = {...this.state}
        state.showPersonalCalendar = ! state.showPersonalCalendar
        const columns = this.allocateColumns(state)
        this.setState({
            showPersonalCalendar: state.showPersonalCalendar,
            columns: columns,
            hasAllDayPersonalEvents: this.state.hasAllDayPersonalEvents && state.showPersonalCalendar,
        })
    }

    toggleSchoolCalendar() {
        let state = {...this.state}
        state.showSchoolCalendar = ! state.showSchoolCalendar
        const columns = this.allocateColumns(state)
        this.setState({
            showSchoolCalendar: state.showSchoolCalendar,
            columns: columns,
            hasAllDaySchoolEvents: this.state.hasAllDaySchoolEvents && state.showSchoolCalendar,
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
