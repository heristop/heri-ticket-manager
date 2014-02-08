/**
 * This file is part of HeriTicketBundle.
 *
 * @author Alexandre Mogère
 */

Ext.Loader.setConfig({
    enabled: false,
    /*paths: {
        'Ext.ux': '/bundles/heriticket/ext/examples/ux'
    }*/
});

/*Ext.require([
    'Ext.ux.grid.filter.Filter',
    'Ext.ux.grid.filter.DateFilter',
    'Ext.ux.grid.FiltersFeature'
]);*/

Ext.application({
    name: 'Ticket',

    appFolder: 'app',
    
    controllers: [
        'Messages'
    ],

    launch: function() {
        Ext.tip.QuickTipManager.init();
        
        Ext.create('Ext.container.Viewport', {
            
            border: false,
            layout: {
                type: 'border'
            },
            items: [
                {
                    id: 'header-panel',
                    border: false,
                    region: 'north',
                    height: 100,
                    layout: {
                        type: 'border'
                    },
                    items: [
                        
                    ],
                    html: '<h2>Heri Ticket Manager</h2>'
                },
                {
                    border: false,
                    region: 'center',
                    layout: {
                        type: 'border'
                    },
                    items: [
                        {
                            id: 'menu-panel',
                            region: 'west',
                            border: false,
                            frame: true,
                            maxHeight: 500,
                            width: 150,
                            layout: {
                                align: 'stretch',
                                type: 'vbox'
                            },
                            defaults: {
                                margin:'4 4 0 4'
                            },
                            collapsible: true,
                            collapsed: true,
                            hideCollapseTool: true,
                            titleCollapse: true,
                            split: true,
                            /*items: [
                                {
                                    xtype: 'button',
                                    text: 'Tickets List',
                                    qtip: 'Tickets List',
                                },
                                {
                                    xtype: 'button',
                                    text: 'New Ticket',
                                    qtip: 'New Ticket',
                                }
                            ]*/
                        },
                        {
                            id: 'content-panel',
                            border: false,
                            region: 'center',
                            layout: {
                                type: 'card'
                            },
                            margins: '2 5 5 0',
                            items: [
                                {
                                    border: false,
                                    id: 'ticket-panel',
                                    minHeight: 150,
                                    activeTab: 0,
                                    region: 'center',
                                    split: true,
                                    preventHeader: true,
                                    layout: {
                                        type: 'border'
                                    },
                                    listeners: {
                                        beforerender: function(self) {
                                            self.add({
                                                xtype: 'tabpanel',
                                                region: 'center',
                                                layout: {
                                                    type: 'border'
                                                },
                                                border: false,
                                                plugins: [
                                                    
                                                ],
                                                items: [
                                                    {
                                                        xtype: 'messagelist',
                                                        region: 'center',
                                                        title: 'Opened Tickets',
                                                        id: 'ticket-grid',
                                                        iconCls: 'icon-list',
                                                        defaultFilter: {
                                                            dataIndex: 'Status',
                                                            type: 'string',
                                                            value: 'opened'
                                                        }
                                                    }
                                                ]
                                            });
                                        }
                                    }
                                }
                            ]
                        }
                    ]
                }
            ]
        });
    }
});