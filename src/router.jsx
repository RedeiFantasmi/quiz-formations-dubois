import { createBrowserRouter } from "react-router-dom";
import App from "./App";
import QuizList from "./routes/quiz_list/QuizList";
import Home from "./routes/home/Home";
import EvaluationAnswer from "./components/evaluation_answer/EvaluationAnswer";
import Error from "./routes/error/Error";
import Quiz from "./components/quiz/Quiz";
import fetchQuizQuestions from "./loaders/quiz/fetch_quiz_questions";
import fetchQuizList from "./loaders/quiz/fetch_quiz_list";
import fetchQuiz from "./loaders/quiz/fetch_quiz";
import Evaluation from "./components/evaluation/Evaluation";
import fetchEvaluation from "./loaders/evaluations/fetch_evaluation";
import fetchEvaluationQuestions from "./loaders/evaluations/fetch_evaluation_questions";
import fetchEvaluationsList from "./loaders/evaluations/fetch_evaluations_list";
import EvaluationsList from "./routes/evaluations_list/EvaluationsList";
import Login from "./routes/login/Login";

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
                    // {
                    //     path: '/quiz/:quizId/edit',
                    //     element: <EvaluationAnswer />,
                    //     loader: fetchQuizQuestions,
                    // }
                ]
            },
            {
                path: '/evaluations',
                element: <EvaluationsList />,
                loader: fetchEvaluationsList,
                children: [
                    {
                        path: '/evaluations/:evaluationId',
                        element: <Evaluation />,
                        loader: fetchEvaluation,
                    },
                    {
                        path: '/evaluations/:evaluationId/answer',
                        element: <EvaluationAnswer />,
                        loader: fetchEvaluationQuestions,
                    }
                ]
            },
        ]
    },
    {
        path: '/login',
        element: <Login />,
    },
]);

export default router;
