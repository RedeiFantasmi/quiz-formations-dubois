import { useState } from 'react';
import './style.css';

async function loginUser(credentials) {
    console.log(credentials);
    // const res = await fetch('login endpoint', {
    //     method: 'POST',
    //     body: 
    // });
    // return await res.json();

    return 'test';
}

const Login = ({ setToken }) => {
    const [username, setUsername] = useState('');
    const [password, setPassword] = useState('');

    const handleSubmit = async e => {
        e.preventDefault();

        const token = await loginUser({ username, password });
        setToken(token);
    }

    return (
        <div className='form-wrapper'>
            <div className="form-container">
                <h1>Se Gustiner 2</h1>
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
                    <input type="submit" className='contained-button' value="Lancer Gustinisation" />
                </form>
            </div>
        </div>
        
    )
}

export default Login;
