import React from "react";
import ReactDOM from "react-dom/client";
import {
    createBrowserRouter,
    RouterProvider,
} from "react-router-dom";
import "./index.css";
import Login from "./components/login/Login";
import CreateAccount from "./components/create_account/CreateAccount";
import Home from "./components/home/Home";

const router = createBrowserRouter([
    {
        path: "/",
        element: <Home />,
    },
    {
        path: "/login",
        element: <Login />,
    },
    {
        path: "/create-account",
        element: <CreateAccount />,
    },
]);

ReactDOM.createRoot(document.getElementById("root")).render(
    <React.StrictMode>
        <RouterProvider router={router} />
    </React.StrictMode>
);

// async function handleFetch() {
//     const data = await fetch('http://localhost:8000/user/get', {mode: 'cors'});
//     console.log(await data.json());
// }
// handleFetch();