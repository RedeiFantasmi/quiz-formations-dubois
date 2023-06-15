import postService from "../services/post.service";

const fetchHomeData = async () => {
    try {
        const res = await postService.user.getUserAccueil();

        if (res.status === 200) {
            return res.data;
        }
    } catch (err) {
        throw err;
    }
}

export default fetchHomeData;
