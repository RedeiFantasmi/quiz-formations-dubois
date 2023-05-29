import { Outlet, useLoaderData } from "react-router-dom";
import EvaluationCard from "../../components/evaluation_card/EvaluationCard";
import './style.css';

const EvaluationsList = () => {

    const evaluations = useLoaderData();

    const now = Date.now();

    const evaluationElements = {};
    
    evaluations.forEach(evaluation => {
        const start = new Date(evaluation.dateDebut);
        const end = new Date(evaluation.dateFin);
        let value;
        if (now < start) {
            value = 'coming';
            let time = ((start - now) / (1000 * 3600 * 24));
            if (time < 1) time = Math.floor(time * 24) + 'h';
            else time = Math.floor(time) + 'd';
            evaluation.time = time;
        } else if (now > end) value = 'finished';
        else value = 'current';

        if (!evaluationElements[value]) {
            evaluationElements[value] = [];
        }
        evaluationElements[value].push(<EvaluationCard key={evaluation.id} evaluationInfo={evaluation} state={value} />);
    });

    return (
        <>
            <h1>Evaluation page</h1>
            <Outlet />
            <div className="evaluations-list-container">
                {evaluationElements.current && (
                    <div className="evaluations-type-container">
                        <h2>Evaluation en cours</h2>
                        <div className="content horizontal-scrollbar">
                            {evaluationElements.current}
                        </div>
                    </div>
                )}
                {evaluationElements.coming && (
                    <div className="evaluations-type-container">
                        <h2>Evaluation à venir</h2>
                        <div className="content horizontal-scrollbar">
                            {evaluationElements.coming}
                        </div>
                    </div>
                )}
                {evaluationElements.finished && (
                    <div className="evaluations-type-container">
                        <h2>Evaluations terminés</h2>
                        <div className="content horizontal-scrollbar">
                            {evaluationElements.finished}
                        </div>
                    </div>
                )}
            </div>
        </>

    );
}

export default EvaluationsList;
