import { useState } from "react";
import CoolInput from "../cool_input/CoolInput";
import "./style.css";
import postService from "../../services/post.service";
import { useParams } from "react-router-dom";

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
    let choice = '';
    
    for (let i = 1; i <= 4; i++) {
        if (choice = fieldsData?.[`choix${i}`] && mode !== 'edit') {
            fields.push(<QCMButton key={ fieldsData.id + choice } text={ choice } nb={ i } />);
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
                type === 'QCM'
                ? <QCMFields fieldsData={ questionData } />
                : <textarea></textarea>
            }
        </div>
    );
}

const EditQuestion = ({ question, setQuestion, type }) => {
    if (type === 'QCM') {
        return (
            <div className="answers-container">
                <QCMFields fieldsData={ question } mode="edit" setQuestion={ setQuestion } />
            </div>
        );
    }
}

const QuestionModal = ({ questionData, mode }) => {
    const params = useParams();
    if (mode === 'edit') {
        const [type, setType] = useState();
        const [question, setQuestion] = useState(questionData ?? { id: null, enonce: '', type: 'QCR', choix1: '', choix2: '', choix3: '', choix4: '' });

        const handleSaveQuestion = async (e) => {
            const res = await postService.quiz.editQuizQuestion(params.quizId, question);
            console.log(res);
        }

        const handleTypeChange = (e) => {
            const newType = e.target.checked ? 'QCM' : 'QCR'
            setType(newType);
            setQuestion({ ...question, type: newType });
        }

        return (
            <div className="question-container">
                <div>
                    <input type="checkbox" name="type" onChange={ handleTypeChange } />
                    <button className="contained-button" onClick={ handleSaveQuestion }>Save</button>
                </div>
                
                <CoolInput name="enonce" defaultValue={ question.enonce } onChange={ (e) => { setQuestion({...question, enonce: e.target.value}) } } />
                <EditQuestion question={ question } setQuestion={ setQuestion } type={ type } />
            </div>
        )
    }

    return (
        <div className={ `question-container ${mode}` }>
            <h1>{ questionData.enonce + ` (/${questionData.noteMax})` }</h1>
            <ReadQuestion questionData={ questionData } type={ questionData.type.libelle }  />
        </div>
    )
}

export default QuestionModal;
