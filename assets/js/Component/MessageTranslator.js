'use strict';

export function translateMessage(translations, messageId, parameters = {}) {
    if (messageId in translations) {
        var message = translations[messageId]
        for (let elem in parameters) {
            message = message.replace(elem, parameters[elem] + '')
        }
        return message
    } else {
        for (let elem in parameters) {
            console.log(elem,parameters)
            messageId = messageId.replace(elem, parameters[elem] + '')
        }
    }

    return messageId
}
