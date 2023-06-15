import postService from "../services/post.service";

const fetchCopie = async ({ params }) => {
    try {
        const id = params.copieId;

        const res = await postService.copie.getCopieData(id);

        if (res.status === 200) {
            return res.data;
        } else {
            throw new Error();
        }
    } catch (err) {
        throw err;
    }
}

export default fetchCopie;
