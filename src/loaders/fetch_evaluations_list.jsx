import authService from "../services/auth.service";
import postService from "../services/post.service";

const fetchEvaluationsList = async () => {  
    const formateur = authService.hasRole('ROLE_FORMATEUR');  
    try {
        if (formateur) {
            const [evaluations, quiz, formations] = await Promise.all(
                [
                    postService.evaluations.getUserEvaluations(),
                    postService.quiz.getUserQuiz(),
                    postService.user.getUserFormations()
                ]
            );
    
            const quizOptions = JSON.parse(quiz.data).map(q => {
                return { key: q.id, value: q.titre }
            });
    
            const formationsOptions = JSON.parse(formations.data).map(form => {
                return { key: form.id, value: form.libelle }
            });
    
            const data = {
                evaluations: evaluations.data,
                quiz: quizOptions,
                formations: formationsOptions
            }

            return data
        } else {
            const res = await postService.evaluations.getUserEvaluations();
            console.log(res.data);
            return {
                evaluations: res.data
            }
        }
    } catch (err) {
        console.log(err);
        throw err;
    }
}

export default fetchEvaluationsList;
