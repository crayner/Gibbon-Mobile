'use strict';

import React from "react"
import SideNav, { Toggle } from './StyledSideNav'
import NavItems from './NavItems'
import {FontAwesomeIcon} from '@fortawesome/react-fontawesome'
import { library } from '@fortawesome/fontawesome-svg-core'
import { fas } from '@fortawesome/free-solid-svg-icons'
import PropTypes from 'prop-types'

library.add(fas)

export default function DisplayMenu(props) {
    const {
        expanded,
        toggleSideBar,
    } = props

    return (
            <SideNav
                expanded={expanded}
                onToggle={() => toggleSideBar()}
            >
                <Toggle>
                    {expanded ? <FontAwesomeIcon className={'hoverWhite'} size={'2x'} fixedWidth icon={['fas', 'times']} title={'close'} style={{marginTop: '12px'}} /> : <FontAwesomeIcon className={'hoverWhite'} size={'2x'} fixedWidth icon={['fas', 'bars']} title={'expand'}  />}
                </Toggle>
                <NavItems {...props} />
            </SideNav>
    )
}

DisplayMenu.propTypes = {
    expanded: PropTypes.bool.isRequired,
    toggleSideBar: PropTypes.func.isRequired,
}
