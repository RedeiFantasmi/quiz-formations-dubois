import { NavLink } from "react-router-dom";
import './style.css';

const CardHeader = ({id, img = '/placeholder.png'}) => {
    return (
        <div className="card-header">
            <img src={img} alt="placeholder" />
        </div>
    );
}

const CardBody = ({ title, date, time, form }) => {
    return (
        <div className="card-body">
            <span className="form">{form}</span>
            <h2>{title}</h2>
            <span className="date">{date} - {time}</span>
        </div>
    );
}

const QuizCard = ({ quizInfo }) => {

    return (
        // <NavLink to={`/quiz/${el.id}`} className={'quiz'} key={el.id}>{ el.title }</NavLink>
        <div className={"quiz-card"}>
            <NavLink to={`/quiz/${quizInfo.id}`}>
                <CardHeader id={quizInfo.id} img={quizInfo.img} />
                <CardBody title={quizInfo.title} date={quizInfo.startDate} time={quizInfo.time} form={quizInfo.createdBy} />
            </NavLink>
        </div>
        
    );
}

export default QuizCard;
