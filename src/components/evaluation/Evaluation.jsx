import { NavLink, useLoaderData, useOutletContext, useParams } from "react-router-dom";
import { CgClose } from "react-icons/cg";
import "./style.css";

const Evaluation = () => {
    const params = useParams();

    /**
     * @typedef evaluationData
     * @type {object}
     * @property {Number} id
     * @property {String} title
     * @property {Date} startDate
     * @property {Date} endDate
     * @property {String} createdBy
     */

    /** @type {evaluationData} */
    // const evaluationData = useLoaderData();
    const evaluationData = useOutletContext();
    
    const transformDatetime = (date) => {
        return `${date.substring(0, 10)} ${date.substring(11, 19)}`;
    }

    const now = Date.now();

    return (
        <div className="evaluation-wrapper">
            <div className="evaluation-container">
                <NavLink to={'/evaluations'} className={'closer flat-button'}><CgClose /></NavLink>

                <h1>{ evaluationData.quiz.titre }</h1>
                <h2>{ `${evaluationData.quiz.formateur.prenom[0]} ${evaluationData.quiz.formateur.nom}` }</h2>
                <h2>De : { transformDatetime(evaluationData.dateDebut) }</h2>
                <h2>A : { transformDatetime(evaluationData.dateFin) }</h2>

                { new Date(evaluationData.dateDebut) <= now && now <= new Date(evaluationData.dateFin) &&
                    <NavLink 
                        to={evaluationData.url} 
                        className={'contained-button'}
                    >
                        { evaluationData.started ? 'Reprendre' : 'Commencer' }
                    </NavLink>
                }
                
            </div>
        </div>
    )
}

export default Evaluation;
