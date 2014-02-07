Ext.define('Ticket.view.message.List', {
    extend: 'Ticket.view.ListPanel',
    alias: 'widget.messagelist',
    
    initComponent: function() {
        var me = this;
        
        me.callParent(Ext.applyIf(me, {
            
            store: 'Messages',
            
            border: false,
            columns: [
                {
                    xtype: 'gridcolumn',
                    dataIndex: 'Id',
                    text: 'Ticket Id',
                    filterable: true,
                    hidden: true
                },
                {
                    xtype: 'gridcolumn',
                    dataIndex: 'Subject',
                    text: 'Subject',
                    width: 300,
                    filterable: true
                },
                {
                    xtype: 'gridcolumn',
                    dataIndex: 'Email',
                    text: 'Email',
                    width: 200,
                    filterable: true
                },
                {
                    xtype: 'gridcolumn',
                    dataIndex: 'Status',
                    text: 'Status',
                    filterable: true,
                    filter: {
                        type: 'list',
                        options: ['opened', 'assigned', 'closed'],
                        phpMode: true
                    }
                },
                {
                    xtype: 'gridcolumn',
                    dataIndex: 'Priority',
                    text: 'Priority',
                    filterable: false,
                    searchable: false,
                    sortable: false
                },
                {
                    xtype: 'gridcolumn',
                    dataIndex: 'Source',
                    text: 'Source',
                    filterable: true,
                    searchable: false,
                    filter: {
                        type: 'list',
                        options: ['web', 'email', 'phone', 'other'],
                        phpMode: true
                    }
                },
                {
                    xtype: 'datecolumn',
                    dataIndex: 'OverdueDate',
                    text: 'Due date',
                    format: "d/m/Y",
                    filterable: true,
                    searchable: false
                },
                {
                    xtype: 'datecolumn',
                    dataIndex: 'CreationDate',
                    text: 'Date creation',
                    format: "d/m/Y H:i:s",
                    filterable: true,
                    searchable: false
                },
                {
                    xtype: 'datecolumn',
                    dataIndex: 'ModificationDate',
                    text: 'Date modification',
                    hidden: true,
                    format: "d/m/Y H:i:s",
                    filterable: true,
                    searchable: false
                }
            ]
            
        }));
        
    },
    
    showRecord: function(record) {
        var tabId = 'tab-message-'+record.data.Id;
        var tabPanel = Ext.getCmp(tabId);
        
        if (undefined !== tabPanel) {
            tabPanel.show();
        } else {
            tabPanel = this.
                findParentByType('tabpanel').
                findParentByType('tabpanel')
            ;
            if (undefined == tabPanel) {
                tabPanel = this.findParentByType('tabpanel');
            }
            
            tabPanel.add(
                {
                    id: tabId,
                    title: 'Ticket #'+record.data.Id,
                    iconCls: 'icon-ticket-show',
                    flex: 1,
                    layout: 'border',
                    layoutConfig: {
                        align: 'stretch',
                        pack: 'start'
                    },
                    collapsible: true,
                    items: [
                        Ext.create('Ticket.view.message.Show', {
                            region: 'center',
                            message: record.data
                        }, record.data)
                    ],
                    closable: true
                }
            ).show();
        }
    }
    
});