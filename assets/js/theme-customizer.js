/*
 * This file adds some LIVE to the Theme Customizer live preview. To leverage 
 * this, set your custom settings to 'postMessage' and then add your handling
 * here. Your javascript should grab settings from customizer controls, and
 * then make any necessary changes to the page using jQuery.
 */

( function( $ ) {
    wp.customize( 'blogname', function(value){
        value.bind( function(newval) {
            $( '.navbar-brand' ).html( newval );
        });
    });
    
    wp.customize('navbar_background', function(value){
        value.bind( function(newval){
            $('.navbar-default').css('backgroundColor', newval);
        });
    });
    
    wp.customize('navbar_color', function(value){
        value.bind( function(newval){
            $('.navbar-default .navbar-nav > li > a').css('color', newval);
        });
    });
    
    wp.customize('navbar_color_hover', function(value){
        value.bind( function(newval){
            $('.navbar-default .navbar-nav > .active > a, .navbar-default .navbar-nav > .active > a:hover, .navbar-default .navbar-nav > .active > a:focus, .navbar-default .navbar-nav > li > a:hover').css('color', newval);
        });
    });
    
    wp.customize('navbar_dropdown_toggle_color', function(value){
        value.bind( function(newval){
            $('.navbar-default .navbar-nav > .open > a, .navbar-default .navbar-nav > .open > a:hover, .navbar-default .navbar-nav > .open > a:focus').css('backgroundColor', newval);
        });
    });
    
    wp.customize('navbar_dropdown_color', function(value){
        value.bind( function(newval){
            $('.dropdown-menu').css('backgroundColor', newval);
        });
    });
    
    wp.customize('navbar_dropdown_hover_color', function(value){
        value.bind( function(newval){
            $('.dropdown-menu > li > a:hover, .dropdown-menu > li > a:focus').css('backgroundColor', newval);
        });
    });
    
    wp.customize('footer_background', function(value){
        value.bind( function(newval){
            $('#footerwrap').css('backgroundColor', newval);
        });
    });
    
    wp.customize('footer_color', function(value){
        value.bind( function(newval){
            $('#footerwrap p, #footerwrap i').css('color', newval);
        });
    });
    
    wp.customize('footer_heading', function(value){
        value.bind( function(newval){
            $('#footerwrap h4').css('color', newval);
            $('.hline-w').css('border-color', newval);
        });
    });
    
} ) (jQuery);