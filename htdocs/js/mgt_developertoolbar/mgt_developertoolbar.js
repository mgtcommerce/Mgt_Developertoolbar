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
    jQuery("#mgt-developer-toolbar-powered-by").toggle();
    var display = jQuery("#mgt-developer-toolbar").attr("style");
    var toolbarHiddenExpression = /(none)/;
    if (toolbarHiddenExpression.exec(display)) {
      Cookie.write("mgt-developertoolbar", 0);
    } else {
      Cookie.write("mgt-developertoolbar", 1);    
    }
  });    
  
  jQuery("#mgt-developer-toolbar li").click(function() {
    var id = jQuery(this).attr("id");
    jQuery("#mgt-developer-toolbar li").removeClass("active");
    jQuery(this).addClass("active"); 
    jQuery(".mgt-developer-toolbar-details").each(function(e) {
      if (jQuery(this).attr("id") != id+"-details") {
        jQuery(this).hide();
      }
    });
    jQuery("#"+id+"-details").toggle();
  });
  
  jQuery("ul.mgt-developer-toolbar-tab-container li").click(function() {
    var id = jQuery(this).attr("id");
    jQuery("ul.mgt-developer-toolbar-tab-container li").removeClass("active"); 
    jQuery(this).addClass("active"); 
    jQuery(".mgt-developer-toolbar-tab-content").hide();
    jQuery("#"+id+"-content").show();
  });

  jQuery("#mgt-developer-toolbar-tab-blocks-content a.mgt-developer-toolbar-toggle-block-properties").click(function() {
    jQuery(this).next("ul.mgt-developer-toolbar-block-properties").toggle(); 
  });
  
  jQuery("#mgt-developer-toolbar-tab-blocks-content a.mgt-developer-toolbar-toggle-block-properties").click(function() {
     jQuery(this).next("ul.mgt-developer-toolbar-event-properties").toggle(); 
  });
  
  jQuery("#mgt-developer-toolbar-tab-events-content a.mgt-developer-toolbar-toggle-block-properties").click(function() {
    jQuery(this).next("ul.mgt-developer-toolbar-events").toggle(); 
});
  
});

