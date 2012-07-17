var Cookie = {
    all: function() {
        var pairs = document.cookie.split(';');
        var cookies = {};
        pairs.each(function(item, index) {
            var pair = item.strip().split('=');
            cookies[unescape(pair[0])] = unescape(pair[1]);
        });

        return cookies;
    },
    read: function(cookieName) {
        var cookies = this.all();
        if(cookies[cookieName]) {
            return cookies[cookieName];
        }
        return null;
    },
    write: function(cookieName, cookieValue, cookieLifeTime) {
        var expires = '';
        if (cookieLifeTime) {
            var date = new Date();
            date.setTime(date.getTime()+(cookieLifeTime*1000));
            expires = '; expires='+date.toGMTString();
        }
        var urlPath = '/';
        document.cookie = escape(cookieName) + "=" + escape(cookieValue) + expires + "; path=" + urlPath;
    },
    clear: function(cookieName) {
        this.write(cookieName, '', -1);
    }
};

jQuery.noConflict();

jQuery(document).ready(function(){

  if (Cookie.read("mgt-developertoolbar") == 0)    {
      jQuery("#mgt-developer-toolbar").hide();  
      jQuery("#mgt-developer-toolbar-powered-by").hide();  
  }

  jQuery("#mgt-developer-toolbar-container img:first").click(function() {
    jQuery(".mgt-developer-toolbar-details").hide();
    jQuery("#mgt-developer-toolbar").toggle();
    jQuery("#mgt-develope-toolbar-powered-by").toggle();
    var display = jQuery("#mgt-developer-toolbar").attr("style");
    var toolbarHiddenExpression = /(none)/;
    if (toolbarHiddenExpression.exec(display)) {
      Cookie.write("mgt-developertoolbar", 0);
    } else {
      Cookie.write("mgt-developertoolbar", 1);    
    }
  });    
  
  jQuery("ul.mgt-tab-container li").click(function() {
    var id = jQuery(this).attr("id").split("_");
    id = id[1];
    var parent = jQuery(this).parent().parent();
    parentContainerId = jQuery(parent).attr("id");
    jQuery("#"+parentContainerId+ " ul.mgt-tab-container li").removeClass("active");
    jQuery(this).addClass("active"); 
    var index = jQuery("#"+parentContainerId+ " ul.mgt-tab-container li").index(this);
    jQuery("#"+parentContainerId+ " .tabContent").hide();
    jQuery("#mgt-tab-content-"+id).show();
  });
    
  jQuery("#mgt-developer-toolbar li.content").click(function() {
    var id = jQuery(this).attr("id").split("_");
    id = id[1];
    jQuery(".mgt-developer-toolbar-details").each(function(e) {
      var toolbarDetailContainer = jQuery(".mgt-developer-toolbar-details").get(e);
      if (jQuery(toolbarDetailContainer).attr("id") != "mgt-developer-toolbar-details-"+id) {
        jQuery(toolbarDetailContainer).hide();     
      }
    });
    if (jQuery("#mgt-developer-toolbar-details-"+id)) {
      jQuery("#mgt-developer-toolbar-details-"+id).toggle();    
    }
  });
  
  jQuery("#mgt-tab-content-blocks a.mgt-toggle-block-properties").click(function() {
    jQuery(this).next("ul.mgt-block-properties").toggle(); 
  });
  
  jQuery("#mgt-tab-content-blocks a.mgt-toggle-block-Properties").click(function() {
     jQuery(this).next("ul.mgt-event-properties").toggle(); 
  });
  
  jQuery("#mgt-tab-content-events a.mgt-toggle-block-properties").click(function() {
    jQuery(this).next("ul.mgt-events").toggle(); 
});
  
});

