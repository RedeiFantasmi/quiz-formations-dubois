import { Outlet, useLoaderData, useNavigate, useNavigation, useParams, useRevalidator } from "react-router-dom";
import QuizCard from "../../components/quiz_card/QuizCard";
import CoolInput from "../../components/cool_input/CoolInput";
import "./style.css";
import { useState } from "react";
import Modal from "../../components/modal/Modal";
import PostService from "../../services/post.service";
import Loader from "../../components/loader/Loader";

const QuizList = () => {
    const params = useParams();
    const quiz = useLoaderData();

    const revalidator = useRevalidator();
    const navigate = useNavigate();

    const [isLoading, setIsLoading] = useState(false);
    const [quizCreation, setQuizCreation] = useState(false);

    const handleSubmit = async (e) => {
        e.preventDefault();
        setIsLoading(true);
        const res = await PostService.quiz.createQuiz(e.target);
        
        setIsLoading(false);
        if (res.status === 200) {
            setQuizCreation(false);
            revalidator.revalidate();
            navigate('/quiz/' + res.data);
        }
    }

    return (
        <>
            <Outlet context={ quiz.find(q => q.id == params.quizId) } />
            { quizCreation && (
                <Modal id={ 'quiz-creation' } size={ 'small' } handleClick={() => { setQuizCreation(false) }}>
                    <>
                        <h2>Saisissez un nom pour votre quiz</h2>
                        <form onSubmit={handleSubmit}>
                            <CoolInput name={"quiz-name"} />
                            <input type="submit" className="flat-button" />
                        </form>
                    </>
                </Modal>
            ) }
            <div className="quiz-list-container">
                <h1>Vos Quiz</h1>
                <button className="contained-button" onClick={ () => { setQuizCreation(true); } }>Créer un quiz</button>
                <div className="quiz-list">
                    { quiz.map(q => {
                        return <QuizCard key={q.id} quizInfo={q} />
                    }) }
                </div>
            </div>
            { isLoading && <Loader /> }
        </>

    );
}

export default QuizList;
