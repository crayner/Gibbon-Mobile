'use strict';

import React from "react"
import PropTypes from 'prop-types'
import "bootstrap/scss/bootstrap.scss";
import "bootstrap/scss/bootstrap-grid.scss";
import "bootstrap/dist/js/bootstrap.bundle";

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
