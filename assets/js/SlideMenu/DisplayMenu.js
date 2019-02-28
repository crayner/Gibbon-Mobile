'use strict';

import React from "react"
import SideNav from '@trendmicro/react-sidenav'
import NavItems from './NavItems'

export default function DisplayMenu(props) {

    return (
        <SideNav
            onSelect={(selected) => {
                // Add your code here
            }}
            style={{backgroundColor: 'rgba(50, 160, 25, 0.7)'}}
        >
            <SideNav.Toggle />
            <NavItems {...props} />
        </SideNav>
    )
}
