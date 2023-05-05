import { NavLink } from "react-router-dom";
import userProfile from "../UserProfile";
import "./style.css";

const Navbar = () => {
    const userType = userProfile.getType();

    return (
        <nav>
            <NavLink to={'/'} activeclassname={'active'}>Dashboard</NavLink>
            {
                userType === 'formateur' && <NavLink to={'/quiz'} activeclassname={'active'}>Vos Quiz</NavLink>
            }
            <NavLink to={'/evaluations'} activeclassname={'active'}>Vos Evaluations</NavLink>
        </nav>
    );
}

export default Navbar;
