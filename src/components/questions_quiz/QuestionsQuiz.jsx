import { useEffect, useState } from "react";
import { BsFillTrash3Fill } from "react-icons/bs";
import { CgArrowLeft, CgArrowRight } from "react-icons/cg";
import { FaPlus } from "react-icons/fa";
import { FiChevronLeft } from "react-icons/fi";
import { NavLink, useOutletContext, useParams, useRevalidator } from "react-router-dom";
import postService from "../../services/post.service";
import Loader from "../loader/Loader";
import Modal from "../modal/Modal";
import QuestionModal from "../quiz_holder/QuizHolder";
import "./style.css";

const QuestionsQuiz = () => {
    const params = useParams();
    const questions = useOutletContext();
    const revalidator = useRevalidator();
    const [questionNb, setQuestionNb] = useState(0);
    const [isLoading, setIsLoading] = useState(false);
    const [currentQuestion, setCurrentQuestion] = useState(questions[questionNb]);
    const [questionMode, setQuestionMode] = useState('read-only');
    useEffect(() => {
        setCurrentQuestion(questions[questionNb]);
    }, [questionNb, questions]);

    const handleClick = async (value) => {
        setQuestionNb(n => n + value);
    }

    const handleDelete = async () => {
        setIsLoading(true);
        const res = await postService.quiz.deleteQuizQuestion(currentQuestion.id);
        setIsLoading(false);

        if (res.status === 200) {
            if (questionNb > 0) {
                handleClick(-1);
            }
            revalidator.revalidate();
        }
    }

    const numberOfQuestions = questions.length

    if ((numberOfQuestions === 0 || !currentQuestion) && questionMode !== 'edit') {
        setQuestionMode("edit");
    } else if (currentQuestion && questionMode === 'edit') {
        setQuestionMode('read');
    }

    return (
        <Modal id='quiz-hold'>
            {questionNb > 0 && <button className="arrow arrow-left" onClick={() => handleClick(-1)}><CgArrowLeft /></button>}

            <div className="top-buttons">
                <NavLink to={`/quiz/${params.quizId}`} className={'back flat-button'}><FiChevronLeft /> Retour</NavLink>
                {
                    currentQuestion && <BsFillTrash3Fill className="delete-button" onClick={ handleDelete } />
                }
            </div>

            {
                questionMode === 'edit'
                ? <QuestionModal mode="edit" setMode={ setQuestionMode } setIsLoading={ setIsLoading } />
                : <QuestionModal mode="read-only" questionData={ currentQuestion } setIsLoading={ setIsLoading } />
            }

            {
                currentQuestion && (
                    <button className="arrow arrow-right" onClick={() => { handleClick(+1) }}>
                        {
                            questionNb < numberOfQuestions - 1
                                ? <CgArrowRight />
                                : <FaPlus />
                        }
                    </button>
                )
            }
            {
                isLoading && <Loader />
            }
        </Modal>
    );
}

export default QuestionsQuiz;
