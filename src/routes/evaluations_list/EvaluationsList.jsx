import { useState } from "react";
import { Outlet, useLoaderData, useNavigation, useParams, useRevalidator } from "react-router-dom";
import CoolInput from "../../components/cool_input/CoolInput";
import CoolSelect from "../../components/cool_select/CoolSelect";
import EvaluationCard from "../../components/evaluation_card/EvaluationCard";
import Loader from "../../components/loader/Loader";
import Modal from "../../components/modal/Modal";
import authService from "../../services/auth.service";
import postService from "../../services/post.service";
import './style.css';

const EvaluationsList = () => {
    const params = useParams();
    const data = useLoaderData();
    const evaluations = data.evaluations;

    const isFormateur = authService.hasRole('ROLE_FORMATEUR');

    const revalidator = useRevalidator();

    const [isLoading, setIsLoading] = useState(false);
    const [evaluationCreation, setEvaluationCreation] = useState(false);
    const [evaluationCreationError, setEvaluationCreationError] = useState(null);

    const handleSubmit = async (e) => {
        e.preventDefault();

        try {
            setIsLoading(true);
            const res = await postService.evaluations.createEvaluation(e.target);
            setIsLoading(false);

            if (res.status === 200) {
                setEvaluationCreation(false);
                revalidator.revalidate();
            } else {
                setEvaluationCreationError('Une erreur est survenu');
            }
        } catch (err) {
            setIsLoading(false);
            console.log(err);
            setEvaluationCreationError(err.response.data);
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
            let time = ((start - now));

            const units = [
                { lib: 'j', min: 24 * 3600 * 1000 },
                { lib: 'h', min: 3600 * 1000 },
                { lib: 'min', min: 60 * 1000 },
                { lib: 's', min: 1000 }
            ]

            for (const unit of units) {
                if (time / unit.min >= 1) {
                    time = `${Math.floor(time / unit.min)}${unit.lib}`;
                    break;
                }
            }
            
            evaluation.time = time;
        } else if (now > end) {
            value = evaluation.corrige ? 'finished' : 'waiting';
        } 
        else value = 'current';

        if (!evaluationElements[value]) {
            evaluationElements[value] = [];
        }
        evaluationElements[value].push(<EvaluationCard key={evaluation.id} evaluationInfo={evaluation} state={value} />);
    });

    return (
        <>
            { evaluationCreation && (
                <Modal id={ 'evaluation-creation' } handleClick={() => { setEvaluationCreation(false) }} size="small">
                    <>
                        <h2>Saisissez les informations de votre évaluation</h2>
                        <form onSubmit={ handleSubmit } onChange={ () => { setEvaluationCreationError(null) } }>
                            <CoolSelect name="quiz" label="Quiz" labelColor="#FFFFFF" data={ data.quiz } />
                            <CoolSelect name="formation" label="Formation" labelColor="#FFFFFF" data={ data.formations } />
                            <CoolInput name="dateDebut" type="datetime-local" label="Date de début" labelColor="#FFFFFF" />
                            <CoolInput name="dateFin" type="datetime-local" label="Date de fin" labelColor="#FFFFFF" />
                            { evaluationCreationError && evaluationCreationError }
                            <input type="submit" className="flat-button" />
                        </form>
                    </>
                </Modal>
            ) }
            <Outlet context={ evaluations.find(evaluation => evaluation.id == params.evaluationId) } />
            <div className="evaluations-list-container">
                <h1>Vos évaluations</h1>

                { isFormateur && <button className="contained-button" onClick={ () => { setEvaluationCreation(true); } }>Nouvelle évaluation</button> }
                {evaluationElements.current && (
                    <div className="evaluations-type-container">
                        <h2>En cours</h2>
                        <div className="content horizontal-scrollbar">
                            {evaluationElements.current}
                        </div>
                    </div>
                )}
                {evaluationElements.coming && (
                    <div className="evaluations-type-container">
                        <h2>A venir</h2>
                        <div className="content horizontal-scrollbar">
                            {evaluationElements.coming}
                        </div>
                    </div>
                )}
                {evaluationElements.waiting && (
                    <div className="evaluations-type-container">
                        <h2>En attente de correction</h2>
                        <div className="content horizontal-scrollbar">
                            {evaluationElements.waiting}
                        </div>
                    </div>
                )}
                {evaluationElements.finished && (
                    <div className="evaluations-type-container">
                        <h2>Corrigé</h2>
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
