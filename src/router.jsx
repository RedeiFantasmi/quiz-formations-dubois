import { createBrowserRouter } from "react-router-dom";
import App from "./App";
import QuizList from "./routes/quiz_list/QuizList";
import Evaluations from "./routes/evaluations/Evaluations";
import Home from "./routes/home/Home";
import QuizAnswer from "./components/quiz_answer/QuizAnswer";
import Error from "./routes/error/Error";
import Quiz from "./components/quiz/Quiz";

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
                element: <QuizList />,
                children: [
                    {
                        path: '/quiz/:quizId',
                        element: <Quiz />
                    },
                    {
                        path: '/quiz/:quizId/answer',
                        element: <QuizAnswer />,
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
