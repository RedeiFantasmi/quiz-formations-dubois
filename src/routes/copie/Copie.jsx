import { useEffect, useState } from "react";
import { BiChevronLeft, BiChevronRight, BiSend } from "react-icons/bi";
import { CgArrowLeft, CgArrowRight } from "react-icons/cg";
import { useLoaderData, useNavigate, useParams } from "react-router-dom";
import CoolInput from "../../components/cool_input/CoolInput";
import Loader from "../../components/loader/Loader";
import Modal from "../../components/modal/Modal";
import QuestionModal from "../../components/quiz_holder/QuizHolder";
import authService from "../../services/auth.service";
import postService from "../../services/post.service";
import "./style.css";


const Copie = () => {
    const params = useParams();
    const copieData = useLoaderData();
    const navigate = useNavigate();
    const formateur = authService.hasRole('ROLE_FORMATEUR');
    const readOnly = (copieData[0].estCloture || new Date() > new Date(copieData[0].dateFin));
    const correction = (new Date() > new Date(copieData[0].dateFin) && formateur && !copieData[0].corrige);

    const [questionNb, setQuestionNb] = useState(0);
    const [currentQuestion, setCurrentQuestion] = useState(copieData[questionNb]);
    const [isCorrectionShown, setIsCorrectionShown] = useState(true);
    const [isLoading, setIsLoading] = useState(false);
    const [globalAnnotation, setGlobalAnnotation] = useState(false);
    // const [answered, setAnswered] = useState(false);

    useEffect(() => {
        setCurrentQuestion(copieData[questionNb]);
    }, [questionNb]);

    // useEffect(() => {
    //     setAnswered(true);
    // }, [currentQuestion]);

    const numberOfQuestions = copieData.length;

    const handleClick = async (value) => {
        let mode = correction
            ? 'correction'
            : (
                readOnly
                    ? 'readOnly'
                    : 'answer'
            );

        if (mode === 'readOnly') {
            setQuestionNb(n => n + value);

            return;
        } else {
            try {
                setIsLoading(true);
                const res = await submitData(mode);
                setIsLoading(false);

                if (res.status === 200) {
                    copieData[questionNb] = currentQuestion;
                    setQuestionNb(n => n + value);
                    // setAnswered(false);
                }
            } catch (err) {
                setIsLoading(false);
            }
        }
    }

    const submitData = (mode) => {
        const data = new FormData();
        
        data.set('idQuestion', currentQuestion.id);
        
        if (mode === 'answer') {
            data.set('reponse', currentQuestion.reponse);
            data.set('choix1', currentQuestion.repChoix1 ? 1 : 0);
            data.set('choix2', currentQuestion.repChoix2 ? 1 : 0);
            data.set('choix3', currentQuestion.repChoix3 ? 1 : 0);
            data.set('choix4', currentQuestion.repChoix4 ? 1 : 0);
        } else if (mode === 'correction') {
            data.set('note', currentQuestion.note ?? currentQuestion.noteMax);
            data.set('annotation', currentQuestion.annotation ?? '');
        }

        return postService.copie.sendCopieData(params.copieId, data);
    }

    const handleSubmit = async () => {
        console.log('arg');
        try {
            setIsLoading(true)
            const res = await submitData(correction ? 'correction' : 'answer');

            if (res.status === 200) {
                let lock;
                if (correction) {
                    const data = new FormData();
                    data.set('annotation', currentQuestion.annotationCopie);

                    lock = await postService.copie.correctCopie(params.copieId, data);
                } else {
                    lock = await postService.copie.lockCopie(params.copieId);
                }

                setIsLoading(false);

                if (lock.status === 200) {
                    setGlobalAnnotation(false);
                    navigate(`/evaluations/${lock.data}`);
                }
            }
        } catch (err) {
            setIsLoading(false);
        }
    }

    return (
        <Modal id="quiz-hold" className="test">
            {questionNb > 0 && <button className="arrow arrow-left" onClick={() => handleClick(-1)}><CgArrowLeft /></button>}

            {
                readOnly
                ? <QuestionModal mode="read-only" questionData={ currentQuestion } />
                : <QuestionModal mode="answer" questionData={ currentQuestion } setQuestionData={ setCurrentQuestion } />
            }

            {
                questionNb < numberOfQuestions - 1
                ? <button className="arrow arrow-right" onClick={() => { handleClick(+1) }}><CgArrowRight /></button>
                : (
                    readOnly && !correction
                    ? ''
                    : <button className="arrow arrow-right" onClick={ () => { if (!correction) { handleSubmit() } else { setGlobalAnnotation(true) } } }><BiSend /></button>
                )
            }

            {
                correction && (
                    <div className={ isCorrectionShown ? "correct-copie-container show" : "correct-copie-container" }>
                        <div className="correction-handle">
                            <input type="checkbox" checked={ isCorrectionShown } onChange={ (e) => { setIsCorrectionShown(e.target.checked); }} />
                            {
                                isCorrectionShown
                                ? <BiChevronRight />
                                : <BiChevronLeft />
                            }
                        </div>
                        <CoolInput label="Note" labelColor="#FFFFFF" type="number" defaultValue={ currentQuestion.note ?? currentQuestion.noteMax } onChange={ (e) => { setCurrentQuestion({ ...currentQuestion, note: e.target.value }) } } min="0" max={ currentQuestion.noteMax } />
                        <CoolInput label="Commentaire" labelColor="#FFFFFF" defaultValue={ currentQuestion.annotation ?? '' } onChange={ (e) => { setCurrentQuestion({ ...currentQuestion, annotation: e.target.value }) }} />
                    </div>
                )
            }

            {
                globalAnnotation && (
                    <Modal id="annotation-modal" size="small" handleClick={() => { setGlobalAnnotation(false); }}>
                        <h2>Saisissez un commentaire global</h2>
                        <CoolInput onChange={(e) => { setCurrentQuestion({...currentQuestion, annotationCopie: e.target.value}) }} />
                        <input type="submit" className="flat-button" onClick={ handleSubmit } />
                    </Modal>
                )
            }

            {
                isLoading && <Loader />
            }
        </Modal>
    )
}

export default Copie;
