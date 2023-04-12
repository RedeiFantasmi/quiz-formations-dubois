import { createBrowserRouter } from "react-router-dom";
import App from "./App";
import Quiz from "./routes/quiz/Quiz";
import Evaluations from "./routes/evaluations/Evaluations";
import Home from "./routes/home/Home";
import QuizContainer from "./components/quiz_container/QuizContainer";
import Error from "./routes/error/Error";

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
                children: [
                    {
                        path: '/quiz/:quizId/answer',
                        element: <QuizContainer />,
                    }
                ]
            },
            {
                path: '/evaluations',
                element: <Evaluations />,
            },
        ]
    },
    // {
    //     path: '/login',
    //     element: <Login />,
    // },
]);

export default router;
