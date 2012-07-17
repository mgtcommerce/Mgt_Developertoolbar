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

  if (Cookie.read("wee_developertoolbar") == 0)    {
      jQuery("#weeDeveloperToolbar").hide();  
      jQuery("#weeDeveloperToolbarPoweredBy").hide();  
  }

  jQuery("#weeDeveloperToolbarContainer img:first").click(function() {
    jQuery(".weeDeveloperToolbarDetails").hide();
    jQuery("#weeDeveloperToolbar").toggle();
    jQuery("#weeDeveloperToolbarPoweredBy").toggle();
    var display = jQuery("#weeDeveloperToolbar").attr("style");
    var toolbarHiddenExpression = /(none)/;
    if (toolbarHiddenExpression.exec(display)) {
      Cookie.write("wee_developertoolbar", 0);
    } else {
      Cookie.write("wee_developertoolbar", 1);    
    }
  });    
  
  jQuery("ul.tabContainer li").click(function() {
    var id = jQuery(this).attr("id").split("_");
    id = id[1];
    var parent = jQuery(this).parent().parent();
    parentContainerId = jQuery(parent).attr("id");
    jQuery("#"+parentContainerId+ " ul.tabContainer li").removeClass("active");
    jQuery(this).addClass("active"); 
    var index = jQuery("#"+parentContainerId+ " ul.tabContainer li").index(this);
    jQuery("#"+parentContainerId+ " .tabContent").hide();
    jQuery("#tabContent_"+id).show();
  });
    
  jQuery("#weeDeveloperToolbar li.content").click(function() {
    var id = jQuery(this).attr("id").split("_");
    id = id[1];
    jQuery(".weeDeveloperToolbarDetails").each(function(e) {
      var toolbarDetailContainer = jQuery(".weeDeveloperToolbarDetails").get(e);
      if (jQuery(toolbarDetailContainer).attr("id") != "weeDeveloperToolbarDetails_"+id) {
        jQuery(toolbarDetailContainer).hide();     
      }
    });
    if (jQuery("#weeDeveloperToolbarDetails_"+id)) {
      jQuery("#weeDeveloperToolbarDetails_"+id).toggle();    
    }
  });
  
  jQuery("#tabContent_blocks a.toggleBlogProperties").click(function() {
    jQuery(this).next("ul.blockProperties").toggle(); 
  });
  
  jQuery("#tabContent_blocks a.toggleBlogProperties").click(function() {
	    jQuery(this).next("ul.eventProperties").toggle(); 
  });
  
  jQuery("#tabContent_events a.toggleBlogProperties").click(function() {
	    jQuery(this).next("ul.events").toggle(); 
});
  
});

