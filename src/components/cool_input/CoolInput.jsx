const CoolInput = ({ type, name='text', active, label, placeholder, align, labelColor, defaultValue, min, max, onChange }) => {
    return (
        <div className={ "cool-input" + (active ? ' active' : '') } style={{ alignSelf: align }}>
            <input type={ type } name={ name } placeholder={placeholder ? placeholder : " "} value={defaultValue} onChange={ onChange } min={min} max={max} />
            <label style={{ backgroundColor: labelColor }}>{ label }</label>
        </div>
    )
}

export default CoolInput;
