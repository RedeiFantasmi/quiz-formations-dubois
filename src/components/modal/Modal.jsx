import { CgClose } from "react-icons/cg";
import "./style.css";

const Modal = ({ size, children, handleClick=()=>{return;} }) => {
    return (
        <div className={"modal-wrapper" + (size === 'small' ? ' small' : '')}>
            <div className="modal-container">
                <button onClick={handleClick} className="flat-button closer"><CgClose /></button>
                { children }
            </div>
        </div>
    );
}

export default Modal;
