import postService from "../../services/post.service";

const fetchQuiz = async ({ params }) => {
    try {
        const id = params.quizId;

        const res = await postService.quiz.getQuizData(id);
        if (res.status === 200) {
            return JSON.parse(res.data);
        } else {
            return [];
        }
    } catch (err) {
        throw err;
    }
}

export default fetchQuiz;
