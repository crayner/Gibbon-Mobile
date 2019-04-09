'use strict';

import React, { Component } from 'react'
import PropTypes from 'prop-types'


export default class DashboardApp extends Component {
    constructor(props) {
        super(props)
        this.translations = props.translations
        this.locale = props.locale
        this.otherProps = {...props}
        console.log(props)
    }


    render () {
        return (
            <span>Do Something</span>
        )
    }
}


DashboardApp.propTypes = {
    locale: PropTypes.string,
    translations: PropTypes.object.isRequired,
}

DashboardApp.defaultProps = {
    locale: 'en_GB',
}
