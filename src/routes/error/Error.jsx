import { AxiosError } from "axios";
import { NavLink, useRouteError } from "react-router-dom";
import authService from "../../services/auth.service";
import "./style.css";

const Error = () => {
    let error = useRouteError();
    console.log(error);
    
    if (error instanceof AxiosError) {
        error = error.response;
    }
    switch (error.status) {
        case 404: {
            return (
                <div className="error-wrapper">
                    <h1>Il n'y a rien à voir ici.</h1>
                    <NavLink to={'/'}>Retourner à l'accueil</NavLink>
                    {/* <img src="/404.gif" alt="damn antonin" /> */}
                </div>
            );
        }
        case 'noQuiz': {
            return (
                <div className="error-wrapper">
                    <h1>Pas de quiz ici.</h1>
                    <NavLink to={'/'}>Retourner à l'accueil</NavLink>
                    {/* <img src="/404.gif" alt="damn antonin" /> */}
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
                <>
                    <h1>Error</h1>
                    <NavLink to={'/'}>Go back home</NavLink>
                </>
                
            );
        }
    }
}

export default Error;
