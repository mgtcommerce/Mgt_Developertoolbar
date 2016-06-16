define([
    'jquery'
], function ($) {
    'use strict';
    $('a.mgt-developer-toolbar-sidebar-event').click(function() {
        $(this).next('ul.observers').toggle(); 
    });
});
