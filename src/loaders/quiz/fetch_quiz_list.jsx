import postService from "../../services/post.service";

const fetchQuizList = async () => {
    try {
        const res = await postService.quiz.getUserQuiz();
        if (res.status === 200) {
            return JSON.parse(res.data);
        } else {
            return [];
        }
    } catch (err) {
        throw err;
    }
}

export default fetchQuizList;
