import { redirect, useNavigate, useRouteError } from "react-router-dom";
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
                    <h1>Did you get lost ?</h1>
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
            console.log(error.data.message);
            if (error.data.message === 'Expired JWT Token') {
                authService.logout();
            } else if (error.data.message === 'JWT Token not found') {
                redirect('/login');
            }
            return (
                <h1>Test</h1>
            );
        }
        default: {
            return (
                <h1>Error</h1>
            );
        }
    }
}

export default Error;
