import { NavLink, Outlet, useParams } from "react-router-dom";

export default function QuizList() {

    const quiz = [
        {
            id: 1,
            title: 'test quiz',
        }
    ]

    return (
        <>
            <h1>Quiz page</h1>
            <div className="quiz-list-container">
                { quiz.map(el => {
                    return (
                        <NavLink to={`/quiz/${el.id}`} className={'quiz'} key={el.id}>{ el.title }</NavLink>
                    )
                }) }
            </div>
            <Outlet />
        </>
        
    );
}
