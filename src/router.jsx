import { createBrowserRouter } from "react-router-dom";
import Login from "./routes/login/Login";
import App from "./App";
import Quiz from "./routes/quiz/Quiz";
import Evaluations from "./routes/evaluations/Evaluations";

const router = createBrowserRouter([
    {
        path: '/',
        element: <App />,
        errorElement: <Error />,
        children: [
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
