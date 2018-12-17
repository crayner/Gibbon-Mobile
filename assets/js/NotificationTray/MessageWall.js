'use strict';

import React from "react"
import PropTypes from 'prop-types'
import {FontAwesomeIcon} from '@fortawesome/react-fontawesome'
import {faCommentAlt} from '@fortawesome/free-regular-svg-icons'
import {translateMessage} from '../Component/MessageTranslator'

export default function MessageWall(props) {
    const {
        messengerCount,
        translations,
        showMessenger,
    } = props

    const y = messengerCount

    const colour = y === 0 ? 'grey' : 'tomato'

    const len = y.toString().length;

    let rr = 0

    switch (len) {
        case 2:
            rr = 1.45
            break;
        case 3:
            rr = 1.2
            break;
        case 4:
            rr = 0.8
            break;
        default:
            rr = 1.5
    }

    return (
        <span className="fa-layers fa-fw" style={{marginRight: '0.3rem', minHeight: '120%', float: 'right', marginTop: '0'}} title={translateMessage(translations,'Message Wall')} onClick={() => showMessenger()}>
            <FontAwesomeIcon className={y === 0 ? 'text-muted': 'alert-success'} icon={faCommentAlt} />
            <span className="fa-layers-counter" style={{background: colour, margin: '0.80rem ' + rr + 'rem 0 0'}}>{y}</span>
        </span>
    )
}

MessageWall.propTypes = {
    messengerCount: PropTypes.number,
    translations: PropTypes.object.isRequired,
    showMessenger: PropTypes.func.isRequired,
}

MessageWall.defaultProps = {
    messengerCount: 0,
}
