'use strict';

import React, { Component } from 'react'
import {openPage} from '../Component/openPage'
import DisplayMenu from './DisplayMenu'

export default class SlideMenuApp extends Component {
    constructor (props) {
        super(props)

        this.menuItemClick = this.menuItemClick.bind(this)
        this.otherProps = {...props}
    }

    componentDidMount () {
    }

    componentWillUnmount() {
    }

    menuItemClick(item){
        if (item.hasOwnProperty('data-route'))
            openPage(item['data-route'], [], false)
    }

    render () {
        return (
            <DisplayMenu menuItemClick={this.menuItemClick} {...this.otherProps} />
        )
    }
}
