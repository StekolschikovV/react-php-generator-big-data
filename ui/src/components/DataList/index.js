import React, { Component } from 'react';


class DataList extends Component {
    render() {
        return (
            <ul>
                {
                    this.props.data.map((e, index)=>{
                        return <li key={`${index}`}>{e}</li>
                    })
                }
            </ul>
        );
    }
}

export default DataList;