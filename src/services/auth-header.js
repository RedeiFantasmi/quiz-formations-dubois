import authService from "./auth.service"

const authHeader = () => {
    const user = authService.getCurrentUser();

    if (user && user.token) {
        // return { "Authorization": `Bearer ${user.token}` }
        return `Bearer ${user.token}`;
    } else {
        return {}
    }
}

export default authHeader;
