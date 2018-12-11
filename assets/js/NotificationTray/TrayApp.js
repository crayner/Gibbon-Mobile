'use strict';

import React, { Component } from 'react'
import MessageWall from './MessageWall'
import Likes from './Likes'
import Notifications from './Notifications'
import PropTypes from 'prop-types'
import {fetchJson} from '../Component/fetchJson'
import {openPage} from '../Component/openPage'

export default class TrayApp extends Component {
    constructor (props) {
        super(props)
        this.displayTray = props.displayTray
        this.locale = props.locale
        this.isStaff = props.isStaff
        this.otherProps = {...props}
        this.state = {
            messageCount: 0,
            likeCount: 0,
            notificationCount: 0,
        }
        this.timeout = this.isStaff === true ? 10000 : 120000
        this.showNotifications = this.showNotifications.bind(this)
    }

    componentDidMount () {
        if (this.displayTray){
            this.loadNotification(250 + 2000 * Math.random())
        }
    }

    componentWillUnmount() {
        clearTimeout(this.notificationTime);
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


    showNotifications() {
        if (this.state.notificationCount > 0)
            openPage('/notification/show/', {method: 'GET'}, this.locale);
    }

    render () {
        if (this.displayTray) {
            return (
                <div className={'text-right'}>
                    <Notifications notificationCount={this.state.notificationCount} {...this.otherProps} showNotifications={this.showNotifications} />
                    <Likes likeCount={this.state.likeCount} {...this.otherProps} />
                    <MessageWall messageCount={this.state.messageCount} {...this.otherProps} />
                </div>
            )
        }
        return (
            <div></div>
        )
    }
}

Notifications.propTypes = {
    displayTray: PropTypes.bool,
    isStaff: PropTypes.bool.isRequired,
    locale: PropTypes.string,
}

Notifications.defaultProps = {
    displayTray: false,
    locale: 'en_GB',
}
