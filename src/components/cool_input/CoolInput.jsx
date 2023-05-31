const CoolInput = ({ type, name='text', active, label, placeholder }) => {
    return (
        <div className={ "cool-input" + (active ? ' active' : '') }>
            <input type={ type } name={ name } placeholder={placeholder ? placeholder : " "} />
            <label>{ label }</label>
        </div>
    )
}

export default CoolInput;
