/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
//var $ = require('jquery');
import 'bootstrap';
import 'masonry-layout';

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

    /* ***** MASONRY ***** */
    $('.grid').masonry({
        itemSelector: '.grid-item',
        columnWidth: 200
    });

    $.typeahead({
        input: '.js-typeahead-keyword',
        minLength: 1,
        maxItem: 15,
        order: "asc",
        hint: true,
        delay: 500,
        accent: true,
        dynamic: true, // requète ajax
        // template: //function (query, item) { return 'code html' } 
        maxItemPerGroup: 5,
        backdrop: {
            "background-color": "#fff"
        },
        emptyTemplate: 'Pas de résultat pour "{{query}}"',
        source: {
            artiste: {
                display: "name",
                href: "/user/artisteshow/{{ username }}",
                ajax: {
                    url: "/ajax",
                    path: "data.keyword",
                    data: {
                        keyword: '{{ query }}'
                    }
                }
            },
        },
        callback: {
            onClick: function (node, a, item, event) {
     
                window.location.href = "/user/artisteshow/" + item.username;
     
                // href key gets added inside item from options.href configuration
                // alert(item.href);
     
            }
        },
        debug: true
    });
    





}); //loading....