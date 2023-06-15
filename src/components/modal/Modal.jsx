import { CgClose } from "react-icons/cg";
import "./style.css";

const Modal = ({ size, id, children, handleClick }) => {
    return (
        <div id={ id } className={ "modal-wrapper" + (size === 'small' ? ' small' : '') }>
            <div className="modal-container">
                {
                    handleClick && (
                        <button 
                            onClick={ handleClick } 
                            className="flat-button closer"
                        >
                            <CgClose />
                        </button>
                    )
                    
                }
                { children }
            </div>
        </div>
    );
}

export default Modal;
