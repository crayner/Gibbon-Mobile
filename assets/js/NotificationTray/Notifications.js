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

    let rr = 0

    switch (len) {
        case 2:
            rr = 1.25
            break;
        case 3:
            rr = 1.0
            break;
        case 4:
            rr = 0.65
            break;
        default:
            rr = 1.3
    }

    return (
        <span className="fa-layers fa-fw" style={{marginRight: '0.3rem', minHeight: '120%', float: 'right', marginTop: '-0.15rem'}} title={translateMessage(translations,'Notifications')} onClick={() => showNotifications()}>
            <FontAwesomeIcon className={y === 0 ? 'text-muted': 'alert-success'} icon={faStickyNote} />
            <span className={y === 0 ? 'fa-layers-counter text-counter-zero': 'fa-layers-counter text-tomato'} style={{margin: '0.97rem ' + rr + 'rem 0 0'}}>{y}</span>
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
