'use strict';

import React from "react"
import PropTypes from 'prop-types'
import {translateMessage} from '../Component/MessageTranslator'

export default function AllDayEvents(props) {
    const {
        translations,
        ...otherProps
    } = props

    const allDayEvents = false

    if (allDayEvents === false)
        return (<div></div>)

    return (
            <div className={'row'}>
                <div className={'offset-1 col-2 card text-center'}>
                    {translateMessage(translations, 'All Day%1$s Events', {"%1$s": ''})}
                </div>
                <div className={'col-8 card'}>
                </div>
            </div>
    )
}

AllDayEvents.propTypes = {
    translations: PropTypes.object.isRequired,
}
