import { NavLink, useLoaderData, useParams } from "react-router-dom";
import { CgClose } from "react-icons/cg";
import "./style.css";

const Quiz = () => {
    const params = useParams();

    /**
     * @typedef quizData
     * @type {object}
     * @property {Number} id
     * @property {String} title
     * @property {Date} startDate
     * @property {Date} endDate
     * @property {String} createdBy
     */

    /** @type {quizData} */
    const quizData = useLoaderData();

    return (
        <div className="quiz-wrapper">
            <div className="quiz-container">
                <NavLink to={'/quiz'} className={'closer flat-button'}><CgClose /></NavLink>

                <h1>{ quizData.title }</h1>
                <h2>{ quizData.createdBy }</h2>
                <h2>{ quizData.startDate }</h2>
                <h2>{ quizData.endDate }</h2>

                <NavLink to={`/quiz/${params.quizId}/answer`} className={'contained-button'}>Commencer</NavLink>
            </div>
        </div>
    )
}

export default Quiz;
