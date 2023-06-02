import { useRef, useState } from "react";
import CoolInput from "../cool_input/CoolInput";
import "./style.css";
import postService from "../../services/post.service";
import { useParams, useRevalidator } from "react-router-dom";

const QCMButton = ({ text, nb }) => {
    return (
        <div className="answer-wrapper">
            <div className="answer-container">
                <input type="checkbox" name={`choix${nb}`} />
                <p>{ text }</p>
            </div>
        </div>
    )
}

const EditButton = ({ text, nb, question, setQuestion }) => {
    const choix = `choix${nb}`
    const handleFieldEdit = (e) => {
        setQuestion({ ...question, [choix]: e.target.value });
    }

    return (
        <div className="answer-wrapper">
            <div className="answer-container">
                <input type="text" value={ question?.[choix] } onChange={ handleFieldEdit } name={ choix } />
            </div>
        </div>
    )
}

const QCMFields = ({ fieldsData, mode, setQuestion }) => {
    let fields = [];
    
    for (let i = 1; i <= 4; i++) {
        const choice = `choix${i}`;
        if (fieldsData?.[choice] && mode !== 'edit') {
            fields.push(<QCMButton key={ fieldsData.id + choice } text={ fieldsData[choice] } nb={ i } />);
        }

        if (mode === 'edit') {
            fields.push(<EditButton key={ i } nb={ i } question={ fieldsData } setQuestion={ setQuestion } />);
        }
    }
    
    return (
        <>
            { fields }
        </>
    );    
}

const ReadQuestion = ({ questionData, type }) => {
    return (
        <div className="answers-container">
            {
                type
                ? <QCMFields fieldsData={ questionData } />
                : <textarea></textarea>
            }
        </div>
    );
}

const EditQuestion = ({ question, setQuestion, type }) => {
    if (type) {
        return (
            <div className="answers-container">
                <QCMFields fieldsData={ question } mode="edit" setQuestion={ setQuestion } />
            </div>
        );
    }
}

const QuestionModal = ({ questionData, setQuestionData, mode, setMode }) => {
    const params = useParams();
    const revalidator = useRevalidator();
    const [type, setType] = useState(0);
    const [question, setQuestion] = useState({id: null, enonce: '', type: 0, choix1: '', choix2: '', choix3: '', choix4: '', noteMax: 0});
    if (mode === 'edit') {
        const handleSaveQuestion = async (e) => {
            const data = new FormData();
            data.set('id', question.id);
            data.set('idQuiz', params.quizId);
            data.set('noteMax', question.noteMax);
            data.set('type', question.type);
            data.set('enonce', question.enonce);
            data.set('choix1', question.choix1);
            data.set('choix2', question.choix2);
            data.set('choix3', question.choix3);
            data.set('choix4', question.choix4);

            const res = await postService.quiz.editQuizQuestion(params.quizId, data);
            
            if (res.status === 200) {
                setQuestionData({...question, id: res.data});
                setMode("read-only");
                revalidator.revalidate();
            }
        }

        const handleTypeChange = (e) => {
            const newType = e.target.checked;
            setType(newType);
            setQuestion({ ...question, type: newType });
        }

        return (
            <div className="question-container edit">
                <div>
                    <input type="checkbox" name="type" onChange={ handleTypeChange } />
                    <button className="contained-button" onClick={ handleSaveQuestion }>Save</button>
                </div>
                
                <CoolInput name="enonce" label="Enonce" labelColor="#FFFFFF" defaultValue={ question.enonce } onChange={ (e) => { setQuestion({...question, enonce: e.target.value}) } } />
                <CoolInput type="number" min="0" name="note" label="nb de points" labelColor="#FFFFFF" defaultValue={ question.noteMax } onChange={ (e) => { setQuestion({...question, noteMax: e.target.value}) } } />
                <EditQuestion question={ question } setQuestion={ setQuestion } type={ type } />
            </div>
        )
    }

    return (
        <div className={ `question-container ${mode}` }>
            <h1>{ questionData.enonce + ` (/${questionData.noteMax})` }</h1>
            <ReadQuestion questionData={ questionData } type={ questionData.qcm }  />
        </div>
    )
}

export default QuestionModal;
