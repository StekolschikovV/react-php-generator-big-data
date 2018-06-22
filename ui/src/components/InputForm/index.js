import React, { Component } from 'react';


class InputForm extends Component {

    constructor(props) {
        super(props)

        this.submit = this.submit.bind(this)
    }

    submit(e){
        e.preventDefault();

        let min = e.target.min.value
        let max = e.target.max.value
        let count = e.target.count.value

        this.props.run(min, max, count)
    }

    render() {
        return (
            <form onSubmit={this.submit}>
                <input type="number" name={'min'}/>
                <input type="number" name={'max'}/>
                <input type="number" name={'count'}/>
                <input type="submit" value={'Go'}/>
            </form>
        );
    }
}

export default InputForm;