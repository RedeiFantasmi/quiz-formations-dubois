import './style.css';

export default function Login() {
    return (
        <div className="form-container">
            <h1>Se connecter</h1>
            <form action='/'>
                <div className="cool-input">
                    <input type="text" placeholder=" " />
                    <label>Nom d'utilisateur</label>
                </div>
                <div className="cool-input">
                    <input type="password" placeholder=" " />
                    <label>Mot de passe</label>
                </div>
                <input type="submit" className='contained-button' value="Se connecter" />
            </form>
        </div>
    )
}