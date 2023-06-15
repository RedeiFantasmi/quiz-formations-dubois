import { Link, useNavigate } from "react-router-dom";
import authService from "../../services/auth.service";
import "./style.css";


const Header = () => {
    const navigate = useNavigate();

    return (
        <header>
            <Link to={'/'}>Quiz DUBOIS</Link>
            <span className="header-user-card">
                <h2>Bienvenue, { authService.getUserName() }</h2>
                <button onClick={() => { authService.logout(); navigate('/login') }}>Se déconnecter</button>
            </span>
        </header>
    );
}

export default Header;
