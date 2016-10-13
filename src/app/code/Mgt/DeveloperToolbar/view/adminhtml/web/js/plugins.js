define([
    'jquery'
], function ($) {
    'use strict';
    $('a.mgt-developer-toolbar-sidebar-plugin-class').click(function() {
        $(this).next('ul.plugins').toggle(); 
    });
});
