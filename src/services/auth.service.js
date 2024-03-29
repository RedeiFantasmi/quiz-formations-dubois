import axios from "axios";
import authHeader from "./auth-header";

const API_URL = import.meta.env.VITE_API_URL;

const login = (username, password) => {
    return axios
        .post(`${API_URL}/login`, {
            username,
            password
        })
        .then((response) => {
            if (response.data.token) {
                localStorage.setItem('user', JSON.stringify(response.data));
            }

            axios.defaults.headers.common.Authorization = authHeader();

            return response.data;
        });
}

const logout = () => {
    localStorage.removeItem('user');
}

const getCurrentUser = () => {
    return JSON.parse(localStorage.getItem('user'));
}

const getUserName = () => {
    return getCurrentUser()?.name ?? 'Invité';
}

const hasRole = (permission) => {
    const roles = getCurrentUser()?.roles ?? [];
    return roles.includes(permission);
}

const authService = {
    login,
    logout,
    getCurrentUser,
    getUserName,
    hasRole,
}

export default authService;
