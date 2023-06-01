import { useEffect, useState } from "react";
import { NavLink, useLoaderData, useParams } from "react-router-dom";
import { CgArrowLeft, CgArrowRight } from "react-icons/cg";
import { FaPlus } from "react-icons/fa";
import { FiChevronLeft } from "react-icons/fi";
// import "./style.css";



// const QCMFields = ({ questionData, updateQuestion }) => {
//     const choices = [
//         questionData.choix1,
//         questionData.choix2,
//         questionData.choix3,
//         questionData.choix4,
//     ];

//     return (
//         <>
//             {
//                 choices.map((choice, i) => {
//                     if (choice) {
//                         const handleChange = (e) => {
//                             updateQuestion({
//                                 ...questionData,
//                                 [`repChoix${i + 1}`]: e.target.checked,
//                             });
//                         }

//                         return (
//                             <div className="answer-wrapper" key={`${i}${choice}`}>
//                                 <div className="answer">
//                                     <input type="checkbox" checked={questionData[`repChoix${i + 1}`]} onChange={handleChange} />
//                                     <p>{choice}</p>
//                                 </div>
//                             </div>
//                         );
//                     }
//                 })
//             }
//         </>
//     )
// }

// const QuestionFields = ({ questionData, setCurrentQuestion }) => {
//     return (
//         <>
//             {
//                 questionData.qcm
//                     ? <QCMFields questionData={questionData} updateQuestion={setCurrentQuestion} />
//                     : <textarea
//                         onChange={(e) => {
//                             setCurrentQuestion({ ...questionData, reponse: e.target.value }
//                             )
//                         }}
//                         value={questionData.reponse}
//                     >
//                     </textarea>
//             }
//         </>
//     )
// }

const QuestionsQuiz = () => {
    const params = useParams();
    const questions = useLoaderData();
    console.log(questions);

    // const [questionNb, setQuestionNb] = useState(0);
    // const [currentQuestion, setCurrentQuestion] = useState(questions[questionNb]);

    // useEffect(() => {
    //     setCurrentQuestion(questions[questionNb]);
    // }, [questionNb, questions]);

    // const handleClick = async (value) => {
    //     // Ajouter requête vers BDD, plus gestion erreur d'envoi
    //     questions[questionNb] = currentQuestion;
    //     setQuestionNb(n => n + value);
    //     // setCurrentQuestion(questions[questionNb + value]);
    // }

    // const handleSubmit = () => {
    //     const formData = new FormData();

    //     // A faire, créer le formdata et l'envoyer en BDD
    // }

    // const numberOfQuestions = questions.length

    return (
        <div className="quiz-wrapper">
            <div className="quiz-container">
                {/* {questionNb > 0 && <button className="arrow arrow-left" onClick={() => handleClick(-1)}><CgArrowLeft /></button>} */}

                {/* <NavLink to={`/evaluations/${params.evaluationId}`} className={'back flat-button'}><FiChevronLeft /> Retour</NavLink> */}

                {/* <h1>{currentQuestion.title}</h1> */}

                <form className="answers-container">
                    {/* <QuestionFields questionData={currentQuestion} setCurrentQuestion={setCurrentQuestion} /> */}
                </form>

                {/* {questionNb < numberOfQuestions - 1 ?
                    <button 
                        className="arrow arrow-right" onClick={() => handleClick(+1)}><CgArrowRight /></button>
                    : <button className="arrow arrow-right"><FaPlus /></button>
                } */}
            </div>
        </div>
    );
}

export default QuestionsQuiz;
