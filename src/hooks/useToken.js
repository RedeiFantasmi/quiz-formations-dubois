import { useState } from "react"


export default function useToken() {
    const getToken = () => {
        const connectionDuration = 3600; // 1 heure
        const connectionTime = localStorage.getItem('connectionTime') / 1000;
        const now = Date.now() / 1000;

        if (now - connectionTime > connectionDuration) localStorage.setItem('token', '');

        const token = localStorage.getItem('token');
        return token;
    }

    const [token, setToken] = useState(getToken());
    
    const saveToken = userToken => {
        localStorage.setItem('token', userToken);
        localStorage.setItem('connectionTime', Date.now());
        setToken(userToken);
    }

    

    return [
        token,
        saveToken,
    ]
}
