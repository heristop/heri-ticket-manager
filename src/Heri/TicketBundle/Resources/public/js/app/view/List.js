/**
 * This file is part of HeriTicketBundle.
 *
 * @author Alexandre Mogère
 */

Ext.define('Ticket.view.ListPanel', {
    extend: 'Ext.grid.Panel',

    border: false,
    collapsed: false,
    title: 'List',
    forceFit: true,
    loadMask: true,
    
    initComponent: function() {
        var me = this;

        me.callParent(Ext.applyIf(me, {
            columns: [
                {
                    xtype: 'numbercolumn',
                    dataIndex: 'number',
                    text: 'id'
                }
            ],
            viewConfig: {

            },
            dockedItems: [
                {
                    xtype: 'pagingtoolbar',
                    displayInfo: true,
                    dock: 'bottom',
                    pageSize: 25,
                    store: me.getStore()
                },
                {
                    xtype: 'toolbar',
                    dock: 'top'
                }
            ],
            selModel: Ext.create('Ext.selection.CheckboxModel', {

            }),
            tools: [
                {
                    xtype: 'tool',
                    type: 'refresh',
                    handler: function() {
                        me.getStore().load();
                    }
                }
            ],
            plugins: [
                Ext.create('Ext.ux.GridSearch', {
                    mode: 'store',
                    width: 150,
                    searchText: 'search',
                    selectAllText: 'Select all'
                })
            ],
            features: [
                {
                    ftype: 'filters',
                    local: false,
                    encode: false,
                    menuFilterText: 'Filter'
                }
            ],
            listeners: {
                selectionchange: me.onSelectionChange,
                itemdblclick: function(self, record, item, index, e) {
                    me.showRecord(record);
                },
                itemcontextmenu: me.onContextMenu,
                beforerender: me.onPrepareRender,
                afterrender: me.onViewRender
            }
        }));
        
        me.showBtn = Ext.create('Ext.Action', {
            iconCls: 'icon-tab-go',
            text: 'see detail',
            disabled: true,
            handler: function(widget, event) {
                var records = me.getSelectionModel().getSelection();
                for (var i = 0; i <= records.length-1; i++) {
                    me.showRecord(records[i]);
                }
            }
        });
    },
    
    onSelectionChange: function(sm, selections) {
        var me = this;
        if (selections.length) {
            me.showBtn.enable();
        } else {
            me.showBtn.disable();
        }
    },
    
    onContextMenu: function(self, record, item, index, e) {
        var me = this;
        e.stopEvent();
        var mnuContext = new Ext.menu.Menu(
            {
                items: [
                    me.showBtn
                ]
            }
        );
        mnuContext.showAt(e.xy);
    },
    
    onPrepareRender: function() {
        var me = this;
        
        var toptoolbar = me.getDockedItems('toolbar[dock="top"]');
        toptoolbar[0].add(
            me.showBtn,
            {
                xtype: 'tbfill'
            }
        );
    },
    
    onViewRender: function() {
        var me = this;
        me.keyNav = Ext.create('Ext.util.KeyNav', me.items.getAt(0).el, {
            enter: me.onEnterKey,
            scope: me
        });
        
        me.applyFilter();
    },
    
    onEnterKey: function(e) {
        var me = this,
            view = me.view,
            idx = view.indexOf(view.getSelectedNodes()[0]);

        me.onRowDblClick(view, idx);
    },
    
    /**
     * Show view redirection
     * @protected
     */
    showRecord: function(record) {
 
        console.log('filter',this.filters);
    },
    
    /**
     * Reacts to a double click
     * @private
     * @param {Object} view The view
     * @param {Object} index The row index
     */
    onRowDblClick: function(view, index) {
        this.fireEvent('itemdblclick', this, this.store.getAt(index));
    },
    
    applyFilter: function() {
        var me = this;
        if (undefined !== me.defaultFilter) {
            me.filters.addFilter(me.defaultFilter);
            me.store.load();
        }
    }
    
});