const CoolInput = ({ type, name='text', active, label, placeholder, align, labelColor, defaultValue, onChange }) => {
    return (
        <div className={ "cool-input" + (active ? ' active' : '') } style={{ alignSelf: align }}>
            <input type={ type } name={ name } placeholder={placeholder ? placeholder : " "} value={defaultValue} onChange={ onChange } />
            <label style={{ backgroundColor: labelColor }}>{ label }</label>
        </div>
    )
}

export default CoolInput;
