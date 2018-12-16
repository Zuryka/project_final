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
     * ***** Adaptation de la hauteur en fonction de la largeur *****
     * **************************************************************/

    var $width_event = $('.event').width();
    $('.event').css({height: $width_event + "px"});
    
    $(window).resize(function() {
        $width_event = $('.event').width();
        $('.event').css({height: $width_event + "px"});
    });


    /* *********************************************************
     * ***** Gestion des filtres dans la page "événements" *****
     * *********************************************************/

    $('#stylesChoice').submit(function(event) {
        if (!$('.allEvents').hasClass(event)) {
            $('.allEvents').addClass('desactive');
        } else {
            $('.allEvents').removeClass('desactive');
        }
    });
    
}); //loading....

