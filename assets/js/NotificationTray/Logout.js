'use strict';

import React from "react"
import PropTypes from 'prop-types'
import {FontAwesomeIcon} from '@fortawesome/react-fontawesome'
import {faSignOutAlt} from '@fortawesome/free-solid-svg-icons'
import {translateMessage} from '../Component/MessageTranslator'

export default function Logout(props) {
    const {
        translations,
        handleLogout,
    } = props

    return (
        <span className="fa-fw" style={{minHeight: '120%', marginTop: '-0.45rem', float: 'right'}} title={translateMessage(translations,'Logout')} onClick={() => handleLogout()}>
            <FontAwesomeIcon className={'alert-success'} icon={faSignOutAlt} />
        </span>
    )
}

Logout.propTypes = {
    handleLogout: PropTypes.func.isRequired,
    translations: PropTypes.object.isRequired,
}
