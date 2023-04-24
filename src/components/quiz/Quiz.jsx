import { NavLink, useParams } from "react-router-dom";
import { CgClose } from "react-icons/cg";
import "./style.css";

const Quiz = () => {
    const params = useParams();

    return (
        <div className="quiz-wrapper">
            <div className="quiz-container">
                <NavLink to={'/quiz'} className={'closer'}><CgClose /></NavLink>
                <NavLink to={`/quiz/${params.quizId}/answer`}>Commencer</NavLink>
            </div>
        </div>
    )
}

export default Quiz;
