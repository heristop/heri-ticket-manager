Ext.define('Ticket.view.message.Show', {
    extend: 'Ext.Panel',
    alias: 'widget.messageshow',
    
    constructor: function(cfg, message) {
        var me = this;
        
        me.message = message;
        
        cfg = cfg || {};
        me.callParent([Ext.apply({

            border: false,
            margin: '',
            padding: '',
            layout: {
                type: 'border'
            },
            flex: 1,
            margins: '',
            listeners: {
                beforerender: function(self) {
                    
                }
            },
            
            dockedItems: [
                {
                    xtype: 'toolbar',
                    dock: 'top',
                    border: false,
                    items: [
                        Ext.create('Ext.Action', {
                            iconCls: 'icon-action-reopen',
                            text: 'Open',
                            id: 'open-button-'+me.message.Id,
                            disabled: (me.message.Status == "opened") ? true : false,
                            handler: me.onReopenAction
                        }),
                        Ext.create('Ext.Action', {
                            iconCls: 'icon-action-close',
                            text: 'Close',
                            id: 'close-button-'+me.message.Id,
                            disabled: (me.message.Status == "closed") ? true : false,
                            handler: me.onCloseAction
                        }),
                        '-',
                        Ext.create('Ext.button.Split', {
                            text: 'Edit priority',
                            iconCls: 'icon-action-priority',
                            menu : {
                                id: 'menu-priority-'+me.message.Id,
                                items: [
                                    {
                                        text: 'Low',
                                        disabled: (me.message.Priority == "low") ? true : false,
                                        priorityId: 1,
                                        handler: me.onPriorityAction
                                    },
                                    {
                                        text: 'Normal',
                                        disabled: (me.message.Priority == "normal") ? true : false,
                                        priorityId: 2,
                                        handler: me.onPriorityAction
                                    },
                                    {
                                        text: 'High',
                                        disabled: (me.message.Priority == "high") ? true : false,
                                        priorityId: 3,
                                        handler: me.onPriorityAction
                                    },
                                    {
                                        text: 'Emergency',
                                        disabled: (me.message.Priority == "emergency") ? true : false,
                                        priorityId: 4,
                                        handler: me.onPriorityAction
                                    },
                                    '-',
                                    {
                                        text: 'Overdue',
                                        iconCls: 'icon-action-duedate',
                                        menu: Ext.create('Ext.menu.DatePicker', {

                                        })
                                    }
                                ]
                            }
                        }),
                        '-',
                        Ext.create('Ext.Action', {
                            iconCls: 'icon-action-delete',
                            text: 'Delete',
                            disabled: true,
                            handler: me.onDeleteAction
                        })
                    ]
                }
            ],
            
            items: [
                {
                    region: 'north',
                    split: true,
                    collapsible: true,
                    hideCollapseTool: true,
                    titleCollapse: true,
                    collapseMode: 'mini',
                    autoScroll: true,
                    border: false,
                    height: 300,
                    bodyPadding: 4,
                    layout: {
                        align: 'stretch',
                        pack: 'start',
                        autoSize: true,
                        type: 'hbox'
                    },
                    items: [
                        {
                            xtype: 'panel',
                            title: 'Ticket Detail',
                            bodyPadding: '10 5 3 10',
                            margins: '0 2 0 0',
                            flex: 1,
                            layout: {
                                align: 'stretch',
                                padding: '',
                                type: 'hbox'
                            },
                            items: [
                                {
                                    xtype: 'panel',
                                    border: false,
                                    flex: 4,
                                    autoScroll: false,
                                    minWidth: 450,
                                    defaults: {
                                        anchor: '100%',
                                        labelSeparator: ':',
                                        labelAlign: 'left',
                                        hideEmptyLabel: true,
                                        labelWidth: 150
                                    },
                                    items: [
                                        {
                                            xtype: 'displayfield',
                                            value: '#'+me.message.Id,
                                            fieldLabel: 'Reference'
                                        },
                                        {
                                            xtype: 'displayfield',
                                            value: me.message.Status,
                                            fieldLabel: 'Status',
                                            renderer: function(value) {
                                                return '<span class="bold">'+value+'</span>';
                                            }
                                        },
                                        {
                                            xtype: 'displayfield',
                                            value: me.message.Priority,
                                            fieldLabel: 'Priority'
                                        },
                                        {
                                            xtype: 'displayfield',
                                            value: Ext.Date.format(me.message.CreationDate, 'j M Y H:i:s'),
                                            fieldLabel: 'Date creation'
                                        },
                                        {
                                            xtype: 'displayfield',
                                            value: me.message.Subject,
                                            fieldLabel: 'Subject'
                                        },
                                        {
                                            xtype: 'displayfield',
                                            value: me.message.Email,
                                            fieldLabel: 'Email'
                                        },
                                        {
                                            xtype: 'displayfield',
                                            value: "" != me.message.Phone ? me.message.Phone : 'not specified',
                                            fieldLabel: 'Phone'
                                        },
                                        {
                                            xtype: 'displayfield',
                                            value: me.message.Source,
                                            fieldLabel: 'Source'
                                        }
                                    ]
                                },
                            ]
                        }
                    ]
                },
                {
                    border: false,
                    region: 'center',
                    layout:  {
                        type: 'border'
                    },
                    title: 'Comments',
                    iconCls: 'icon-comments',
                    tools: [
                        {
                            xtype: 'tool',
                            type: 'refresh',
                            handler: function() {

                            }
                        }
                    ],
                    items: [
                        {
                            xtype: 'panel',
                            border: false,
                            region: 'center',
                            layout:  {
                                type: 'vbox',
                                align: 'stretch',
                                pack: 'start',
                                autoSize: true
                            },
                            flex: 1,
                            items: [

                            ]
                        }
                    ]
                }
            ]
            
        }, cfg)]);
    },
    
    onReopenAction: function() {
        var me = this.findParentByType('panel');
        Ext.MessageBox.confirm('Reopen', 'Are you sure to reopen this ticket?', function (btn) {
            if ("yes" == btn) {

            }
        });
    },
    
    onCloseAction: function() {
        var me = this.findParentByType('panel');
    },
    
    onPriorityAction: function(item) {
        var me = this
            .findParentByType('panel')
            .findParentByType('panel');
    },
    
    onDeleteAction: function() {
        var me = this.findParentByType('panel');
        Ext.MessageBox.confirm('Delete', 'Are you sure to delete this ticket ?', function (btn) {
            if ("yes" == btn) {

            }
        });
    }
    
});