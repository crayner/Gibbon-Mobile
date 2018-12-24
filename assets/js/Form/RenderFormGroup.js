'use strict';

import React from "react"
import "bootstrap/scss/bootstrap.scss";
import "bootstrap/scss/bootstrap-grid.scss";
import "bootstrap/dist/js/bootstrap.bundle";
import FormLabel from './FormLabel'
import FormRequired from './FormRequired'
import FormErrors from './FormErrors'
import FormHelp from './FormHelp'

export default function RenderFormGroup(content, options, element) {
    if (typeof options !== 'object')
        options = {}
    return (
        <FormGroup
            controlId={element.id}
            className={element.errors.length > 0 ? 'has-danger' : ''}
            {...options}
        >
            {content}
            <FormLabel label={element.label}/>
            <FormRequired required={element.required}/><br/>
            <FormErrors errors={element.errors}/>
            <FormHelp help={element.help}/>
        </FormGroup>
    )
}