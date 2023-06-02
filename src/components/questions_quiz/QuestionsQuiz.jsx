import { useEffect, useState } from "react";
import { NavLink, useLoaderData, useOutletContext, useParams } from "react-router-dom";
import { CgArrowLeft, CgArrowRight } from "react-icons/cg";
import { FaPlus } from "react-icons/fa";
import { FiChevronLeft } from "react-icons/fi";
// import "./style.css";
import QuestionModal from "../quiz_holder/QuizHolder";
import Modal from "../modal/Modal";



const QCMFields = ({ questionData }) => {
    const choices = [
        questionData.choix1,
        questionData.choix2,
        questionData.choix3,
        questionData.choix4,
    ];

    return (
        <>
            {
                choices.map((choice, i) => {
                    if (choice) {
                        return (
                            <div className="questions-wrapper" key={`${i}${choice}`}>
                                <div className="questions">
                                    <input type="checkbox" />
                                    <p>{choice}</p>
                                </div>
                            </div>
                        );
                    } else {
                        return (
                            <div className="questions-wrapper" key={`${i}${choice}`}>
                                <div className="questions">
                                    { choices[i-1] && 'Ajouter une question' }
                                </div>
                            </div>
                        )
                    }
                })
            }
        </>
    )
}

const QuestionFields = ({ questionData, type }) => {
    return (
        <>
            {
                type === 'QCM'
                    ? <QCMFields questionData={questionData} />
                    : <textarea></textarea>
            }
        </>
    )
}

// const addNewQCM = () => {

// }

// const addNewQRC = () => {

// }

const newQuestion = () => {

}

const QuestionsQuiz = () => {
    const params = useParams();
    const questions = useOutletContext();   

    const [questionNb, setQuestionNb] = useState(0);
    const [currentQuestion, setCurrentQuestion] = useState(questions[questionNb]);
    const [questionMode, setQuestionMode] = useState('read-only');
    useEffect(() => {
        setCurrentQuestion(questions[questionNb]);
    }, [questionNb]);

    const handleClick = async (value) => {
        setQuestionNb(n => n + value);
    }

    // const handleSubmit = () => {
    //     const formData = new FormData();

    //     // A faire, créer le formdata et l'envoyer en BDD
    // }

    const numberOfQuestions = questions.length

    if ((numberOfQuestions === 0 || !currentQuestion) && questionMode !== 'edit') {
        setQuestionMode("edit");
    }

    return (
        <Modal id='quiz-hold'>
            {questionNb > 0 && <button className="arrow arrow-left" onClick={() => handleClick(-1)}><CgArrowLeft /></button>}

            <NavLink to={`/quiz/${params.quizId}`} className={'back flat-button'}><FiChevronLeft /> Retour</NavLink>

            {/* <h1>{currentQuestion.enonce}</h1> */}

            {/* <form className="questions-container">
                <QuestionFields questionData={currentQuestion} type={currentQuestion.type.libelle} />
            </form> */}

            {
                questionMode === 'edit'
                ? <QuestionModal mode="edit" setMode={ setQuestionMode } setQuestionData={ setCurrentQuestion } />
                : <QuestionModal mode="read-only" questionData={ currentQuestion } />
            }

            {questionNb < numberOfQuestions - 1 ?
                <button 
                    className="arrow arrow-right" onClick={() => handleClick(+1)}><CgArrowRight /></button>
                : <button className="arrow arrow-right" onClick={() => { if (currentQuestion) { handleClick(+1) }}}><FaPlus /></button>
            }
        </Modal>  
    );
}

export default QuestionsQuiz;
