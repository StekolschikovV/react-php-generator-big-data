import React, {Component} from 'react';
import './App.css';

import DataList from './components/DataList'
import InputForm from './components/InputForm'

class App extends Component {

    constructor(props) {
        super(props)

        this.state = {
            log: []
        }

        this.run = this.run.bind(this)
        this.log = this.log.bind(this)
    }

    componentDidMount() {
        this.log('componentDidMount')
    }

    log(mes) {
        let log = this.state.log
        log.push(mes)
        this.setState({
            log
        })
    }

    run(min, max, count) {
        console.log(min, max, count)
        if(count < 100 && count > 0) {
            fetch(`http://profit-center-fx/1/api/index.php?command=set&min=${min}&max=${max}&count=${count}`)
                .then(()=>{
                    this.log('generation step')
                    this.run(min, max, 0)
                })

        } else if(count > 0) {
            fetch(`http://profit-center-fx/1/api/index.php?command=set&min=${min}&max=${max}&count=${100}`)
                .then(()=>{
                    this.run(min, max, count - 100)
                    this.log('generation step')
                })
        } else {


            if(count === 0) {
                fetch(`http://profit-center-fx/1/api/index.php?command=get`)
                    .then(res => res.json())
                    .then((e)=>{

                        for (let i = 0; i < e.length; i++) {
                            console.log(e[i].value)
                            this.log('res: ' + e[i].value)
                        }

                        if(e.length) {
                            this.run(min, max, 0)
                        } else {
                            this.run(min, max, -1)
                        }
                    })
            } else {
                this.log('generation end')
            }

        }
    }

    render() {
        return (
            <div className="App">
                <InputForm run={this.run}/>
                <DataList data={this.state.log}/>
            </div>
        );
    }
}

export default App;
