'use strict';

import React from "react"
import PropTypes from 'prop-types'
import {translateMessage} from '../Component/MessageTranslator'
import Messages from '../Component/Messages/Messages'
import {format} from 'date-fns/esm'
import { FormGroup, Input } from 'reactstrap'
import 'bootstrap/dist/css/bootstrap.min.css'
import ButtonSubmit from '../Component/Button/ButtonSubmit'

export default function AttendanceRender(props) {
    const {
        attendance,
        translations,
        gibbonHost,
        takeStudentAttendance,
        loadEvents,
        ...otherProps
    } = props

    if (loadEvents){
        return (
            <div className={'container-fluid timetable'}>
                <div className={'row border-bottom'}>
                    <div className="col-12">
                        <p className="text-lg-left text-uppercase">{translateMessage(translations, "Take Attendance")}</p>
                    </div>
                </div>
                <Messages {...otherProps} translations={translations}/>
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
    const colours = {
        '1': 'alert-light',
        '2': 'alert-primary',
        '3': 'alert-warning',
        '4': 'alert-danger',
        '5': 'alert-danger',
        '6': 'alert-danger',
    }

    const students = Object.keys(attendance.students).map(key => {
        const student = attendance.students[key]
        let image = 'build/static/DefaultPerson.png'
        if (student.photo === 'build/static/DefaultPerson.png') {
            image = hostName + '/' + student.photo
        } else {
            image = gibbonHost + '/' + student.photo
        }

        return (
            <div className={'row border-bottom ' + colours[student.attendanceCode] } key={'student_' + student.id}>
                <div className="col-2 text-center">
                    <img style={{height: '4rem'}} src={image} title={student.name} />
                </div>
                <div className="col-5">
                    {student.name}
                    <input type={'hidden'} name={'attendance[id][' + student.id + ']'} id={'attendance_id_'+ key} value={student.id} />
                </div>
                <div className="col-5">
                    <FormGroup>
                        <Input
                            type="select"
                            name={'attendance[code][' + student.id + ']'}
                            id={'attendance_code_'+ student.id}
                            value={student.attendanceCode}
                            className={'form-control'}
                            onChange={(event) => takeStudentAttendance(student,event)}
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

    const button = {
        style: {float: 'right'},
        title: translateMessage(translations, 'Take Attendance by Class'),
    }

    if (attendance.type === 'courseClass') {
        return (
            <div className={'container-fluid timetable'}>
                <div className={'row border-bottom'}>
                    <div className="col-12">
                        <p className="text-lg-left text-uppercase">{translateMessage(translations, "Take Attendance by Class")}: {attendance.courseClass.course.name}.{attendance.courseClass.name} {translateMessage(translations, 'on')} {format(onDate, 'E, do MMM/yyyy')}
                            <ButtonSubmit button={button} submitButtonHandler={takeStudentAttendance}/>
                        </p>
                    </div>
                </div>
                <Messages {...otherProps} translations={translations}/>
                {students}
            </div>
        )
    }
    if (attendance.type === 'rollGroup') {
        return (
            <div className={'container-fluid timetable'}>
                <div className={'row border-bottom'}>
                    <div className="col-12">
                        <p className="text-lg-left text-uppercase">{translateMessage(translations, "Take Attendance by Roll Group")}: {attendance.rollGroup.name} {translateMessage(translations, 'on')} {format(onDate, 'E, do MMM/yyyy')}
                            <ButtonSubmit button={button} submitButtonHandler={takeStudentAttendance}/>
                        </p>
                    </div>
                </div>
                <Messages {...otherProps} translations={translations}/>
                {students}
            </div>
        )
    }
}

AttendanceRender.propTypes = {
    gibbonHost: PropTypes.string,
    translations: PropTypes.object.isRequired,
    attendance: PropTypes.object.isRequired,
    takeStudentAttendance: PropTypes.func.isRequired,
    loadEvents: PropTypes.bool.isRequired,
}

AttendanceRender.defaultProps = {
    messages: [],
}
