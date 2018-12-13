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
    const rr = len > 1 ? (31 - (len * 4)) : 24

    return (
        <span className="fa-layers fa-fw" style={{marginRight: '10px', minHeight: '50px'}} title={translateMessage(translations,'Message Wall')} onClick={() => showMessenger()}>
            <FontAwesomeIcon className={y === 0 ? 'text-muted': 'alert-success'} icon={faCommentAlt} />
            <span className="fa-layers-counter" style={{background: colour, margin: '23px ' + rr + 'px 0 0'}}>{y}</span>
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
