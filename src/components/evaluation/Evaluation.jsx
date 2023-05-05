import { NavLink, useLoaderData, useParams } from "react-router-dom";
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
    const evaluationData = useLoaderData();

    return (
        <div className="evaluation-wrapper">
            <div className="evaluation-container">
                <NavLink to={'/evaluations'} className={'closer flat-button'}><CgClose /></NavLink>

                <h1>{ evaluationData.title }</h1>
                <h2>{ evaluationData.createdBy }</h2>
                <h2>{ evaluationData.startDate }</h2>
                <h2>{ evaluationData.endDate }</h2>

                <NavLink to={`/evaluations/${params.evaluationId}/answer`} className={'contained-button'}>Commencer</NavLink>
            </div>
        </div>
    )
}

export default Evaluation;
