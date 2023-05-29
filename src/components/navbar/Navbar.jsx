import { NavLink } from "react-router-dom";
import userProfile from "../UserProfile";
import "./style.css";
import authService from "../../services/auth.service";

const Navbar = () => {
    return (
        <nav>
            <NavLink to={'/'} activeclassname={'active'}>Dashboard</NavLink>
            {
                authService.hasRole('ROLE_FORMATEUR') && <NavLink to={'/quiz'} activeclassname={'active'}>Vos Quiz</NavLink>
            }
            <NavLink to={'/evaluations'} activeclassname={'active'}>Vos Evaluations</NavLink>
        </nav>
    );
}

export default Navbar;
