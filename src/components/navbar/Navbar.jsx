import { NavLink } from "react-router-dom"
import "./style.css";

const Navbar = () => {
    return (
        <nav>
            <NavLink to={'/'} activeclassname={'active'}>Dashboard</NavLink>
            {/* <hr /> */}
            <NavLink to={'/quiz'} activeclassname={'active'}>Vos Quiz</NavLink>
            <NavLink to={'/evaluations'} activeclassname={'active'}>Vos Evaluations</NavLink>
        </nav>
    );
}

export default Navbar;
