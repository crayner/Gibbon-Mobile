'use strict';

import React from "react"
import PropTypes from 'prop-types'

export default function FormLabel(props) {
    const {
        label,
    } = props

    if (label === false)
        return ('')

    return (
        <span>
            <ControlLabel>{label}</ControlLabel>
            <FormControl.Feedback />
        </span>
    )
}

FormLabel.propTypes = {
    label: PropTypes.oneOfType([
        PropTypes.bool,
        PropTypes.string,
    ]).isRequired,
}
