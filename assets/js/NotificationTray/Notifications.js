'use strict';

import React from "react"
import PropTypes from 'prop-types'
import {FontAwesomeIcon} from '@fortawesome/react-fontawesome'
import {faStickyNote} from '@fortawesome/free-regular-svg-icons'
import {translateMessage} from '../Component/MessageTranslator'

export default function Notifications(props) {
    const {
        notificationCount,
        translations,
        showNotifications,
        ...otherProps
    } = props

    const y = notificationCount

    const colour = y === 0 ? 'grey' : 'tomato'

    const len = y.toString().length;
    const rr = len > 1 ? (29 - (len * 4)) : 22

    return (
        <span className="fa-layers fa-fw" style={{marginRight: '10px', minHeight: '50px'}} title={translateMessage(translations,'Notifications')} onClick={() => showNotifications()}>
            <FontAwesomeIcon className={y === 0 ? 'text-muted': 'alert-success'} icon={faStickyNote} />
            <span className={y === 0 ? 'fa-layers-counter text-counter-zero': 'fa-layers-counter text-tomato'} style={{margin: '26px ' + rr + 'px 0 0'}}>{y}</span>
        </span>
    )
}

Notifications.propTypes = {
    notificationCount: PropTypes.number,
    translations: PropTypes.object.isRequired,
    showNotifications: PropTypes.func.isRequired,
}

Notifications.defaultProps = {
    notificationCount: 0,
}
