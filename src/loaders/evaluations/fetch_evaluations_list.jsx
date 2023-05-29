import { defer } from "react-router-dom";
import postService from "../../services/post.service";

const fetchEvaluationsList = async () => {    
    try {
        const res = await postService.evaluations.getUserEvaluations();
        // return defer(res);
        
        if (res.status === 200) {
            console.log('gg');
            return JSON.parse(res.data);
        } else {
            return [];
        }
    } catch (err) {
        throw err;
    }
}

export default fetchEvaluationsList;
