import { NavLink, Outlet, useParams } from "react-router-dom";
import QuizCard from "../../components/quiz_card/QuizCard";
import './style.css';

const QuizList = () => {

    const quiz = [
        {
            id: 1,
            title: 'test quiz',
            startDate: '2023-04-28 14:25',
            time: '2d',
            createdBy: 'Fab Ien'
        },
        {
            id: 2,
            title: 'test quiz',
            startDate: '2026-04-26 14:25',
            time: '15min',
            createdBy: 'Auguste Un'
        },
        {
            id: 3,
            title: 'test quiz',
            startDate: '2023-04-25 14:25',
            time: '4h',
            createdBy: 'Matt yeu'
        }
    ]

    return (
        <>
            <h1>Quiz page</h1>
            <div className="quiz-list-container">
                { quiz.map(quizInfo => {
                    return (
                        <QuizCard key={quizInfo.id} quizInfo={quizInfo} />
                    );
                }) }
            </div>
            <Outlet />
        </>
        
    );
}

export default QuizList;
