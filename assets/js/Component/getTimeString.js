'use strict';

export function getTimeString(date)
{
    if (typeof(date) === 'string')
        date = new Date(date)
    return ('0' + (date.getHours())).slice(-2) + ':' + ('0' + date.getMinutes()).slice(-2)
}
