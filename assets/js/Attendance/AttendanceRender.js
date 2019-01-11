'use strict';

import React from "react"
import PropTypes from 'prop-types'
import {translateMessage} from '../Component/MessageTranslator'
import Messages from '../Component/Messages/Messages'
import {format} from 'date-fns/esm'
import { Form, FormGroup, Label, Input } from 'reactstrap'
import 'bootstrap/dist/css/bootstrap.min.css'

export default function AttendanceRender(props) {
    const {
        messages,
        attendance,
        translations,
        gibbonHost,
        takeStudentAttendance,
        loadEvents,
    } = props

    if (loadEvents){
        return (
            <div className={'container-fluid timetable'}>
                <div className={'row border-bottom'}>
                    <div className="col-12">
                        <p className="text-lg-left text-uppercase">{translateMessage(translations, "Take Attendance")}</p>
                    </div>
                </div>
                <Messages messages={messages}/>
                <div className={'row'}>
                    <div className="col-12">
                        <div className="progress" title={translateMessage(translations, 'Loading')}>
                            <div className="progress-bar progress-bar-striped bg-success progress-bar-animated"
                                 role="progressbar" style={{width: "100%"}}
                                 aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        )
    }


    const onDate = new Date(attendance.date.date)
    const hostName = window.location.protocol + '//' + window.location.hostname
    const students = Object.keys(attendance.students).map(key => {
        const student = attendance.students[key]

        let image = 'build/static/DefaultPerson.png'
        if (student.person.photo === 'build/static/DefaultPerson.png') {
            image = hostName + '/' + student.person.photo
        } else {
            image = gibbonHost + '/' + student.person.photo
        }

        return (
            <div className={'row border-bottom'} key={'student_'+key}>
                <div className="col-2 text-center">
                    <img style={{height: '4rem'}} src={image} title={student.name} />
                </div>
                <div className="col-5">
                    {student.person.name}
                    <input type={'hidden'} name={'attendance[id][' + key + ']'} id={'attendance_id_'+ key} value={key} />
                </div>
                <div className="col-5">
                    <FormGroup>
                        <Input
                            type="select"
                            name={'attendance[code][' + key + ']'}
                            id={'attendance_code_'+ key}
                            value={student.attendance.code}
                            className={'form-control'}
                            onChange={(event) => takeStudentAttendance(event,student)}
                        >
                            {attendanceCodeOptions()}
                        </Input>
                    </FormGroup>
                </div>
            </div>

        )
    })

    function attendanceCodeOptions() {
        return Object.keys(attendance.codes).map(key => {
            const code = attendance.codes[key]
            return (
                <option key={code.id} value={code.id}>{code.name}</option>
            )
        })
    }

    if (attendance.type === 'courseClass') {
        return (
            <div className={'container-fluid timetable'}>
                <div className={'row border-bottom'}>
                    <div className="col-12">
                        <p className="text-lg-left text-uppercase">{translateMessage(translations, "Take Attendance")}: {attendance.courseClass.course.name}.{attendance.courseClass.name} {translateMessage(translations, 'on')} {format(onDate, 'E, do MMM/yyyy')}</p>
                    </div>
                </div>
                <Messages messages={messages}/>
                {students}
            </div>
        )
    }
}

AttendanceRender.propTypes = {
    messages: PropTypes.array,
    gibbonHost: PropTypes.string,
    translations: PropTypes.object.isRequired,
    attendance: PropTypes.object.isRequired,
    takeStudentAttendance: PropTypes.func.isRequired,
    loadEvents: PropTypes.bool.isRequired,
}

AttendanceRender.defaultProps = {
    messages: [],
}
