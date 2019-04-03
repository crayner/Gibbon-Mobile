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
    float: right; 
    background-color: rgba(50, 160, 25, 0.7);
`;
StyledSideNav.defaultProps = SideNav.defaultProps;

// Toggle
const StyledToggle = styled(Toggle)``;
StyledToggle.defaultProps = Toggle.defaultProps;

// Nav
const StyledNav = styled(Nav)``;
StyledNav.defaultProps = Nav.defaultProps;

// NavItem
const StyledNavItem = styled(NavItem)``;
StyledNavItem.defaultProps = NavItem.defaultProps;

// NavIcon
const StyledNavIcon = styled(NavIcon)``;
StyledNavIcon.defaultProps = NavIcon.defaultProps;

// NavText
const StyledNavText = styled(NavText)``;
StyledNavText.defaultProps = NavText.defaultProps;

export {
    StyledToggle as Toggle,
    StyledNav as Nav,
    StyledNavItem as NavItem,
    StyledNavIcon as NavIcon,
    StyledNavText as NavText,
};
export default StyledSideNav;