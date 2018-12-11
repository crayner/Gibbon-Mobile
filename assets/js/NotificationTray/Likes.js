'use strict';

import React from "react"
import PropTypes from 'prop-types'
import {FontAwesomeIcon} from '@fortawesome/react-fontawesome'
import {faStar} from '@fortawesome/free-regular-svg-icons'
import {translateMessage} from '../Component/MessageTranslator'

export default function Likes(props) {
    const {
        likeCount,
        translations,
        ...otherProps
    } = props

    const y = likeCount

    const colour = y === 0 ? 'grey' : 'tomato'

    const len = y.toString().length;
    const rr = len > 1 ? (35 - (len * 4)) : 28

    return (
        <span className="fa-layers fa-fw" style={{marginRight: '10px', minHeight: '50px'}} title={translateMessage(translations,'Likes')}>
            <FontAwesomeIcon className={y === 0 ? 'text-muted': 'alert-success'} icon={faStar} />
            <span className="fa-layers-counter" style={{background: colour, margin: '28px ' + rr + 'px 0 0'}}>{y}</span>
        </span>
    )
}

Likes.propTypes = {
    likeCount: PropTypes.number,
    translations: PropTypes.object.isRequired,
}

Likes.defaultProps = {
    likeCount: 0,
}
