import axios from "axios";
import authHeader from "./auth-header";

const API_URL = import.meta.env.VITE_API_URL;

axios.defaults.headers.common.Authorization = authHeader();



// Quiz
const getUserQuiz = () => {
    return axios.get(`${API_URL}/quiz`);
}

const createQuiz = (data) => {
    return axios.post(`${API_URL}/quiz/create`, data);
}

const editQuiz = (quizId, data) => {
    return axios.post(`${API_URL}/quiz/${quizId}/edit`, data);
}

const deleteQuiz = (quizId) => {
    return axios.delete(`${API_URL}/quiz/${quizId}/delete`);
}

const editQuizQuestion = (quizId, data) => {
    if (!data.id) {
        data.idQuiz = quizId;
        return axios.post(`${API_URL}/question/create`, data);
    }

    return axios.post(`${API_URL}/question/${data.id}/edit`, data);
}

const deleteQuizQuestion = (questionId) => {
    return axios.delete(`${API_URL}/question/${questionId}/delete`);
}



// Evaluations
const getUserEvaluations = () => {
    return axios.get(`${API_URL}/evaluation`);
}

const createEvaluation = (data) => {
    return axios.post(`${API_URL}/evaluation/create`, data);
}

const editEvaluation = (evaluationId, data) => {
    return axios.post(`${API_URL}/evaluation/${evaluationId}/edit`, data);
}

const deleteEvaluation = (evaluationId) => {
    return axios.delete(`${API_URL}/evaluation/${evaluationId}/delete`);
}

const lockEvaluation = (evaluationId) => {
    return axios.post(`${API_URL}/evaluation/${evaluationId}/lock`);
}

const createCopieEvaluation = (evaluationId) => {
    return axios.post(`${API_URL}/evaluation/${evaluationId}/copie/create`, );
}



// User
const getUserFormations = () => {
    return axios.post(`${API_URL}/formation`);
}

const getUserAccueil = () => {
    return axios.get(`${API_URL}/accueil`);
}



// Copie
const getCopieData = (copieId) => {
    return axios.post(`${API_URL}/copie/${copieId}`);
}

const sendCopieData = (copieId, data) => {
    return axios.post(`${API_URL}/copie/${copieId}/reponse/add`, data);
}

const lockCopie = (copieId) => {
    return axios.post(`${API_URL}/copie/${copieId}/lock`);
}

const correctCopie = (copieId, data) => {
    return axios.post(`${API_URL}/copie/${copieId}/correct`, data);
}


const postService = {
    evaluations: {
        getUserEvaluations,
        createEvaluation,
        editEvaluation,
        deleteEvaluation,
        lockEvaluation,
        createCopieEvaluation,
    },

    quiz: {
        getUserQuiz,
        createQuiz,
        editQuiz,
        deleteQuiz,
        editQuizQuestion,
        deleteQuizQuestion,
    },

    copie: {
        getCopieData,
        sendCopieData,
        lockCopie,
        correctCopie,
    },

    user: {
        getUserFormations,
        getUserAccueil,
    },
}

export default postService;
