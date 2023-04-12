import { useRouteError } from "react-router-dom";
import "./style.css";

export default function Error() {
    const error = useRouteError();

    switch (error.status) {
        case 404: {
            return (
                <div className="error-wrapper">
                    <h1>Did you get lost ?</h1>
                    <img src="/404.gif" alt="damn antonin" />
                </div>
            );
        }
        default: {
            return (
                <h1>Error</h1>
            );
        }
    }
}
