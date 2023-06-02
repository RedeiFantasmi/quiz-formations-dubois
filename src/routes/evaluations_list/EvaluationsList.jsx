import { Outlet, useLoaderData, useNavigation, useParams, useRevalidator } from "react-router-dom";
import EvaluationCard from "../../components/evaluation_card/EvaluationCard";
import './style.css';
import postService from "../../services/post.service";
import Loader from "../../components/loader/Loader";
import { useState } from "react";
import Modal from "../../components/modal/Modal";
import CoolInput from "../../components/cool_input/CoolInput";
import authService from "../../services/auth.service";

const EvaluationsList = () => {
    const params = useParams();
    const evaluations = useLoaderData();

    const isFormateur = authService.hasRole('ROLE_FORMATEUR');

    const revalidator = useRevalidator();

    const [isLoading, setIsLoading] = useState(false);
    const [evaluationCreation, setEvaluationCreation] = useState(false);

    const handleSubmit = async (e) => {
        e.preventDefault();
        setIsLoading(true);
        const res = await postService.evaluations.createEvaluation(e.target);
        
        setIsLoading(false);
        if (res.status === 200) {
            setEvaluationCreation(false);
            revalidator.revalidate();
        }
    }

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
            { evaluationCreation && (
                <Modal id={ 'evaluation-creation' } handleClick={() => { setEvaluationCreation(false) }}>
                    <>
                        <h2>Saisissez le quiz, la formation et les horaires de l'évaluation</h2>
                        <form onSubmit={handleSubmit}>
                            <CoolInput name={"evaluation-name"} />
                            <input type="submit" className="flat-button" />
                        </form>
                    </>
                </Modal>
            ) }
            <h1>Evaluation page</h1>

            { isFormateur && <button className="contained-button" onClick={ () => { setEvaluationCreation(true); } }>Nouvelle évaluation</button> }
            <Outlet context={ evaluations.find(evaluation => evaluation.id == params.evaluationId) } />
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
            { isLoading && <Loader /> }
        </>

    );
}

export default EvaluationsList;
