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

const createQuiz = (data) => {
    return axios.post(API_URL + '/quiz/create', data);
}

const deleteQuiz = (quizId) => {
    return axios.delete(API_URL + '/quiz/' + quizId + '/delete');
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
        createQuiz,
        deleteQuiz,
    },
}

export default postService;
