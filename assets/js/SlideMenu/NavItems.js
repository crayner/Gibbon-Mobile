'use strict';

import React from "react"
import PropTypes from 'prop-types'
import { Nav, NavItem, NavIcon, NavText, SubNav } from './StyledSideNav'
import '../../css/SlideMenu/slideMenu.scss'
import {FontAwesomeIcon} from '@fortawesome/react-fontawesome'
import { library } from '@fortawesome/fontawesome-svg-core'
import { fab } from '@fortawesome/free-brands-svg-icons'
import { fas } from '@fortawesome/free-solid-svg-icons'
import { far } from '@fortawesome/free-regular-svg-icons'

library.add(fab, fas, far)

export default function NavItems(props) {
    const {
        menuItemClick,
        menu,
    } = props

    const navItems = menu.map((item) => {
        return subMenuItem(item)
    })

    function buildSubNavItems(item)
    {
        if (typeof item.items === 'undefined')
            return '';

        return item.items.map((subItem) => {
            return subMenuItem(subItem)
        })
    }

    function subMenuItem(item)
    {
        const subItems = buildSubNavItems(item)
        if (typeof(item.route) === 'string')
            return (
                <NavItem eventKey={item.eventKey} key={item.eventKey} onClick={() => menuItemClick({'data-route': item.route})}>
                    { typeof(item.icon) === 'object' && typeof(item.icon.iconName) === 'string' ?
                        <NavIcon>
                            <FontAwesomeIcon fixedWidth icon={[item.icon.prefix, item.icon.iconName]} title={item.text} />
                        </NavIcon> : '' }
                    { item.text !== null ?
                        <NavText>
                            {item.text}
                        </NavText> : '' }
                    {subItems}
                </NavItem>
            )
        else
            return (
                <NavItem eventKey={item.eventKey} key={item.eventKey}>
                    { typeof(item.icon) === 'object' && typeof(item.icon.iconName) === 'string' ?
                        <NavIcon>
                            <FontAwesomeIcon fixedWidth icon={[item.icon.prefix, item.icon.iconName]} title={item.text} />
                        </NavIcon> : '' }
                    { item.text !== null ?
                        <NavText>
                            {item.text}
                        </NavText> : '' }
                    {subItems}
                </NavItem>
            )
    }

    return (
        <Nav>
            {navItems}
        </Nav>
    )
}

NavItems.propTypes = {
    menuItemClick: PropTypes.func.isRequired,
    menu: PropTypes.array,
}

NavItems.defaultProps = {
    menu: [],
}

