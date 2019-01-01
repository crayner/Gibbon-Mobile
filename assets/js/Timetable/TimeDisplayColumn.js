'use strict';

import React from "react"
import PropTypes from 'prop-types'

export default function TimeDisplayColumn(props) {
    const {
        content,
    } = props

    let times = []
    for(let time = 0; time <= content.timeDiff + content.timeOffset + content.timeAdditional; time += 60) {
        let theTime = new Date(new Date(content.timeStart.date).getTime() - content.timeOffset * 60000)
        theTime = new Date(theTime.getTime() + (time * 60000))
        times.push  (
            <div className='col-12 card text-center' style={{height: '60px'}} key={time}>
                {('0' + (theTime.getHours())).slice(-2)}:{('0' + theTime.getMinutes()).slice(-2)}
            </div>
        )
    }

    return (
        <div className={'col-2 offset-1 card'} >
            <div className={'row'} style={{margin: "0 -15px"}}>
                {times}
            </div>
        </div>
    )
}

TimeDisplayColumn.propTypes = {
    content: PropTypes.object.isRequired,
}

TimeDisplayColumn.defaultProps = {}
