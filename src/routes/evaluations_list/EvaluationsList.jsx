import { Outlet, useLoaderData } from "react-router-dom";
import EvaluationCard from "../../components/evaluation_card/EvaluationCard";
import './style.css';

const EvaluationsList = () => {

    const evaluations = useLoaderData();

    const now = Date.now();

    const evaluationElements = {};
    evaluations.forEach(q => {
        const start = new Date(q.startDate);
        const end = new Date(q.endDate);

        let value;
        if (now < start) value = 'coming'
        else if (now > end) value = 'finished';
        else value = 'current';

        if (!evaluationElements[value]) {
            evaluationElements[value] = [];
        }
        evaluationElements[value].push(<EvaluationCard key={q.id} evaluationInfo={q} state={value} />);
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
