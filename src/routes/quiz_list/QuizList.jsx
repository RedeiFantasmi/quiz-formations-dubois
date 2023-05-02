import { Outlet, useLoaderData } from "react-router-dom";
import QuizCard from "../../components/quiz_card/QuizCard";
import './style.css';

const QuizList = () => {

    const quiz = useLoaderData();

    const now = Date.now();

    const quizElements = {};
    quiz.forEach(q => {
        const start = new Date(q.startDate);
        const end = new Date(q.endDate);

        let value;
        if (now < start) value = 'coming'
        else if (now > end) value = 'finished';
        else value = 'current';

        if (!quizElements[value]) {
            quizElements[value] = [];
        }
        quizElements[value].push(<QuizCard key={q.id} quizInfo={q} />);
    });

    return (
        <>
            <h1>Quiz page</h1>
            <div className="quiz-list-container">
                {quizElements.current && (
                    <div className="quiz-type-container">
                        <h2>Quiz en cours</h2>
                        <div className="content horizontal-scrollbar">
                            {quizElements.current}
                        </div>
                    </div>
                )}
                {quizElements.coming && (
                    <div className="quiz-type-container">
                        <h2>Quiz à venir</h2>
                        <div className="content horizontal-scrollbar">
                            {quizElements.coming}
                        </div>
                    </div>
                )}
                {quizElements.current && (
                    <div className="quiz-type-container">
                        <h2>Quiz terminés</h2>
                        <div className="content horizontal-scrollbar">
                            {quizElements.finished}
                        </div>
                    </div>
                )}
            </div>
            <Outlet />
        </>

    );
}

export default QuizList;
