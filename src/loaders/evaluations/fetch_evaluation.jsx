import postService from "../../services/post.service";

const fetchEvaluation = async ({params}) => {
    const id = params.evaluationId;

    try {
        const res = await postService.evaluations.getEvaluationData(id);

        if (res.status === 200) {
            return JSON.parse(res.data);
        } else {
            return [];
        }
    } catch (err) {
        throw err;
    }
}

export default fetchEvaluation;
