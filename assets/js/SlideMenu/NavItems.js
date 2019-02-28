'use strict';

import React from "react"
import PropTypes from 'prop-types'
import SideNav, { Toggle, Nav, NavItem, NavIcon, NavText } from '@trendmicro/react-sidenav'
import {FontAwesomeIcon} from '@fortawesome/react-fontawesome'
import '../../css/SlideMenu/slideMenu.scss'
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

        const subItems = buildSubNavItems(item)

        return (
            <NavItem eventKey={item.eventKey} key={item.eventKey}>
                <NavIcon>
                    <FontAwesomeIcon size={'2x'} fixedWidth icon={[item.icon.prefix, item.icon.iconName]} title={item.text} onClick={() => menuItemClick({'data-route': item.route})} />
                </NavIcon>
                <NavText>
                    {item.text}
                </NavText>
                { subItems !== null ? subItems : '' }
            </NavItem>
        )
    })

    function buildSubNavItems(item)
    {
        if (typeof item.items === 'undefined')
            return null;
        console.log(item)
    }

    return (
        <SideNav.Nav>
            {navItems}
        </SideNav.Nav>
    )
}

NavItems.propTypes = {
    menuItemClick: PropTypes.func.isRequired,
    menu: PropTypes.array,
}

NavItems.defaultProps = {
    menu: [],
}
