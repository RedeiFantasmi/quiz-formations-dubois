import { useState } from "react";
import { useParams } from "react-router-dom";
import { CgArrowLeft, CgArrowRight } from "react-icons/cg"
import { BsArrowReturnLeft } from "react-icons/bs";
import "./style.css";

function generateQCM(questionData) {
    const choices = [
        questionData.choix1,
        questionData.choix2,
        questionData.choix3,
        questionData.choix4,
    ];

    return (
        <>
            { choices.map((choice, i) => {
                if (choice) {
                    return (
                        <div className="answer-wrapper">
                            <div key={`${i}${choice}`} className="answer">
                                <input type="checkbox" name="" id="" />
                                <p>{ choice }</p>
                            </div>
                        </div>
                        
                    )
                }
            }) }
        </>
    )
}

export default function QuizContainer() {
    const params = useParams();

    const [question, setQuestion] = useState(0);
    
    const questions = [
        {
            title: 'Quel est le meilleur jeu au monde ?',
            qcm: true,
            choix1: 'Destiny 2',
            choix2: 'Monster Hunter World',
            choix3: 'Dark Souls 3',
            choix4: 'Tennis',
        }, {
            title: 'As-tu menti à la première question ?',
            qcm: true,
            choix1: 'Oui',
            choix2: 'Oui',
        }
    ];

    const currentQuestion = questions[question];
    const numberOfQuestions = questions.length

    return (
        <div className="quiz-wrapper">
            <div className="quiz-container">
                { question > 0 && <button className="arrow arrow-left" onClick={() => { setQuestion(n => n - 1) }}><CgArrowLeft /></button> }

                <span><BsArrowReturnLeft /> Retour</span>

                <h1>{ currentQuestion.title }</h1>

                <form className="answers-container">
                    { currentQuestion.qcm ? (
                        generateQCM(currentQuestion)
                    ) : (
                        <textarea></textarea>
                    )}
                </form>

                { question < numberOfQuestions - 1 && <button className="arrow arrow-right" onClick={() => { setQuestion(n => n + 1) }}><CgArrowRight /></button> }
            </div>
        </div>
    );
}
