

const CoolSelect = ({ name, label, labelColor, data }) => {
    if (!data instanceof Array) data = [];

    return (
        <div className="cool-input active">
            <select name={ name }>
                {
                    data.map(({ key, value }) => {

                        return <option key={ key } value={ key }>{ value }</option>
                    })
                }
            </select>
            <label style={{ backgroundColor: labelColor }}>{ label }</label>
        </div>
    )
}

export default CoolSelect
