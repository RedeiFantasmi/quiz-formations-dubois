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
            <span className="form">{form.prenom[0] + '. ' + form.nom}</span>
            <h2>{title}</h2>
            <span className="date">{date.substring(0, 10).replaceAll('-', '/')} {date.substring(11, 19)} {time && `- ${time}`}</span>
        </div>
    );
}

const EvaluationCard = ({ evaluationInfo }) => {

    return (
        // <NavLink to={`/quiz/${el.id}`} className={'quiz'} key={el.id}>{ el.title }</NavLink>
        <div className={"quiz-card"}>
            <NavLink to={`/evaluations/${evaluationInfo.id}`}>
                <CardHeader id={evaluationInfo.id} img={evaluationInfo.img} />
                <CardBody title={evaluationInfo.quiz.titre} date={evaluationInfo.dateDebut} time={evaluationInfo.time} form={evaluationInfo.quiz.formateur} />
            </NavLink>
        </div>
        
    );
}

export default EvaluationCard;
