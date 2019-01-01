'use strict';

import React from "react"
import PropTypes from 'prop-types'
import "bootstrap/scss/bootstrap.scss";
import "bootstrap/scss/bootstrap-grid.scss";
import {translateMessage} from '../Component/MessageTranslator'
import { Tooltip } from 'reactstrap';
import { getTimeString } from '../Component/getTimeString'

export default function DisplayPeriod(props) {
    const {
        period,
        translations,
        today,
        toggleTooltip,
        tooltipOpen,
        ...otherProps
    } = props


    const start = new Date(period.timeStart.date)
    const end = new Date(period.timeEnd.date)
    const minutes = (end - start) / 60000

    let size = 0
    let content = []
    let title = []

    if (size + 15 >= minutes)
        title.push((<p className={'text-center'} key={'name_' + period.id}>{period.name}</p>))
    else
        content.push((<p className={'text-center text-truncate'} key={'name_' + period.id}>{period.name}</p>))
    size += 15

    let startTime = new Date(period.timeStart.date)
    let endTime = new Date(period.timeEnd.date)
    const time = getTimeString(startTime) + ' - ' + getTimeString(endTime)
    if (size + 15 >= minutes)
        title.push((<p className={'font-italic text-center'} key={'time_' + period.id}>{time}</p>))
    else
        content.push((<p className={'font-italic text-center text-truncate'} key={'time_' + period.id}>{time}</p>))
    size += 15

    let periodClass = ''

    if (typeof(period.TTDayRowClasses) !== 'undefined')
    {
        const classDetails = period.TTDayRowClasses[0]
        if (size + 15 >= minutes)
            title.push(<p className={'text-center period-class-name'} key={'className_' + period.id}>{getNameShort(classDetails)}</p>)
        else
            content.push((<p className={'text-center period-class-name text-truncate'} key={'className_' + period.id}>{getNameShort(classDetails)}</p>))
        size += 15

        if (size + 15 >= minutes)
            title.push((<p className={'text-center'} key={'facility_' + period.id}>{getSpaceName(classDetails)}</p>))
        else
            content.push((<p className={'text-center text-truncate'} key={'facility_' + period.id}>{getSpaceName(classDetails)}</p>))
        size += 15

        if (size + 15 >= minutes && getPhoneNumber(translations, classDetails) !== null)
            title.push((<p className={'text-center'} key={'phone_' + period.id}>{getPhoneNumber(translations, classDetails)}</p>))
        else
            content.push((<p className={'text-center text-truncate'} key={'phone_' + period.id}>{getPhoneNumber(translations, classDetails)}</p>))
        size += 15
        periodClass += ' period-class'
    }

    if (today) {
        let now = new Date()
        now = ('0' + now.getHours()).slice(-2) + ':' + ('0' + now.getMinutes()).slice(-2) + ':00'
        if (period.timeStart <= now && period.timeEnd > now)
            periodClass += ' period-now'
    }

    if (title.length > 0) {
        const isOpen = tooltipOpen.hasOwnProperty('period' + period.id) ? tooltipOpen['period' + period.id] : false
        return (
            <div className={'period' + periodClass} style={{height: (minutes + 1) + 'px'}} id={'period' + period.id}>
                {content}
                <Tooltip target={'period' + period.id} className={'timetable-tooltip'} placement={'top'} isOpen={isOpen} toggle={() => toggleTooltip('period' + period.id)} >
                    {title}
                </Tooltip>
            </div>
        )
    } else
        return (
            <div className={'period' + periodClass} style={{height: (minutes + 1) + 'px'}}>
                {content}
            </div>
        )

}

DisplayPeriod.propTypes = {
    period: PropTypes.object.isRequired,
    translations: PropTypes.object.isRequired,
    today: PropTypes.bool.isRequired,
    toggleTooltip: PropTypes.func.isRequired,
    tooltipOpen: PropTypes.object.isRequired,
}

DisplayPeriod.defaultProps = {}

function getNameShort(details)
{
    return details.courseClass.course.nameShort + '.' + details.courseClass.nameShort
}

function getSpaceName(details)
{
    return details.space.name
}

function getPhoneNumber(translations, details)
{
    return  translateMessage(translations, 'Phone') + ': ' + details.space.phoneInt
}


