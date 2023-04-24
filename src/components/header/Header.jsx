import { Link } from "react-router-dom";
import "./style.css";


const Header = ({ setToken }) => {

    return (
        <header>
            <Link to={'/'}>Logo</Link>
            <span className="header-user-card">
                <h2>Bienvenue, Gustiny2</h2>
                <button onClick={ () => setToken('') }>Se déconnecter</button>
            </span>
        </header>
    );
}

export default Header;
