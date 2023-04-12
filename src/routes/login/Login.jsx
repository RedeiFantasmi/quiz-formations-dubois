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

export default function Login({ setToken }) {
    const [username, setUsername] = useState('');
    const [password, setPassword] = useState('');

    const handleSubmit = async e => {
        e.preventDefault();

        const token = await loginUser({ username, password });
        setToken(token);
    }

    return (
        <div className="form-container">
            <h1>Se connecter</h1>
            <form onSubmit={ handleSubmit } >
                <div className="cool-input">
                    <input type="text" placeholder=" " onInput={ e => setUsername(e.target.value) } />
                    <label>Nom d'utilisateur</label>
                </div>
                <div className="cool-input">
                    <input type="password" placeholder=" " onInput={ e => setPassword(e.target.value) } />
                    <label>Mot de passe</label>
                </div>
                <input type="submit" className='contained-button' value="Se connecter" />
            </form>
            <a href="" className='flat-button forgot'>Mot de passe oublié</a>
        </div>
    )
}