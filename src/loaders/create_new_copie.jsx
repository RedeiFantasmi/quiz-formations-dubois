import { redirect } from "react-router-dom";
import postService from "../services/post.service";

const createNewCopie = async ({ params }) => {
    try {
        console.log('arg');
        const res = await postService.evaluations.createCopieEvaluation(params.evaluationId);

        if (res.status === 200) {
            return redirect(`/copie/${res.data}`);
        } 

        return redirect(`/evaluations/${params.evaluationId}`);
    } catch (err) {
        return redirect(`/evaluations/${params.evaluationId}`);;
    }
}

export default createNewCopie;
