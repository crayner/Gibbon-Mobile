'use strict';

import React from "react"
import PropTypes from 'prop-types'
import "bootstrap/scss/bootstrap.scss";
import "bootstrap/scss/bootstrap-grid.scss";
import "bootstrap/dist/js/bootstrap.bundle";

export default function FormHelp(props) {
    const {
        help,
    } = props

    if (help === false || help === null || help === '')
        return ''

    return (
        <HelpBlock className={'text-muted form-text small'}>{help}</HelpBlock>
    )
}

FormHelp.propTypes = {
    help: PropTypes.string,
}

FormHelp.defaultProps = {
    help: '',
}
