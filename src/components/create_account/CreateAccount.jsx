

const CreateAccount = () => {
    return (
        <div className="form-container">
            <h1>Create Account</h1>
            <form>
                <div className="cool-input">
                    <input type="text" name="nom" />
                    <label>Nom</label>
                </div>
                <div className="cool-input">
                    <input type="text" name="prenom" />
                    <label>Prénom</label>
                </div>
                <div className="cool-input">
                    <input type="text" name="mail" />
                    <label>Adresse email</label>
                </div>
                <div className="cool-input">
                    <input type="password" name="password" />
                    <label>Mot de passe</label>
                </div>
                <div className="cool-input">
                    <input type="text" name="role" />
                    <label>Role</label>
                </div>
                <input type="submit" value="Créer" />
            </form>
        </div>
    )
}

export default CreateAccount;
