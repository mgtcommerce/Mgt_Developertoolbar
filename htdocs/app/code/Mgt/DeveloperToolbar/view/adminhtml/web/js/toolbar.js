define([
    'jquery',
    'jquery/jquery-storageapi'
], function ($) {
    'use strict';

    var toolbar = $('#mgt-developer-toolbar');
    var toolbarBlocksContainer = $('#mgt-developer-toolbar-blocks');
    
    $.cookieStorage.setConf({path:'/'});

    function toggleToolbar(init) {
        
        var toolbarCookieValue = $.cookieStorage.get('mgt-developer-toolbar');
        var isCollapsible = $(toolbar).attr('data-collapsible');
        
        if (isCollapsible == 1) {
            
            if (init == true) {
              
              if (!toolbarCookieValue) {
                $.cookieStorage.set('mgt-developer-toolbar', 'open');
              }
              
              if (toolbarCookieValue == 'open') {
                  $.cookieStorage.set('mgt-developer-toolbar', 'open');
                  toolbar.css('width', '100%');
                  toolbarBlocksContainer.show();
              } 

              if (toolbarCookieValue == 'closed') {
                  $.cookieStorage.set('mgt-developer-toolbar', 'closed');
                  toolbar.css('width', '50px');
                  toolbarBlocksContainer.hide();
              }
              
            } else {
              if (toolbarCookieValue == 'open') {
                  $.cookieStorage.set('mgt-developer-toolbar', 'closed');
                  toolbar.css('width', '50px');
                  toolbarBlocksContainer.hide();
              } else {
                  $.cookieStorage.set('mgt-developer-toolbar', 'open');
                  toolbar.css('width', '100%');
                  toolbarBlocksContainer.show();
              }
            }
           
            toolbar.show();
        } else {
            $.cookieStorage.set('mgt-developer-toolbar', 'open');
            toolbar.css('width', '100%');
            toolbarBlocksContainer.show();
            toolbar.show();
        }
    }

    toggleToolbar(true);
    
    $('.mgt-developer-toolbar-logo').on("click","img", function (e) {
        e.preventDefault();
        toggleToolbar(false);
    });
    
    $('#mgt-developer-toolbar-blocks .mgt-developer-toolbar-block').on("mouseover", function () {
        $('.mgt-developer-toolbar-block-information').hide();
        var toolbarBlockInformation = $('.mgt-developer-toolbar-block-information').get($(this).index());
        $(toolbarBlockInformation).show();
    });
    
    $('#mgt-developer-toolbar').on("mouseout", function () {
        $(".mgt-developer-toolbar-block-information").hide();
    });
});