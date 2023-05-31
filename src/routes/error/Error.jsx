import { useRouteError } from "react-router-dom";
import "./style.css";
import { AxiosError } from "axios";
import authService from "../../services/auth.service";

const Error = () => {
    let error = useRouteError();
    
    if (error instanceof AxiosError) {
        error = error.response;
    }
    switch (error.status) {
        case 404: {
            return (
                <div className="error-wrapper">
                    <h1>Are you lost ?</h1>
                    <img src="/404.gif" alt="damn antonin" />
                </div>
            );
        }
        case 'noQuiz': {
            return (
                <div className="error-wrapper">
                    <h1>No quiz here.</h1>
                    <img src="/404.gif" alt="damn antonin" />
                </div>
            );
        }
        case 401: {
            switch (error.data.message) {
                case 'Expired JWT Token':
                    authService.logout();
                case 'JWT Token not found':
                    window.location.href = '/login';
                    break;
            }
            return <h1>Error 401</h1>
        }
        default: {
            return (
                <h1>Error</h1>
            );
        }
    }
}

export default Error;
