const userProfile = (() => {
    let type;

    const userData = () => {
        // const data = localStorage.getItem('data');

        // if (key && data?.key) return data[key];
        // else return data;

        return type ?? localStorage.getItem('type');
    }
    const setUserData = (userType) => {
        type = userType;
        localStorage.setItem('type', userType);
    }

    

    return {
        getType: userData,
        setType: setUserData
    };
})();

export default userProfile;
