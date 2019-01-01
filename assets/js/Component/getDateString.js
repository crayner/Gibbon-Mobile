'use strict';

export function getDateString(date)
{
    if (typeof(date) === 'string')
        date = new Date(date)
    return date.getFullYear() + '-' + ('0' + (date.getMonth() + 1)).slice(-2) + '-' + ('0' + date.getDate()).slice(-2)
}
