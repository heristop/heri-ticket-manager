/**
 * This file is part of HeriTicketBundle.
 *
 */

Ext.define('Ticket.model.Message', {
    extend: 'Ext.data.Model',
    fields: [
        {
            name: 'Id',
            type: 'int'
        },
        {
            name: 'Subject',
            type: 'string'
        },
        {
            name: 'Email',
            type: 'string'
        },
        {
            name: 'Status',
            type: 'string'
        },
        {
            name: 'Source',
            type: 'string'
        },
        {
            name: 'Priority',
            type: 'string'
        },
        {
            name: 'OverdueDate',
            type: 'date',
            dateFormat: 'timestamp'
        },
        {
            name: 'CreationDate',
            type: 'date',
            dateFormat: 'timestamp'
        },
        {
            name: 'ModificationDate',
            type: 'date',
            dateFormat: 'timestamp'
        }
    ]
});