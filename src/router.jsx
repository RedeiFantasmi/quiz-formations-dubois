import { createBrowserRouter } from "react-router-dom";
import Login from "./routes/login/Login";
import App from "./App";
import Quiz from "./routes/quiz/Quiz";
import Evaluations from "./routes/evaluations/Evaluations";
import Home from "./routes/home/Home";

const router = createBrowserRouter([
    {
        path: '/',
        element: <App />,
        errorElement: <Error />,
        children: [
            {
                path: '/',
                element: <Home />
            },
            {
                path: '/quiz',
                element: <Quiz />,
            },
            {
                path: '/evaluations',
                element: <Evaluations />,
            },
        ]
    },
    {
        path: '/login',
        element: <Login />,
    },
]);

export default router;
