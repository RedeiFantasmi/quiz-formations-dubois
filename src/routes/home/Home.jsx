import { key } from "localforage";
import { NavLink, useLoaderData } from "react-router-dom";
import authService from "../../services/auth.service";
import "./style.css";

const transformDatetime = (date) => {
    return `${date.substring(0, 10)} ${date.substring(11, 19)}`;
}

const AccueilEleve = ({ eleveData }) => {
    const lastCor = eleveData.lastCorrectCopie;
    const moyenneG = eleveData.moyenneGenerale;
    const comingEvaluations = eleveData.comingEvaluations;
    const currentEvaluations = eleveData.currentEvaluations;

    return (
        <div className="accueil-container">
            <div className="evaluations card">
                <h2 className="card-header">Evaluations en cours</h2>
                <div className="card-body horizontal-scrollbar">
                    {
                        currentEvaluations.map(evaluation => {
                            return (
                                <NavLink to={ `/evaluations/${evaluation.id}` } key={ evaluation.id }>
                                    <span>{ evaluation.titre }</span>
                                    <span>{ evaluation.libelle }</span>
                                    <span>{ `Fin ${transformDatetime(evaluation.dateFin)}` }</span>
                                </NavLink>
                            )
                        })
                    }

                    {
                        currentEvaluations.length === 0 && (
                            'Aucune évaluation courante.'
                        )
                    }
                </div>
            </div>
            <div className="evaluations card">
                <h2 className="card-header">Evaluations à venir</h2>
                <div className="card-body horizontal-scrollbar">
                    {
                        comingEvaluations.map(evaluation => {
                            return (
                                <div key={ evaluation.id }>
                                    <span>{ evaluation.titre }</span>
                                    <span>{ evaluation.libelle }</span>
                                    <span>{ `Début ${transformDatetime(evaluation.dateDebut)}` }</span>
                                </div>
                            )
                        })
                    }

                    {
                        comingEvaluations.length === 0 && (
                            'Aucune évaluation prévue.'
                        )
                    }
                </div>
            </div>
            <div className="last-copie card">
                <h2 className="card-header">Dernière Copie</h2>
                <div className="card-body">
                    <NavLink to={ `/evaluations/${lastCor.id}` } className="last-copie-link">
                        <span className="last-copie-titre">{ lastCor.titre }</span>
                        <span className="last-copie-note">{ `${lastCor.note} / ${lastCor.noteMax}` }</span>
                    </NavLink>
                </div>
            </div>
            <div className="moyenne card">
                <h2 className="card-header">Moyenne Générale</h2>
                <div className="card-body">
                    <span className="moyenne-container">{ moyenneG.toFixed(2).replace(/\.?0*$/,'') } / 20</span>
                </div>
            </div>
        </div>
    );
}

const AccueilFormateur = ({ formateurData }) => {
    const toCorrect = formateurData.evaluationsToCorrect;
    const comingEvaluations = formateurData.comingEvaluations;
    const lastQuiz = formateurData.lastQuiz;

    return (
        <div className="accueil-container">
            <div className="evaluations card">
                <h2 className="card-header">Evaluations à corriger</h2>
                <div className="card-body horizontal-scrollbar">
                    {
                        toCorrect.map(evaluation => {
                            return (
                                <NavLink to={ `/evaluations/${evaluation.id}` } key={ evaluation.id }>
                                    <span>{ evaluation.titre }</span>
                                    <span>{ evaluation.libelle }</span>
                                    <span>{ `Fini ${transformDatetime(evaluation.dateFin)}` }</span>
                                </NavLink>
                            )
                        })
                    }

                    {
                        toCorrect.length === 0 && (
                            'Aucune évaluation à corriger.'
                        )
                    }
                </div>
            </div>
            <div className="evaluations card">
                <h2 className="card-header">Evaluations à venir</h2>
                <div className="card-body horizontal-scrollbar">
                    {
                        comingEvaluations.map(evaluation => {
                            return (
                                <div key={ evaluation.id }>
                                    <span>{ evaluation.titre }</span>
                                    <span>{ evaluation.libelle }</span>
                                    <span>{ `Début ${transformDatetime(evaluation.dateDebut)}` }</span>
                                </div>
                            )
                        })
                    }

                    {
                        comingEvaluations.length === 0 && (
                            'Aucune évaluation prévue.'
                        )
                    }
                </div>
            </div>
            <div className="evaluations card">
                <h2 className="card-header">Derniers Quiz Créés</h2>
                <div className="card-body horizontal-scrollbar">
                    {
                        lastQuiz.map(quiz => {
                            return (
                                <NavLink to={ `/quiz/${quiz.id}` } key={ quiz.id }>
                                    <span>{ quiz.titre }</span>
                                    <span>{ `Créé ${transformDatetime(quiz.dateCreation)}` }</span>
                                </NavLink>
                            )
                        })
                    }

                    {
                        comingEvaluations.length === 0 && (
                            'Aucune évaluation prévue.'
                        )
                    }
                </div>
            </div>
            
        </div>
    )
}

const Home = () => {
    const accueilData = useLoaderData();
    const eleve = authService.hasRole('ROLE_ELEVE');
    const formateur = authService.hasRole('ROLE_FORMATEUR');

    return (
        <div>
            <h1>Dashboard</h1>
            {
                formateur
                    ? <AccueilFormateur formateurData={ accueilData } />
                    : (
                        eleve
                            ? <AccueilEleve eleveData={ accueilData } />
                            : 'WTH ARE YOU ?!'
                    )
            }
        </div>
    );
}

export default Home;
