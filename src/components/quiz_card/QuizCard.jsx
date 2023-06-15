import { NavLink } from "react-router-dom";
import './style.css';

const CardHeader = ({id, img = '/placeholder.png'}) => {
    return (
        <div className="card-header">
            <img src={img} alt="placeholder" />
        </div>
    );
}

const CardBody = ({ title, date }) => {
    return (
        <div className="card-body">
            <h2>{title}</h2>
            <span className="date">{date.substring(0, 10).replaceAll('-', '/')} {date.substring(11, 19)}</span>
        </div>
    );
}

const QuizCard = ({ quizInfo }) => {

    return (
        <div className={"quiz-card"}>
            <NavLink to={`/quiz/${quizInfo.id}`}>
                <CardHeader id={quizInfo.id} img={quizInfo.img} />
                <CardBody title={quizInfo.titre} date={quizInfo.dateCreation} />
            </NavLink>
        </div>
        
    );
}

export default QuizCard;
