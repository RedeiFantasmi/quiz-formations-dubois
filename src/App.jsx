import { useEffect } from "react";
import { Outlet, ScrollRestoration, useNavigate, useNavigation, useRevalidator } from "react-router-dom";
import "./App.css";
import Header from "./components/header/Header";
import Loader from "./components/loader/Loader";
import Navbar from "./components/navbar/Navbar";
import authService from "./services/auth.service";

export default function App() {
    const user = authService.getCurrentUser();
    const navigate = useNavigate();
    const revalidator = useRevalidator();

    useEffect(() => {
        if (!(user && user.token)) {
            navigate('/login', {replace: true});
        }
    }, []);

    const { state } = useNavigation();

    return (
        <>
            <Header />
            <Navbar />
            <div className="container">
                <main>
                    { (state === 'loading' || revalidator.state === 'loading') && <Loader /> }
                    <Outlet />
                </main>
            </div>
        </>
    );
}
