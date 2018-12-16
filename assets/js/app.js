/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
// var $ = require('jquery');
import 'bootstrap';
// import 'masonry-layout';


/* **********************************
 * ***** FONCTIONS PERSONNELLES *****
 * **********************************/
$(function() {

    var $followLink = $('.follow-link');

    // Pour chaque élément ".follow-link"
    $followLink.each(function(index, element) {
        // Intercepte l'événement "click" du lien
        $(element).click(function(e) {
            e.preventDefault(); // Annule le chargement de la page

            $.getJSON($(this).attr('href'), function(data) {

                if (data.success) {
                    if(data.isFollow) { // Si on suis l'article
                        $(element).addClass('text-warning').removeClass('text-primary');
                    } else {
                        $( element ).addClass( 'text-primary' ).removeClass( 'text-warning' );
                    }
                }
            });

        });
    });


    /* **************************************************************
     * ***** adaptation de la hauteur en fonction de la largeur *****
     * **************************************************************/

    var $width_event = $('.event').width();
    console.log($width_event);
    $('.event').css({height: $width_event + "px"});
    
    $(window).resize(function() {
        $width_event = $('.event').width();
        $('.event').css({height: $width_event + "px"});
        console.log($width_event);
    });

  
  /*
  function height_section($var) {
    $var.css({ minHeight: $width_window + "px"});
  }
  
  // si la fenêtre est redimensionnée, la hauteur de l'accueil de .agency s'adapte automatiquement
  $(window).resize(function() {
    $width_window = ($(document).width() / 16)*9;
    height_section($(".home_agency"));
  });
  */
  
}); //loading....