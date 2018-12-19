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
        }
        this.timeout = 120000
    }

    componentDidMount () {
        this.loadTimetable(100)
    }

    componentWillUnmount() {
        clearTimeout(this.timetableLoad);
    }

    loadTimetable(timeout){
        this.timetableLoad = setTimeout(() => {
            fetchJson('/timetable/' + this.state.date + '/' + this.person + '/display/', {method: 'GET'}, this.locale)
                .then(data => {
                    console.log(data)
                    if (data.content.render === true && data.content !== this.state.content) {
                        this.setState({
                            date: data.date,
                            content: data.content,
                        })
                    }
                })
            this.loadTimetable(this.timeout)
        }, timeout)
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
                : <TimetableRender {...this.state} {...this.otherProps} translations={this.translations} locale={this.locale} /> }
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
