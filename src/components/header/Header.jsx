import { Link } from "react-router-dom";
import "./style.css";
import HeaderUserCard from "../header_user_card/HeaderUserCard";
import { useState } from "react";


export default function Header() {
    const [loggedIn, setLoggedIn] = useState(localStorage.getItem('connect') ?? 'false');
    
    function handleClick() {
        localStorage.setItem('connect', true);
        setLoggedIn('true');
    }

    return (
        <header>
            <Link to={'/'}>Logo</Link>
            { loggedIn === 'true' ? (
                <HeaderUserCard setLoggedIn={setLoggedIn} />
            ) : (
                <button className="contained-button" onClick={handleClick}>Log In</button>
            )}
        </header>
    )
}







{/* <pre>

    1) En cas de faillite de l'entreprise, la responsabilité du propriétaire de la microentreprise est engagée
et ses biens peuvent être saisis car ils sont mélangés à ceux de l'entreprise.

    2) En cas de réussite, le propriétaire à main mise sur toutes les possessions de son entreprise.

    3) Moins de taxes, démarches simplifiées, exonération de TVA

    4) Ca dépend de la personne

    5) Cela limite le risque principal lié à la microentreprise, ce qui permet de mettre ses bénéfices en avant.
    Ainsi, incitant à la création de ce type d'entreprise, beaucoup moins risquée qu'auparavant et adonnant de
    nombreux avantages fiscaux.

    6) Elle permet de ne pas faire de déclaration juridique si l'on souhaite uniquement protéger sa résidence
    principale. De plus pour les entrepreneurs les moins préparées, cela peut être un bouclier sécurisant.

    7) En créant une EIRL, il faut choisir ce qui va passer dans le patrimoine de l'entreprise. Donc, le propriétaire
    a en quelque sorte un patrimoine personnel (qui ne pourra pas être saisi) et un patrimoine professionnel
    qui peut être engagé en cas de faillite.

    8) L'entrepreneur peut choisir ce qu'il veut introduire dans le patriomoine de son EIRL, donc en cas de problèmes
    seulement ce patrimoine pourra être engagé/saisi.

    9) Remboursement de crédits

    10) 

    11) 

</pre> */}