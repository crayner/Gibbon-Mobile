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
            day: {},
            events: [],
            tooltipOpen: {},
            showPersonalCalendar: false,
            showSchoolCalendar: false,
            showSpaceBookingCalendar: false,
            schoolOpen: true,
            loadEvents: true,
        }

        this.changeDate = this.changeDate.bind(this)
        this.toggleTooltip = this.toggleTooltip.bind(this)
        this.togglePersonalCalendar = this.togglePersonalCalendar.bind(this)
        this.toggleSchoolCalendar = this.toggleSchoolCalendar.bind(this)
        this.toggleSpaceBookingCalendar = this.toggleSpaceBookingCalendar.bind(this)
    }

    componentDidMount () {
        this.loadTimetable(this.state.day)
    }

    loadTimetable(day){
        this.setState({
            loadEvents: true,
        })
        const date = typeof(day) === 'object' && Object.keys(day).length > 0 ? getDateString(day.date.date) : (typeof(day) === 'string' ? day : 'today')
        fetchJson('/timetable/' + date + '/' + this.person + '/display/', {method: 'GET'}, this.locale)
            .then(data => {
                if (data.content.day !== this.state.day) {
                    this.setState({
                        day: data.content.day,
                        events: data.content.events,
                        schoolOpen: data.content.schoolOpen,
                        loadEvents: false,
                    })
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

    render () {
        return (
            <div>
                <div className={'row border-bottom'}>
                    <div className="col-12">
                        <p className="text-lg-left text-uppercase">{translateMessage(this.translations,"My Timetable")}</p>
                    </div>
                </div>
                {this.state.loadEvents ?
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
