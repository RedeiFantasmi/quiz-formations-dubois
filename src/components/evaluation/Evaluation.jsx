import { useState } from "react";
import { CgClose } from "react-icons/cg";
import { FaCheck, FaTimesCircle } from "react-icons/fa";
import { NavLink, useNavigate, useOutletContext, useParams, useRevalidator } from "react-router-dom";
import authService from "../../services/auth.service";
import postService from "../../services/post.service";
import CoolInput from "../cool_input/CoolInput";
import Loader from "../loader/Loader";
import Modal from "../modal/Modal";
import "./style.css";

const Evaluation = () => {
    const params = useParams();
    const evaluationData = useOutletContext();
    const eleve = authService.hasRole('ROLE_ELEVE');
    const formateur = authService.hasRole('ROLE_FORMATEUR');
    const revalidator = useRevalidator();
    const navigate = useNavigate();

    const [isLoading, setIsLoading] = useState(false);
    const [editEvaluation, setEditEvaluation] = useState(false);
    const [evaluationEditError, setEvaluationEditError] = useState(null);
    
    const transformDatetime = (date) => {
        return `${date.substring(0, 10)} ${date.substring(11, 19)}`;
    }

    const handleSubmit = async (e) => {
        e.preventDefault();

        try {
            setIsLoading(true);
            const res = await postService.evaluations.editEvaluation(params.evaluationId, e.target);
            setIsLoading(false)

            if (res.status === 200) {
                setEditEvaluation(false);
                revalidator.revalidate();
            }
        } catch (err) {
            setIsLoading(false);
            setEvaluationEditError(err.response.data);
        }
    }

    const handleDelete = async () => {
        try {
            setIsLoading(true);
            const res = await postService.evaluations.deleteEvaluation(params.evaluationId);
            setIsLoading(false);

            if (res.status === 200) {
                revalidator.revalidate();
                navigate('/evaluations');
            }
        } catch (err) {
            setIsLoading(false);
        }
    }

    const handleCorrect = async () => {
        try {
            setIsLoading(true);
            const res = await postService.evaluations.lockEvaluation(params.evaluationId);
            setIsLoading(false);
            if (res.status === 200) {
                revalidator.revalidate();
                navigate('/evaluations');
            }
        } catch (err) {
            console.log(err);
            setIsLoading(false);
        }
    }

    const now = Date.now();

    return (
        <>
            <div className="evaluation-wrapper">
                <div className="evaluation-container">
                    <NavLink to={'/evaluations'} className={'closer flat-button'}><CgClose /></NavLink>

                    <h1>{ evaluationData.titre }</h1>
                    <p>Créée par { `${evaluationData.formateur}` }</p>
                    <p>Débute le { transformDatetime(evaluationData.dateDebut) }</p>
                    <p>Se termine le { transformDatetime(evaluationData.dateFin) }</p>

                    { (new Date(evaluationData.dateDebut) > now && formateur) &&
                        <button className="contained-button" onClick={ () => { setEditEvaluation(true) } }>Reprogrammer</button>
                    }

                    { (new Date(evaluationData.dateDebut) <= now && now <= new Date(evaluationData.dateFin) && eleve && !evaluationData.estCloture) &&
                        <NavLink 
                            to={ evaluationData.copie ? `/copie/${evaluationData.copie}` : `/evaluations/${params.evaluationId}/copie/create` } 
                            className="contained-button"
                        >
                            { evaluationData.copie ? 'Reprendre' : 'Commencer' }
                        </NavLink>
                    }

                    {
                        eleve && evaluationData.corrige && (
                            <div className="copie-res">
                                <div className="stat card">
                                    <h2 className="card-header">Note</h2>
                                    <div className="card-body">
                                        <span className="stat-container">{ `${evaluationData.note} / ${evaluationData.noteMax}` }</span>
                                    </div>
                                </div>
                                <div className="stat card">
                                    <h2 className="card-header">Moyenne Classe</h2>
                                    <div className="card-body">
                                        <span className="stat-container">{ `${evaluationData.moyenneClasse.toFixed(2).replace(/\.?0*$/,'')} / ${evaluationData.noteMax}` }</span>
                                    </div>
                                </div>
                                <div className="stat card">
                                    <h2 className="card-header">Classement</h2>
                                    <div className="card-body">
                                        <span className="stat-container">{ `${evaluationData.pos} / ${evaluationData.nbEleves}` }</span>
                                    </div>
                                </div>
                                <div className="commentaire card">
                                    <h2 className="card-header">Commentaire du formateur</h2>
                                    <div className="card-body">
                                        <span className="commentaire-container">{ `${evaluationData.annotation}` }</span>
                                    </div>
                                </div>
                            </div>
                            
                             
                        )
                    }

                    {
                        eleve && (new Date(evaluationData.dateFin) < now || evaluationData.estCloture) && (
                            (evaluationData.copie
                                ? <NavLink className="contained-button" to={`/copie/${evaluationData.copie}`} target="_blank">Consulter votre copie</NavLink>
                                : <div className="contained-button disabled" title="Vous n'avez pas pris part à cette évaluation.">Consulter votre copie</div>
                            )
                        )
                    }

                    { formateur && evaluationData?.copies && (
                        <>
                            <div className="evaluation-copies">
                                <h2>Copies</h2>
                                <div className="evaluation-copies-container">
                                    { evaluationData.copies.map(copie => {
                                        if (copie.id && !copie.annotation) {
                                            return <NavLink key={copie.eleve} to={`/copie/${copie.id}`}>{copie.nom} {copie.prenom}</NavLink>
                                        } else {
                                            return <span key={copie.eleve}>{copie.nom} {copie.prenom} {copie.id ? <FaCheck className="check" title="Vous avez déjà corrigé cette copie." /> : <FaTimesCircle className="times" title="Cet élève n'a pas participé à l'évaluation." />}</span>
                                        }
                                    }) }
                                </div>
                            </div>
                            <button className="contained-button" onClick={ handleCorrect }>Valider correction</button>
                        </>
                    ) }
                </div>
            </div>
            { editEvaluation && (
                <Modal id="reprogram-evaluation" size="small" handleClick={ () => { setEditEvaluation(false) } }>
                    <h2>Modifier les dates ou annulez votre évaluation</h2>
                    <form onSubmit={ handleSubmit } onChange={ () => { setEvaluationEditError(null) } }>
                        <CoolInput name="dateDebut" type="datetime-local" label="Date de début" labelColor="#FFFFFF" />
                        <CoolInput name="dateFin" type="datetime-local" label="Date de fin" labelColor="#FFFFFF" />
                        <button type="button" className="flat-button cancel-eval" onClick={ handleDelete }>Annuler l'évaluation</button>
                        { evaluationEditError && evaluationEditError }
                        <input type="submit" className="contained-button" />
                    </form>
                </Modal>
            ) }
            { isLoading && <Loader /> }
        </>
    )
}

export default Evaluation;
