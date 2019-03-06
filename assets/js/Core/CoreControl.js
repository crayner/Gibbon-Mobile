'use strict';

import React, { Component } from 'react'
import PropTypes from 'prop-types'
import IdleTimer from 'react-idle-timer'
import { openPage } from '../Component/openPage'
import {translateMessage} from '../Component/MessageTranslator'

export default class CoreControl extends Component {
    constructor (props) {
        super(props)
        this.idleTimer = null
        this.translations = props.translations
        this.locale = props.locale
        this.state = {
            timeout: 1000 * props.timeOut,
            remaining: null,
            lastActive: null,
            elapsed: null,
            display: false,
        }
        // Bind event handlers and methods
        this.onActive = this._onActive.bind(this)
        this.onIdle = this._onIdle.bind(this)
        this.reset = this._reset.bind(this)
        this.changeTimeout = this._changeTimeout.bind(this)
        this.enableTimeout = typeof props.enableTimeout === 'string' ? false : true
    }

    componentDidMount () {
        if (this.idleTimer !== null) {
            this.setState({
                remaining: this.idleTimer.getRemainingTime(),
                lastActive: this.idleTimer.getLastActiveTime(),
                elapsed: this.idleTimer.getElapsedTime(),
            })

            setInterval(() => {
                this.setState({
                    remaining: this.idleTimer.getRemainingTime(),
                    lastActive: this.idleTimer.getLastActiveTime(),
                    elapsed: this.idleTimer.getElapsedTime(),
                    display: this.state.timeout - this.idleTimer.getElapsedTime() > 30000 ? false : true,
                })
                if (this.wasLastActive !== this.idleTimer.getLastActiveTime())
                    this.refreshPage()
                this.wasLastActive = this.idleTimer.getLastActiveTime()
                if (this.state.elapsed > this.state.timeout)
                    this.logout()
            }, 1000)
        }
    }

    render () {
        return (
            <div>
                { this.enableTimeout ?
                    <IdleTimer
                        ref={ref => { this.idleTimer = ref }}
                        onActive={this.onActive}
                        onIdle={this.onIdle}
                        timeout={this.state.timeout}
                        throttle={50}
                        startOnLoad />
                    : ''}
                { this.state.display ?
                    <div style={{position: 'absolute', width: '100%', top: 0, left: 0, height: '100%', background: "lightblue url('/build/static/rosella.jpg') no-repeat fixed center", zIndex: 99999 }}>
                        <div style={{position: 'relative', width: '100%', top: 0, left: 0, height: '100%' }}>
                            <div className="text-center align-self-center container" style={{background: "peachpuff", maxWidth: '325px', position: 'absolute',top: '50%', left: '50%', transform: 'translate(-50%,-50%)', borderRadius: "5px" }}>
                                <div className={'row'} style={{padding: '2rem'}}>
                                    <div className={'col-12 alert alert-warning'} style={{borderRadius: "5px"}}>
                                        <h3>Gibbon-Responsive</h3>
                                        {translateMessage(this.translations, 'Your session is about to expire: you will be logged out shortly.')}
                                    </div>
                                </div>
                                <div className={'row'} style={{paddingBottom: '2rem'}}>
                                    <div className={'col-12 text-center'}>
                                        <button className={'btn btn-success'} onClick={() => this.reset}>{translateMessage(this.translations, 'Stay Connected')}</button>&nbsp;&nbsp;
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    :  '' }
            </div>
        )
    }


    refreshPage(){
        if (this.state.elapsed > this.state.timeout)
            openPage('/logout/', {method: 'GET'}, false)
        this.reset()
    }

    _onActive () {
        this.refreshPage()
    }

    _onIdle () {
    }

    _changeTimeout () {
        this.setState({
            timeout: this.refs.timeoutInput.state.value(),
        })
    }

    _reset () {
        this.idleTimer.reset()
    }

    logout () {
        openPage('/logout/', {method: 'GET'}, false)
    }
}

CoreControl.propTypes = {
    translations: PropTypes.object.isRequired,
    timeOut: PropTypes.number.isRequired,
    locale: PropTypes.string.isRequired,
    enableTimeout: PropTypes.oneOfType([
        PropTypes.string,
        PropTypes.object,
    ]).isRequired,
}
