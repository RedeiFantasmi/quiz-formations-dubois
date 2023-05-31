import { NavLink, useLoaderData, useParams } from "react-router-dom";
import { CgClose } from "react-icons/cg";
import "./style.css";
import postService from "../../services/post.service";

const Quiz = () => {
    const params = useParams();

    const quizData = useLoaderData();
    console.log(quizData);

    const handleDeleteClick = () => {
        const id = params.quizId;

        postService.quiz.deleteQuiz(id);
    }

    return (
        <div className="quiz-wrapper">
            <div className="quiz-container">
                <NavLink to={'/quiz'} className={'closer flat-button'}><CgClose /></NavLink>

                <h1>{ quizData.data.titre }</h1>
                <h2>Questions</h2>
                <div>
                    { quizData.questions.map(question => {
                        return (
                            <span key={ question.id }>{ `${question.enonce} (/${question.noteMax})` }</span>
                        )
                    }) }
                </div>
                <h3>Créé le : { quizData.data.dateCreation.substring(0, 10) }</h3>
                <button onClick={ handleDeleteClick }>Delete</button>

                <NavLink to={`/quiz/${params.quizId}/answer`} className={'contained-button'}>Modifier</NavLink>
            </div>
        </div>
    )
}

export default Quiz;
