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

const EvaluationCard = ({ evaluationInfo }) => {

    return (
        // <NavLink to={`/quiz/${el.id}`} className={'quiz'} key={el.id}>{ el.title }</NavLink>
        <div className={"quiz-card"}>
            <NavLink to={`/evaluations/${evaluationInfo.id}`}>
                <CardHeader id={evaluationInfo.id} img={evaluationInfo.img} />
                <CardBody title={evaluationInfo.title} date={evaluationInfo.startDate} time={evaluationInfo.time} form={evaluationInfo.createdBy} />
            </NavLink>
        </div>
        
    );
}

export default EvaluationCard;
