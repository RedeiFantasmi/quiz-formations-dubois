import { useState } from "react"


export default function useToken() {
    const getToken = () => {
        // const connectionDuration = 5; // 15 minutes
        // const connectionTime = localStorage.getItem('connectionTime') * 3600;
        // const now = Date.now() * 3600;

        // if (now - connectionTime > connectionDuration) localStorage.setItem('token', '');

        const token = localStorage.getItem('token');
        return token;
    }

    const [token, setToken] = useState(getToken());
    
    const saveToken = userToken => {
        localStorage.setItem('token', userToken);
        // localStorage.setItem('connectionTime', Date.now() * 3600);
        setToken(userToken);
    }

    

    return [
        token,
        saveToken,
    ]
}