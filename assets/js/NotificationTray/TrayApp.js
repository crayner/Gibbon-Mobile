'use strict';

import React, { Component } from 'react'
import MessageWall from './MessageWall'
import Likes from './Likes'
import Notifications from './Notifications'
import PropTypes from 'prop-types'
import {fetchJson} from '../Component/fetchJson'
import {openPage} from '../Component/openPage'
import Logout from './Logout'

export default class TrayApp extends Component {
    constructor (props) {
        super(props)
        this.displayTray = props.displayTray
        this.locale = props.locale
        this.isStaff = props.isStaff
        this.otherProps = {...props}
        this.state = {
            likeCount: 0,
            notificationCount: 0,
            messengerCount: 0,
        }
        this.timeout = this.isStaff === true ? 10000 : 120000
        this.showNotifications = this.showNotifications.bind(this)
        this.showMessenger = this.showMessenger.bind(this)
        this.handleLogout = this.handleLogout.bind(this)
    }

    componentDidMount () {
        if (this.displayTray){
            this.loadNotification(250 + 2000 * Math.random())
            this.loadMessenger(250 + 2000 * Math.random())
        }
    }

    componentWillUnmount() {
        clearTimeout(this.notificationTime);
        clearTimeout(this.messengerTime);
    }

    loadNotification(timeout){
        this.notificationTime = setTimeout(() => {
            fetchJson('/notification/details/', {method: 'GET'}, this.locale)
                .then(data => {
                    if (data.count !== this.state.notiificationCount) {
                        this.setState({
                            notificationCount: data.count,
                        })
                    }
                })
            this.loadNotification(this.timeout)
        }, timeout)
    }

    loadMessenger(timeout){
        this.messengerTime = setTimeout(() => {
            fetchJson('/messenger/details/', {method: 'GET'}, this.locale)
                .then(data => {
                    if (data.count !== this.state.messengerCount) {
                        this.setState({
                            messengerCount: data.count,
                        })
                    }
                })
            this.loadMessenger(this.timeout)
        }, timeout)
    }

    showNotifications() {
        if (this.state.notificationCount > 0)
            openPage('/notification/show/', {method: 'GET'}, this.locale);
    }

    showMessenger() {
        if (this.state.messengerCount > 0)
            openPage('/messenger/today/show/', {method: 'GET'}, this.locale);
    }

    handleLogout() {
        openPage('/logout/', {method: 'GET'}, false);
    }

    render () {
        if (this.displayTray) {
            return (
                <div className={'text-right'}>
                    <Logout handleLogout={this.handleLogout} {...this.otherProps} />
                    <MessageWall messengerCount={this.state.messengerCount} {...this.otherProps} showMessenger={this.showMessenger} />
                    <Notifications notificationCount={this.state.notificationCount} {...this.otherProps} showNotifications={this.showNotifications} />
                    {/* <Likes likeCount={this.state.likeCount} {...this.otherProps} /> */}
                </div>
            )
        }
        return (
            <div></div>
        )
    }
}

TrayApp.propTypes = {
    displayTray: PropTypes.bool,
    isStaff: PropTypes.bool.isRequired,
    locale: PropTypes.string,
}

TrayApp.defaultProps = {
    displayTray: false,
    locale: 'en_GB',
}
