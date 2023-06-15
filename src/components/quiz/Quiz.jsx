import { useState } from "react";
import { BsCheck } from "react-icons/bs";
import { CgClose } from "react-icons/cg";
import { FaPencilAlt } from "react-icons/fa";
import { NavLink, Outlet, useLoaderData, useNavigate, useOutletContext, useParams, useRevalidator } from "react-router-dom";
import postService from "../../services/post.service";
import CoolInput from "../cool_input/CoolInput";
import Loader from "../loader/Loader";
import "./style.css";

const Quiz = () => {
    const params = useParams();
    const quizData = useOutletContext();

    const [isLoading, setIsLoading] = useState(false);
    const [editName, setEditName] = useState(false);
    const [quizName, setQuizName] = useState(quizData.titre);

    const navigate = useNavigate();
    const revalidator = useRevalidator();

    const handleDeleteClick = async () => {
        const id = params.quizId;

        setIsLoading(true);
        const res = await postService.quiz.deleteQuiz(id);
        setIsLoading(false);

        if (res.status === 200) {
            navigate('/quiz');
            revalidator.revalidate();
        }
    }

    const handleEditNameClick = async () => {
        setEditName(n => !n);

        if (editName && quizName.trim() !== quizData.titre.trim()) {
            const data = new FormData();
            data.set('quiz-name', quizName);

            setIsLoading(true);
            const res = await postService.quiz.editQuiz(params.quizId, data);
            setIsLoading(false);

            if (res.status === 200) {
                revalidator.revalidate();
            }

        } else {
            setQuizName(quizData.titre);
        }
    }

    const handleNameChange = (e) => {
        setQuizName(e.target.value);
    }

    return (
        
        <div className="quiz-wrapper">
            <div className="quiz-container">
                <NavLink to={'/quiz'} className={'closer flat-button'}><CgClose /></NavLink>

                <div className="quiz-name">
                    { 
                        editName ? (
                            <CoolInput name="quiz-name" label="Nom du Quiz" align="flex-start" labelColor="#FFFFFF" defaultValue={ quizName } onChange={ handleNameChange } />
                        )
                        
                        : (
                            <h1>{ quizData.titre }</h1>
                        )
                    }
                    <button onClick={ handleEditNameClick }>{ editName ? <BsCheck /> : <FaPencilAlt /> }</button>
                </div>

                <p>Créé le : { quizData.dateCreation.substring(0, 10) }</p>

                <div className="quiz-questions">
                    <h2>Questions</h2>
                    <div className="quiz-questions-container">
                        { quizData.questions.map(question => {
                            return (
                                <span className="question" key={ question.id }>{ `${question.enonce} - ${question.qcm ? 'QCM' : 'Réponse libre'} (/${question.noteMax})` }</span>
                            )
                        }) }
                    </div>
                </div>
        
                <div className="action-buttons">
                    <button onClick={ handleDeleteClick } className="flat-button">Supprimer</button>
                    <NavLink to={`/quiz/${params.quizId}/questions`} className={'contained-button'}>Modifier</NavLink>
                </div>
                
            </div>
            <Outlet context={quizData.questions} />
            { isLoading && <Loader /> }
        </div>
    )
}

export default Quiz;
