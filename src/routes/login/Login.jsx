import { useState } from 'react';
import './style.css';
import authService from '../../services/auth.service';
import { useNavigate, useNavigation } from 'react-router-dom';
import Loader from '../../components/loader/Loader'
import { AxiosError } from 'axios';

const Login = () => {
    const [username, setUsername] = useState('');
    const [password, setPassword] = useState('');
    const [isLoading, setIsLoading] = useState(false);
    const [error, setError] = useState(null);
    const navigate = useNavigate();
    
    const handleSubmit = async (e) => {
        e.preventDefault();
        
        setIsLoading(true);

        await authService.login(username, password)
            .then(response => {
                navigate('/', {replace: true});
            })
            .catch(err => {
                if (err instanceof AxiosError) {
                    setError('Identifiant/Mot de passe incorrect(s)');
                } else {
                    setError('Une erreur est survenue, veuillez réessayer ultérieurement');
                }
            })
            .finally(() => {
                setIsLoading(false);
            });
        
    }

    const handleFocus = () => {
        setError(null);
    }

    return (
        <div className='form-wrapper'>
            <div className="form-container">
                <h1>Se Connecter</h1>
                <form onSubmit={ handleSubmit }>
                    {/* <fieldset> */}
                        <div className="cool-input">
                            <input type="text" placeholder=" " onInput={ e => setUsername(e.target.value) } onFocus={ handleFocus } />
                            <label>Nom d'utilisateur</label>
                        </div>
                        <div className="cool-input">
                            <input type="password" placeholder=" " onInput={ e => setPassword(e.target.value) } onFocus={ handleFocus } />
                            <label>Mot de passe</label>    
                        </div>
                        <a href="" className='flat-button forgot'>Mot de passe oublié</a>
                        { error && <p>{ error }</p> }
                    {/* </fieldset> */}
                    <input type="submit" className='contained-button' value="Connexion" />
                </form>
            </div>
            { isLoading && <Loader /> }
        </div>
        
    )
}

export default Login;
