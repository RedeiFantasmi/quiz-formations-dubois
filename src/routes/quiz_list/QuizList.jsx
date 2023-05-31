import { Outlet, useLoaderData, useNavigation } from "react-router-dom";
import QuizCard from "../../components/quiz_card/QuizCard";
import CoolInput from "../../components/cool_input/CoolInput";
import "./style.css";
import { useState } from "react";
import Modal from "../../components/modal/Modal";
import PostService from "../../services/post.service";

const QuizList = () => {

    const quiz = useLoaderData();

    const [quizCreation, setQuizCreation] = useState(false);

    const handleSubmit = async (e) => {
        e.preventDefault();

        const data = new FormData(e.target);
        const res = await PostService.quiz.createQuiz(e.target);
        console.log(res);
    }

    return (
        <div className="quiz-list-container">
            <h1>Quiz page</h1>
            {/* <div className="cool-input active">
                <select name="filter" defaultValue={"new"}>
                    <option value="new">Plus récents</option>
                    <option value="old">Plus ancients</option>
                    <option value="alph">Ordre alphabétique</option>
                </select>
                <label>Trier par</label>
            </div> */}
            <Outlet />
            <button className="contained-button" onClick={ () => { setQuizCreation(true); } }>Créer un quiz</button>
            { quizCreation && (
                <Modal size={'small'} handleClick={() => { setQuizCreation(false) }}>
                    <>
                        <h2>Saisissez un nom pour votre quiz</h2>
                        <form onSubmit={handleSubmit}>
                            <CoolInput name={"quiz-name"} />
                            <input type="submit" className="flat-button" />
                        </form>
                    </>
                </Modal>
            ) }
            <div className="quiz-list">
                { quiz.map(q => {
                    return <QuizCard key={q.id} quizInfo={q} />
                }) }
            </div>
        </div>

    );
}

export default QuizList;
