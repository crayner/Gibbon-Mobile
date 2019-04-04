import styled from 'styled-components';
import SideNav, {
    Toggle,
    Nav,
    NavItem,
    NavIcon,
    NavText,
} from '@trendmicro/react-sidenav';

// SideNav
const StyledSideNav = styled(SideNav)`
    color: #f9dcdd;
    background-color: #6FBC5E;
`;
StyledSideNav.defaultProps = SideNav.defaultProps;

// Toggle
const StyledToggle = styled(Toggle)`
    font-size: 18px;
`;
StyledToggle.defaultProps = Toggle.defaultProps;

// Nav
const StyledNav = styled(Nav)``;
StyledNav.defaultProps = Nav.defaultProps;

// NavItem
const StyledNavItem = styled(NavItem)`
    color: #f9dcdd;
`;
StyledNavItem.defaultProps = NavItem.defaultProps;

// NavIcon
const StyledNavIcon = styled(NavIcon)`
    font-size: 18px;
`;
StyledNavIcon.defaultProps = NavIcon.defaultProps;

// NavText
const StyledNavText = styled(NavText)`
`;
StyledNavText.defaultProps = NavText.defaultProps;

export {
    StyledToggle as Toggle,
    StyledNav as Nav,
    StyledNavItem as NavItem,
    StyledNavIcon as NavIcon,
    StyledNavText as NavText,
};
export default StyledSideNav;