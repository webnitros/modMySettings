
function thisTab(thisa){

    var el = Ext.get(thisa)
    var id = el.id;

    Ext.get( "con-ms-page-tab").addClass("x-hide-display");
    Ext.get( "con-ms-pack-tab").addClass("x-hide-display");
    Ext.get( "con-ms-settings-tab").addClass("x-hide-display");

    Ext.get( "ms-page-tab").parent().removeClass("x-tab-strip-active");
    Ext.get( "ms-pack-tab").parent().removeClass("x-tab-strip-active");
    Ext.get( "ms-settings-tab").parent().removeClass("x-tab-strip-active");
    var el_action = Ext.get("con-"+id);
    el.parent().addClass("x-tab-strip-active");
    el_action.removeClass("x-hide-display");

}
function thisPlus(thisa){

    var el = Ext.get(thisa);
    var id = el.id;
    var parent = Ext.get('settings_'+id+'');
    var desc = Ext.get('desc_'+id+'');

    console.log(desc);
    if(parent.dom.className == 'x-grid3-row-collapsed'){
        parent.dom.className = 'x-grid3-row-expanded';
        Ext.get('desc_'+id+'').removeClass("msettings-hidden");
    } else {
        parent.dom.className = 'x-grid3-row-collapsed';
        Ext.get('desc_'+id+'').addClass("msettings-hidden");
    }
    /*
    Ext.get( "con-ms-page-tab").addClass("x-hide-display");

    Ext.get( "ms-pack-tab").parent().removeClass("x-grid3-row-collapsed");
    Ext.get( "ms-settings-tab").parent().removeClass("x-tab-strip-active");

    var el_action = Ext.get("con-"+id);
    el.parent().addClass("x-grid3-row-expanded");*/

}





