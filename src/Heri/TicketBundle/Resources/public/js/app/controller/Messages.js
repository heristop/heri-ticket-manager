/**
 * This file is part of HeriTicketBundle.
 *
 * @author Alexandre Mogère
 */

Ext.define('Ticket.controller.Messages', {

    extend: 'Ext.app.Controller',

    models: [
        'Message'
    ],

    stores: [
        'Messages'
    ],

    views: [
        'message.List',
        'message.Show'
    ],

    init: function() {
        var me = this;

        me.control({
            'messagelist': {
                select: me.handleSelectPost
            }
        });
    },

    handleSelectPost: function(that, record, index, e) {
        
    }
    
});