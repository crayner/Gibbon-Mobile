'use strict';

import React from "react"
import PropTypes from 'prop-types'
import Messages from '../Component/Messages/Messages'
import FormRenderTabs from './FormRenderTabs'
import FormContainer from './FormContainer'

export default function FormRender(props) {
    const {
        template,
        form,
        ...otherProps
    } = props

    if (template.container !== false) {
        return (
            <form id={form.block_prefixes[1]} name={form.block_prefixes[1]} method={template.form.method} action={template.form.url} encType={template.form.encType}>
                <div className={'container'} data-craig="1">
                    <Messages
                        {...otherProps}
                    />
                    <FormContainer
                        {...otherProps}
                        form={form}
                        template={template.container}
                    />
                </div>
            </form>
        )
    }

    return (
        <form id={form.block_prefixes[1]} name={form.block_prefixes[1]} method={template.form.method} action={template.form.url} encType={template.form.encType}>
            <div className={'container'} data-craig="2">
                <Messages
                    {...otherProps}
                />
                <FormRenderTabs
                    {...otherProps}
                    form={form}
                    template={template.tabs}
                />
            </div>
        </form>
    )
}

FormRender.propTypes = {
    template: PropTypes.object.isRequired,
    form: PropTypes.object.isRequired,
}
