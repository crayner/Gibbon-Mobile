'use strict';

import React from 'react';
import PropTypes from 'prop-types'
import Button from './Button'

export default function ButtonDown(props) {
    const {
        button,
        downButtonHandler,
        ...otherProps
    } = props

    if (button.colour === '' || typeof(button.colour) === 'undefined')
        button.colour = 'light'

    if (button.icon === false || typeof(button.icon) === 'undefined')
        button.icon = ['fas','arrow-down']

    return (
        <Button
            button={button}
            buttonHandler={downButtonHandler}
            {...otherProps}
        />
    )
}

ButtonDown.propTypes = {
    button: PropTypes.object.isRequired,
    downButtonHandler: PropTypes.func,
}
