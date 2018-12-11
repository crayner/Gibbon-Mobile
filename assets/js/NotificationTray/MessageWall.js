'use strict';

import React from "react"
import PropTypes from 'prop-types'
import {FontAwesomeIcon} from '@fortawesome/react-fontawesome'
import {faCommentAlt} from '@fortawesome/free-regular-svg-icons'
import {translateMessage} from '../Component/MessageTranslator'

export default function MessageWall(props) {
    const {
        messageCount,
        translations,
        ...otherProps
    } = props

    const y = messageCount

    const colour = y === 0 ? 'grey' : 'tomato'

    const len = y.toString().length;
    const rr = len > 1 ? (35 - (len * 4)) : 28

    return (
        <span className="fa-layers fa-fw" style={{marginRight: '10px', minHeight: '50px'}} title={translateMessage(translations,'Message Wall')}>
            <FontAwesomeIcon className={y === 0 ? 'text-muted': 'text-tomato'} icon={faCommentAlt} transform={'down-3 left-2'} />
            <FontAwesomeIcon className={y === 0 ? 'text-muted': 'text-tomato'} icon={faCommentAlt} transform={'rotate-180 up-3 right-2'} />
            <span className="fa-layers-counter" style={{background: colour, margin: '28px ' + rr + 'px 0 0'}}>{y}</span>
        </span>
    )
}

MessageWall.propTypes = {
    messageCount: PropTypes.number,
    translations: PropTypes.object.isRequired,
}

MessageWall.defaultProps = {
    messageCount: 0,
}
