Ext.define('Ext.ux.GridSearch', {

    extend: 'Ext.util.Observable',
    alias: 'plugin.gridsearch',
    requires: [ 'Ext.form.field.VTypes' ],

    searchText: 'Search',
    selectAllText: 'Select all',
    clearIconCls: 'x-form-clear-icon',
    iconCls: 'icon-search',
    width: 100,
    minChars: 2,
    mode: 'local',

    init: function(grid) {
        this.grid = grid;
        grid.on('render', this.onRender, this, {
            single: true
        });
        grid.on('render', this.reconfigure, this, {
            single: true
        });
    },

    onRender: function(grid) {
        var ptb = Ext.ComponentQuery.query('pagingtoolbar', grid)[0];
        var tb = Ext.ComponentQuery.query('toolbar', grid)[0];

        if (tb) {
            this.tb = tb;
        }
        else if (ptb) {
            this.tb = ptb;
        } else {
            grid.addDocked({
                xtype: 'toolbar',
                dock: 'bottom'
            });
            this.tb = Ext.ComponentQuery.query('toolbar', grid)[0];
        }

        if (0 < this.tb.items.getCount()) {
            this.tb.add('-');
        }

        // menu
        this.menu = new Ext.menu.Menu();
        this.tb.add({
            text: this.searchText,
            menu: this.menu,
            iconCls: this.iconCls
        });

        // field
        this.field = new Ext.form.TriggerField({
            width: this.width,
            selectOnFocus: true,
            triggerCls: this.clearIconCls,
            onTriggerClick: this.onTriggerClear(this),
            minLength: this.minChars
        });
        this.field.on('render', function() {
            this.field.el.on({
                scope: this,
                buffer: 700,
                keyup: this.onKeyUp
            });
        }, this, {
            single: true
        });

        this.tb.add(this.field);
    },

    onKeyUp: function(e, t, o) {
        if (!this.field.isValid()) {
            return;
        }

        var val = this.field.getValue();
        var store = this.grid.store;
        if ('local' === this.mode) {
            store.clearFilter();
            if (val) {
                store.filterBy(function(r) {
                    var retval = false;
                    this.menu.items.each(function(item) {
                        if (!item.checked || retval) {
                            return;
                        }
                        var rv = r.get(item.dataIndex);
                        rv = rv instanceof Date ? Ext.Date.format(rv, this.dateFormat || r.fields.get(item.dataIndex).dateFormat): rv;
                        var re = new RegExp(Ext.util.Format.escapeRegex(val), 'gi');
                        retval = re.test(rv);
                    }, this);
                    if (retval) {
                        return true;
                    }
                    return retval;
                }, this);
            }
        } else {
            var fields = [];
            this.menu.items.each(function(item) {
                if (item.checked) {
                    if (item.dataIndex)
                        fields.push(item.dataIndex);
                }
            });
            store.proxy.extraParams = Ext.applyIf({
                fields: Ext.encode(fields),
                query: val
            }, store.proxy.extraParams);
            store.load();
        }
    },

    onTriggerClear: function(el) {
        return function() {
            if (el.field.getValue()) {
                el.field.setValue('');
                el.field.focus();
                el.onKeyUp();
            }
        };
    },

    reconfigure: function(grid) {

        this.menu.add(new Ext.menu.CheckItem({
            text: this.selectAllText,
            checked: !(this.checkIndexes instanceof Array),
            hideOnClick: false,
            handler: function(item) {
                var checked = !item.checked;
                item.parentMenu.items.each(function(i) {
                    if (item !== i && i.setChecked && !i.disabled) {
                        i.setChecked(!checked);
                    }
                });
            }
        }), '-');

        var cm = this.grid.columns;

        Ext.each(cm, function(config) {
            text = config.header || config.text;
            searchable = config.searchable == undefined || config.searchable ? true: false;
            if (text && config.dataIndex && searchable) {
                this.menu.add(new Ext.menu.CheckItem({
                    text: text,
                    hideOnClick: false,
                    dataIndex: config.dataIndex,
                    checked: true
                }));
            }
        }, this);

    }
});