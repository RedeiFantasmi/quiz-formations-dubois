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

const editQuiz = (quizId, data) => {
    return axios.post(API_URL + '/quiz/' + quizId + '/edit', data);
}

const deleteQuiz = (quizId) => {
    return axios.delete(API_URL + '/quiz/' + quizId + '/delete');
}

const getQuizQuestions = (quizId) => {
    return axios.get(API_URL + '/quiz/' + quizId + '/reponses');
}

const editQuizQuestion = (quizId, data) => {
    if (!data.id) {
        data.idQuiz = quizId;
        return axios.post(API_URL + '/question/create', data);
    }

    return axios.post(API_URL + '/question/' + data.id + '/edit', data);
}

// Evaluations
const getUserEvaluations = () => {
    return axios.get(API_URL + '/evaluation');
}

const getEvaluationData = (evaluationId) => {
    return axios.get(API_URL + '/evaluation/' + evaluationId);
}

const createEvaluation = (data) => {
    return axios.post(API_URL + '/evaluation/create', data);
}

const postService = {
    evaluations: {
        getUserEvaluations,
        getEvaluationData,
        createEvaluation,
    },

    quiz: {
        getUserQuiz,
        getQuizData,
        createQuiz,
        editQuiz,
        deleteQuiz,
        getQuizQuestions,
        editQuizQuestion,
    },
}

export default postService;
