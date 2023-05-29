import { Outlet, useNavigate, useParams } from "react-router-dom";
import Header from "./components/header/Header";
import Navbar from "./components/navbar/Navbar";
import "./App.css";
import authService from "./services/auth.service";
import { useEffect } from "react";

export default function App() {
    const user = authService.getCurrentUser();
    const navigate = useNavigate();

    useEffect(() => {
        if (!(user && user.token)) {
            navigate('/login', {replace: true});
        }
    }, []);

    return (
        <div className="container">
            <Header />
            <Navbar />
            <main>
                <Outlet />
            </main>
        </div>
    );
}
