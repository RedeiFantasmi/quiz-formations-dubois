import "./style.css";
import { Link } from "react-router-dom";

export default function HeaderUserCard({setLoggedIn}) {
    function handleClick() {
        setLoggedIn('false');
    }

    return (
        <span className="header-user-card">
            <h2>Bienvenue, Jean Jacques</h2>
            {/* <Link>Se deconnecter</Link> */}
            <button onClick={handleClick}>Se déconnecter</button>
        </span>
    );
}