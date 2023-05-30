import { Outlet, useLoaderData, useNavigation } from "react-router-dom";
import QuizCard from "../../components/quiz_card/QuizCard";
import './style.css';

const QuizList = () => {

    const quiz = useLoaderData();

    return (
        <div className="quiz-list-container">
            <h1>Quiz page</h1>
            <div className="cool-input active">
                <select name="filter" defaultValue={"new"}>
                    <option value="new">Plus récents</option>
                    <option value="old">Plus ancients</option>
                    <option value="alph">Ordre alphabétique</option>
                </select>
                <label>Trier par</label>
            </div>
            <Outlet />
            <div className="quiz-list">
                { quiz.map(q => {
                    return <QuizCard key={q.id} quizInfo={q} />
                }) }
            </div>
        </div>

    );
}

export default QuizList;
