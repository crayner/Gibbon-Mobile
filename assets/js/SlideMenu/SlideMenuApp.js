'use strict';

import React, { Component } from 'react'
import {openPage} from '../Component/openPage'
import DisplayMenu from './DisplayMenu'
import ClickOutside from 'react-click-outside'

class SlideMenuApp extends Component {
    constructor (props) {
        super(props)

        this.menuItemClick = this.menuItemClick.bind(this)
        this.otherProps = {...props}
        this.state = {
            expanded: false,
        }

        this.toggleSideBar = this.toggleSideBar.bind(this)
        this.menuItemClick = this.menuItemClick.bind(this)
    }

    componentDidMount () {
    }

    componentWillUnmount() {
    }

    toggleSideBar() {
        this.setState({
            expanded: ! this.state.expanded,
        })
    }

    handleClickOutside() {
        if (this.state.expanded) {
            this.toggleSideBar()
        }
    }

    menuItemClick(item){
        if (item.hasOwnProperty('data-route'))
            openPage(item['data-route'], [], false)
    }

    render () {
        return (
            <DisplayMenu
                menuItemClick={this.menuItemClick}
                toggleSideBar={this.toggleSideBar}
                {...this.otherProps}
                {...this.state}
            />
        )
    }
}


export default ClickOutside(SlideMenuApp);