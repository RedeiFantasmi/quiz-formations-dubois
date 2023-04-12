import { Outlet, useParams } from "react-router-dom";

export default function Quiz() {

    return (
        <>
            <h1>Quiz page</h1>
            <a href="/quiz/1/answer">raccourci </a>
            <Outlet />
        </>
        
    );
}
