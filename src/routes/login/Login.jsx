import { useState } from 'react';
import './style.css';
import authService from '../../services/auth.service';
import { useNavigate } from 'react-router-dom';
import authHeader from '../../services/auth-header';

const Login = () => {
    const [username, setUsername] = useState('');
    const [password, setPassword] = useState('');
    const navigate = useNavigate();
    
    const handleSubmit = async e => {
        e.preventDefault();
        

        await authService.login(username, password)
            .then(response => {
                navigate('/', {replace: true});
            })
            .catch(err => {
                console.log('bad cred');
            });
        
    }

    return (
        <div className='form-wrapper'>
            <div className="form-container">
                <h1>Se Connecter</h1>
                <form onSubmit={ handleSubmit }>
                    {/* <fieldset> */}
                        <div className="cool-input">
                            <input type="text" placeholder=" " onInput={ e => setUsername(e.target.value) } />
                            <label>Nom d'utilisateur</label>
                        </div>
                        <div className="cool-input">
                            <input type="password" placeholder=" " onInput={ e => setPassword(e.target.value) } />
                            <label>Mot de passe</label>    
                        </div>
                        <a href="" className='flat-button forgot'>Mot de passe oublié</a>
                        
                    {/* </fieldset> */}
                    <input type="submit" className='contained-button' value="Connexion" />
                </form>
            </div>
        </div>
        
    )
}

export default Login;
