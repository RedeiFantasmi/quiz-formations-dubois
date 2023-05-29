import axios from "axios";
import authHeader from "./auth-header";


const API_URL = import.meta.env.VITE_API_URL;

axios.defaults.headers.common.Authorization = authHeader();

// Quiz
const getUserQuiz = () => {
    return axios.get(API_URL + '/quiz');
}

const getQuizData = (quizId) => {
    return axios.get(API_URL + '/quiz/' + quizId);
}

// Evaluations
const getUserEvaluations = () => {
    return axios.get(API_URL + '/evaluation');
}

const getEvaluationData = (evaluationId) => {
    return axios.get(API_URL + '/evaluation/' + evaluationId);
}

const postService = {
    evaluations: {
        getUserEvaluations,
        getEvaluationData,
    },

    quiz: {
        getUserQuiz,
        getQuizData,
    },
}

export default postService;
