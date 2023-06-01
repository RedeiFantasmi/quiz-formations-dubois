import postService from "../../services/post.service";

const fetchQuizQuestions = async ({ params }) => {
    const res = await postService.quiz.getQuizQuestions(params.quizId);

    if (res.status === 200) {
        return JSON.parse(res.data);
    } else {
        return [];
    }
}

export default fetchQuizQuestions;
