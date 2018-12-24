'use strict';

import React from "react"
import PropTypes from 'prop-types'
import "bootstrap/scss/bootstrap.scss";
import "bootstrap/scss/bootstrap-grid.scss";
import "bootstrap/dist/js/bootstrap.bundle";
import '../../css/Form/form.scss';
import ToggleType from './ToggleType'
import RenderFormGroup from './RenderFormGroup'
import ExpandedChoiceType from './ExpandedChoiceType'
import {translateMessage} from '../Component/MessageTranslator'

export default function FormTypes(props) {
    const {
        form,
        style,
        elementChange,
        getElementData,
        ...otherProps
    } = props

    let element = {...form}

    let prefix = element.block_prefixes.slice(0).reverse()

    const placeHolder = element.attr && element.attr.placeholder ? element.attr.placeholder : translateMessage(otherProps.translations, 'Enter Text') ;

    const autoComplete = element.attr && element.attr.autocomplete ? element.attr.autocomplete : 'off' ;

    const content = prefix.find(type => {
        if (isFunction(type))
            return type
    })

    if (!content || /^\s*$/.test(content)){
        console.error('No element type found')
        console.log(prefix)
    }

    if (element.errors.length > 0) {
        element.attr.class = typeof element.attr.class !== 'undefined' ? element.attr.class.replace(' has-error', '').replace('has-error', '') + ' has-error' : 'has-error'
    } else {
        element.attr.class = typeof element.attr.class !== 'undefined' ? element.attr.class.replace(' has-error', '').replace('has-error', '') : ''
    }

    switch (content) {
        case 'hillrange_colour':
            return colourType()
        case 'hillrange_toggle':
            return <ToggleType
                {...otherProps}
                element={element}
                style={style}
                value={getElementData(element.id)}
            />
        case 'hidden':
            return hiddenType()
        case 'choice':
            return choiceType()
        case 'text':
            return textType()
        case 'time':
            return timeType()
        case 'password':
            return passwordType()
        default:
            return FormType()
    }

    function isFunction(type) {
        switch (type) {
            case 'hillrange_colour':
            case 'hillrange_toggle':
            case 'hidden':
            case 'choice':
            case 'time':
            case 'password':
            case 'text':
                return true
            default:
                return false
        }
    }

    function passwordType() {
        if (style === 'widget')
            return textTypeWidget('password')
        return RenderFormGroup(textTypeWidget('password'), {}, element)
    }

    function textType() {
        if (style === 'widget')
            return textTypeWidget('text')
        return RenderFormGroup(textTypeWidget('text'), {}, element)
    }

    function textTypeWidget(type){
        return (
            <FormControl
                type={type}
                id={element.id}
                value={getElementData(element.id)}
                placeholder={placeHolder}
                className={typeof element.attr.class === 'string' ? element.attr.class : undefined }
                name={element.full_name}
                label={element.label}
                onChange={((e) => elementChange(e, element.id, 'text'))}
                autoComplete={autoComplete}
            />
        )
    }

    function FormType() {
        if (style === 'widget')
            return FormTypeWidget('text')
        return RenderFormGroup(FormTypeWidget('text'), {}, element)
    }

    function FormTypeWidget(){
        return (
            <FormControl
                type="text"
                value={element.value}
                placeholder={placeHolder}
                onChange={((e) => elementChange(e, element.id, 'form'))}
                className={typeof element.attr.class === 'string' ? element.attr.class : undefined }
                autoComplete={autoComplete}
            />
        )
    }

    function timeType() {
        if (style === 'widget')
            return timeTypeWidget()
        return RenderFormGroup(timeTypeWidget(), {}, element)
    }

    function timeTypeWidget(){
        let hour = element.children[0]

        let minute = undefined
        if (element.with_minutes)
            minute = element.children[1]

        let second = undefined
        if (element.with_seconds)
            second = element.children[2]

        return (
            <div id={element.id} onChange={((e) => elementChange(e, element.id, 'time'))} className={'form-inline' + (typeof element.attr.class === 'undefined' ? '' : ' ' + element.attr.class)}>
                <FormControl
                    componentClass="select"
                    id={hour.id}
                    value={getElementData(hour.id)}
                    className={typeof element.attr.class === 'string' ? element.attr.class : undefined }
                    time-type={'hour'}
                    autoComplete={autoComplete}
                    onChange={((e) => elementChange(e, 'ignore_me'))}
                >
                    {
                        hour.choices.map((option, index) => {
                            return (<option key={index} value={option.value}>{option.label}</option>)
                        })
                    }

                </FormControl>
                { element.with_minutes ? <div>:
                    <FormControl
                        componentClass="select"
                        id={minute.id}
                        value={getElementData(minute.id)}
                        time-type={'minute'}
                        className={typeof element.attr.class === 'string' ? element.attr.class : undefined }
                        autoComplete={autoComplete}
                        onChange={((e) => elementChange(e, 'ignore_me'))}
                    >
                        {
                            minute.choices.map((option, index) => {
                                return (<option key={index} value={option.value}>{option.label}</option>)
                            })
                        }

                    </FormControl>
                    { element.with_seconds ?
                        <div>:<FormControl
                            componentClass="select"
                            id={second.id}
                            value={getElementData(second.id)}
                            time-type={'second'}
                            className={typeof element.attr.class === 'string' ? element.attr.class : undefined }
                            autoComplete={autoComplete}
                            onChange={((e) => elementChange(e, 'ignore_me'))}
                        >
                            {
                                second.choices.map((option, index) => {
                                    return (<option key={index} value={option.value}>{option.label}</option>)
                                })
                            }

                        </FormControl></div>
                    : ''
                    } </div> : '' }
            </div>
        )
    }

    function choiceType() {
        if (style === 'widget')
            return choiceTypeWidget()
        return RenderFormGroup(choiceTypeWidget(), {}, element)
    }

    function getChoiceList(multiple){
        let placeholder = []
        if (!(!element.placeholder || /^\s*$/.test(element.placeholder)))
        {
            placeholder = [(<option key={'placeholder'} value={''}>{element.placeholder}</option>)]
        }
        let choices = []
        if (typeof element.choices === 'object')
            choices = Object.keys(element.choices).map(index => {
                const option = element.choices[index]
                if (multiple)
                    return (<option key={index} value={option.value} onClick={((e) => elementChange(e, element.id, 'choice'))}>{option.label}</option>)
                return (<option key={index} value={option.value}>{option.label}</option>)
            })
        else
            choices = element.choices.map((option, index) => {
                if (multiple)
                    return (<option key={index} value={option.value} onClick={((e) => elementChange(e, element.id, 'choice'))}>{option.label}</option>)
                return (<option key={index} value={option.value}>{option.label}</option>)
            })
        return [...placeholder, ...choices]
    }

    function choiceTypeWidget(){
        if (element.multiple === true) {
            if (element.expanded)
                return (<ExpandedChoiceType {...otherProps} element={element} elementChange={elementChange} />)
            else
                return (
                    <FormControl
                        componentClass="select"
                        value={getElementData(element.id)}
                        multiple={true}
                        className={typeof element.attr.class === 'string' ? element.attr.class : undefined}
                        autoComplete={autoComplete}
                        onChange={((e) => elementChange(e, 'ignore_me', 'choice'))}
                    >
                        {getChoiceList(true)}
                    </FormControl>
                )
            } else {
                return (
                    <FormControl
                        componentClass="select"
                        value={getElementData(element.id)}
                        multiple={false}
                        className={typeof element.attr.class === 'string' ? element.attr.class : undefined}
                        autoComplete={autoComplete}
                        onChange={((e) => elementChange(e, element.id, 'choice'))}
                    >
                        {getChoiceList(false)}
                    </FormControl>
                )
            }
    }

    function hiddenType() {
        return textTypeWidget('hidden')
    }

    function colourType() {
        if (style === 'widget')
            return textTypeWidget('color')
        return RenderFormGroup(textTypeWidget('color'), {}, element)
    }
}

FormTypes.propTypes = {
    elementChange: PropTypes.func.isRequired,
    getElementData: PropTypes.func.isRequired,
    form: PropTypes.object.isRequired,
    style: PropTypes.string.isRequired,
}



