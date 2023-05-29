import { Link, useNavigate } from "react-router-dom";
import "./style.css";
import authService from "../../services/auth.service";


const Header = () => {
    const navigate = useNavigate();

    return (
        <header>
            <Link to={'/'}>Logo</Link>
            <span className="header-user-card">
                <h2>Bienvenue, Gustiny2</h2>
                <button onClick={() => { authService.logout(); navigate(0) }}>Se déconnecter</button>
            </span>
        </header>
    );
}

export default Header;
