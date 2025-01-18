import { NavLink } from "react-router-dom";

function Navigation() {
    return (
        <ul>
            <li>
                <NavLink to="/">General</NavLink>
            </li>
            <li><NavLink to="/about">About</NavLink></li>
        </ul>
    );
}

export default Navigation;
