import { createBrowserRouter } from "react-router-dom";
import App from "./App";
import Evaluation from "./components/evaluation/Evaluation";
import QuestionsQuiz from "./components/questions_quiz/QuestionsQuiz";
import Quiz from "./components/quiz/Quiz";
import fetchEvaluationsList from "./loaders/fetch_evaluations_list";
import fetchHomeData from "./loaders/fetchHomeData";
import fetchCopie from "./loaders/fetch_copie";
import createNewCopie from "./loaders/create_new_copie";
import fetchQuizList from "./loaders/fetch_quiz_list";
import Copie from "./routes/copie/Copie";
import Error from "./routes/error/Error";
import EvaluationsList from "./routes/evaluations_list/EvaluationsList";
import Home from "./routes/home/Home";
import Login from "./routes/login/Login";
import QuizList from "./routes/quiz_list/QuizList";

const router = createBrowserRouter([
    {
        path: '/',
        element: <App />,
        errorElement: <Error />,
        children: [
            {
                path: '/',
                element: <Home />,
                loader: fetchHomeData
            },
            {
                path: '/quiz',
                element: <QuizList />,
                loader: fetchQuizList,
                children: [
                    {
                        path: '/quiz/:quizId',
                        element: <Quiz />,
                        children: [
                            {
                                path: '/quiz/:quizId/questions',
                                element: <QuestionsQuiz />,
                            }
                        ]
                    },
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
                    },
                    {
                        path: '/evaluations/:evaluationId/copie/create',
                        element: <></>,
                        loader: createNewCopie,
                    }
                ]
            },
            {
                path: '/copie/:copieId',
                element: <Copie />,
                loader: fetchCopie,
            },
        ]
    },
    {
        path: '/login',
        element: <Login />,
    },
]);

export default router;
