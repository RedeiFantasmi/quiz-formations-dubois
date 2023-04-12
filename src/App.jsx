import { Outlet, useParams } from "react-router-dom";
import Header from "./components/header/Header";
import Navbar from "./components/navbar/Navbar";
import "./App.css";
import { useState } from "react";
import Login from "./routes/login/Login";
import useToken from "./hooks/useToken";



export default function App() {
    const [token, setToken] = useToken();

    if (!token) {
        return <Login setToken={ setToken } />
    }

    return (
        <div className="container">
            <Header setToken={ setToken } />
            <Navbar />
            <main>
                <Outlet />
            </main>
        </div>
    );
}
