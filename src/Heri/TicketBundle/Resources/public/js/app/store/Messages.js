/**
 * This file is part of HeriTicketBundle.
 *
 */

Ext.define('Ticket.store.Messages', {
    extend: 'Ext.data.Store',

    constructor: function(cfg) {
        var me = this;
        
        cfg = cfg || {};
        me.callParent([Ext.apply({
            autoDestroy: true,
            model: 'Ticket.model.Message',
            proxy: {
                type: 'ajax',
                url: '/message/list',
                reader: {
                    type: 'json',
                    root: 'results',
                    totalProperty: 'totalCount',
                    successProperty: 'success'
                }
            },
            sorters: [
                {
                    property : 'CreationDate',
                    direction: 'DESC'
                }
            ],
            listeners: {
                load: function(records, operation, success) {
                    if (false === success) {
                        Ext.MessageBox.alert('Status', 'The server returned an error.');
                    }
                }
            }
        }, cfg)]);
    }
});