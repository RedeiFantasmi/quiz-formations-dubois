import { Outlet } from "react-router-dom";
import Header from "./components/header/Header";
import Navbar from "./components/navbar/Navbar";
import "./App.css";


export default function App() {
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