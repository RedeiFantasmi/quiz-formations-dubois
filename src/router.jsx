import { createBrowserRouter } from "react-router-dom";
import App from "./App";
import QuizList from "./routes/quiz_list/QuizList";
import Evaluations from "./routes/evaluations/Evaluations";
import Home from "./routes/home/Home";
import QuizAnswer from "./components/quiz_answer/QuizAnswer";
import Error from "./routes/error/Error";
import Quiz from "./components/quiz/Quiz";
import fetchQuizQuestions from "./loaders/fetch_quiz_questions";
import fetchQuizList from "./loaders/fetch_quiz_list";
import fetchQuiz from "./loaders/fetch_quiz";

const router = createBrowserRouter([
    {
        path: '/',
        element: <App />,
        errorElement: <Error />,
        children: [
            {
                path: '/',
                element: <Home />,
            },
            {
                path: '/quiz',
                element: <QuizList />,
                loader: fetchQuizList,
                children: [
                    {
                        path: '/quiz/:quizId',
                        element: <Quiz />,
                        loader: fetchQuiz,
                    },
                    {
                        path: '/quiz/:quizId/answer',
                        element: <QuizAnswer />,
                        loader: fetchQuizQuestions,
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
