import { useRef, useState } from "react";
import { useParams, useRevalidator } from "react-router-dom";
import postService from "../../services/post.service";
import CoolInput from "../cool_input/CoolInput";
import "./style.css";

const ReadButton = ({ questionData, nb }) => {
    return (
        <div className="answer-wrapper">
            <div className="answer-container">
                <input type="checkbox" checked={ questionData?.[`repChoix${nb}`] } readOnly />
                <p>{ questionData?.[`choix${nb}`] }</p>
            </div>
        </div>
    )
}

const AnswerButton = ({ questionData, nb, setQuestionData }) => {
    const handleChange = (e) => {
        setQuestionData({
            ...questionData,
            [`repChoix${nb}`]: e.target.checked ? 1 : 0
        });
    }

    return (
        <div className="answer-wrapper">
            <div className="answer-container">
                <input type="checkbox" name={ questionData.id + 'choix' + nb } checked={ questionData[`repChoix${nb}`] ?? 0 } onChange={ handleChange } />
                <p>{ questionData[`choix${nb}`] }</p>
            </div>
        </div>
    )
}

const EditButton = ({ text, nb, question, setQuestionData }) => {
    const choix = `choix${nb}`
    const handleFieldEdit = (e) => {
        setQuestionData({ ...question, [choix]: e.target.value });
    }

    return (
        <div className="answer-wrapper">
            <div className="answer-container">
                <input type="text" value={ question?.[choix] } onChange={ handleFieldEdit } name={ choix } />
            </div>
        </div>
    )
}

const QCMFields = ({ fieldsData, mode, setQuestionData }) => {
    let fields = [];

    for (let i = 1; i <= 4; i++) {
        const choice = `choix${i}`;
        if (fieldsData?.[choice]) {
            if (mode === 'answer') {
                fields.push(<AnswerButton key={ fieldsData.id + choice } nb={ i } questionData={ fieldsData } setQuestionData={ setQuestionData } />)
            } else if (mode === 'read') {
                fields.push(<ReadButton key={ fieldsData.id + choice } questionData={ fieldsData } nb={ i } />);
            }
        }

        if (mode === 'edit') {
            fields.push(<EditButton key={ i } nb={ i } question={ fieldsData } setQuestionData={ setQuestionData } />);
        }
    }
    
    return (
        <>
            { fields }
        </>
    );    
}



// Types de containeur à question

// Question en lecture seule
const ReadQuestion = ({ questionData, qcm }) => {
    return (
        <div className="answers-container">
            {
                qcm
                ? <QCMFields fieldsData={ questionData } mode="read" />
                : <textarea key={ questionData.id } value={ questionData?.reponse ?? '' } readOnly></textarea>
            }
        </div>
    );
}

// Modification de question
const EditQuestion = ({ question, setQuestion, qcm }) => {
    if (qcm) {
        return (
            <div className="answers-container">
                <QCMFields fieldsData={ question } mode="edit" setQuestionData={ setQuestion } />
            </div>
        );
    }
}

// Réponse à une question
const AnswerQuestion = ({ questionData, setQuestionData }) => {
    return (
        <div className="answers-container">
            {
                questionData.qcm
                ? <QCMFields fieldsData={ questionData } mode="answer" setQuestionData={ setQuestionData } />
                : (
                    <textarea 
                        key={ questionData.id }
                        value={ questionData.reponse ?? '' }
                        onChange={(e) => {
                            setQuestionData({
                                ...questionData,
                                reponse: e.target.value
                            });
                        }}
                    ></textarea>
                )
            }
        </div>
    );
}

const QuestionModal = ({ questionData, setQuestionData, mode, setIsLoading }) => {
    const params = useParams();
    const revalidator = useRevalidator();
    const [isQCM, setIsQCM] = useState(0);
    const [question, setQuestion] = useState({id: null, enonce: '', qcm: 0, choix1: '', choix2: '', choix3: '', choix4: '', noteMax: 0});
    
    if (mode === 'edit') {
        const clearQuestion = () => {
            setQuestion({id: null, enonce: '', qcm: 0, choix1: '', choix2: '', choix3: '', choix4: '', noteMax: 0});
            setIsQCM(0);
        }

        const handleSaveQuestion = async (e) => {
            const data = new FormData();
            data.set('id', question.id);
            data.set('idQuiz', params.quizId);
            data.set('noteMax', question.noteMax);
            data.set('qcm', question.qcm ? 1 : 0);
            data.set('enonce', question.enonce);
            data.set('choix1', question.choix1);
            data.set('choix2', question.choix2);
            data.set('choix3', question.choix3);
            data.set('choix4', question.choix4);

            try {
                setIsLoading(true);
                const res = await postService.quiz.editQuizQuestion(params.quizId, data);
                setIsLoading(false);
                
                if (res.status === 200) {
                    clearQuestion();
                    revalidator.revalidate();
                }
            } catch (err) {
                setIsLoading(false);
            }
        }

        const handleTypeChange = (e) => {
            const newType = e.target.checked;
            setIsQCM(newType);
            setQuestion({ ...question, qcm: newType });
        }

        return (
            <div className="question-container edit">
                <label className="qcm-switch">
                    QCM
                    <input type="checkbox" name="qcm" checked={ question.qcm } onChange={ handleTypeChange } />
                </label>
                <div className="fields">
                    <CoolInput name="enonce" label="Enonce" labelColor="#FFFFFF" defaultValue={ question.enonce } onChange={ (e) => { setQuestion({...question, enonce: e.target.value}) } } />
                    <CoolInput type="number" min="0" name="note" label="nb de points" labelColor="#FFFFFF" defaultValue={ question.noteMax } onChange={ (e) => { setQuestion({...question, noteMax: e.target.value}) } } />
                    <EditQuestion question={ question } setQuestion={ setQuestion } qcm={ isQCM } />
                </div>
                <button className="contained-button add" onClick={ handleSaveQuestion }>Ajouter</button>
            </div>
        )
    }
    return (
        <div className={ `question-container ${mode}` }>
            <h1>{ questionData.enonce + ` (${questionData.corrige ? questionData.note : ''}/${questionData.noteMax})` }</h1>
            {
                questionData.corrige && (
                    <p>Commentaire : { questionData.annotation }</p>
                )
            }
            {
                mode === 'answer'
                ? <AnswerQuestion questionData={ questionData } setQuestionData={ setQuestionData } />
                : <ReadQuestion questionData={ questionData } qcm={ questionData.qcm } />
            }
            
        </div>
    )
}

export default QuestionModal;
