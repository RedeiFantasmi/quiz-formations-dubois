

export default function Login() {
    return (
        <div className="form-container">
            <h1>Login Form</h1>
            <form>
                <div className="cool-input">
                    <input type="text" />
                    <label>Nom d'utilisateur</label>
                </div>
                <div className="cool-input">
                    <input type="password" />
                    <label>Mot de passe</label>
                </div>
                <input type="submit" value="Se connecter" />
            </form>
        </div>
    )
}