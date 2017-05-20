// Scroll To Top Function
$(document).ready(function(){

    if ($(window).width() > 767) {
        $('div#index .sidebar').sticky({
            topSpacing: 120,
            'classes': {
                'element': 'jquery-sticky-element',
                'start': 'jquery-sticky-start',
                'sticky': 'jquery-sticky-sticky',
                'stopped': 'jquery-sticky-stopped',
                'placeholder': 'jquery-sticky-placeholder'
            }
        });
    }


    var menu = $("ul#horizontal");

    // Get static values here first
    var vw = 0, ctr = menu.children().length;         // number of children will not change
    menu.children().each(function()
    {
        vw += $(this).outerWidth();  // widths will not change, so just a total
    });

    jrNewLucid_collect();  // fire first collection on page load
    $(window).resize(jrNewLucid_collect); // fire collection on window resize

    function jrNewLucid_collect()
    {
        menu.css({
            visibility: 'collapse',
            'width': "calc(100% - 112px)"
        });

        // Calculate fitCount on the total width this time
        var fc = Math.floor((menu.width() / vw) * ctr) - 1;

        // Reset display and width on all list-items
        menu.children().css({"display": "block", "width": "auto"});

        // Make a set of collected list-items based on fc
        var cs = menu.children(":gt(" + fc + ")");

        $('ul#horizontal .hideshow').remove();

        menu.append($('#pm-drop-opt').html());

        // Empty the more menu and add the collected items
        $("#submenu").empty().append(cs.clone());

        // Set display to none and width to 0 on collection,
        // because they are not visible anyway.
        cs.css({"display": "none", "width": "0"});

        if (cs.length > 0) {
            $('ul#horizontal li.hideshow').css('display', 'block').click(function()
            {
                $(this).children("ul").toggle();
            });
        }
        menu.css({
            visibility: 'visible',
            'width': "100%"
        });
    }

    $(window).scroll(function(){
        if ($(this).scrollTop() > 100) {
            $('.scrollup').fadeIn();
        } else {
            $('.scrollup').fadeOut();
        }
    });

    $('.scrollup').click(function(){
        $("html, body").animate({ scrollTop: 0 }, 600);
        return false;
    });
});

/**
 * Open a modal window
 * @param id
 * @param profile_url
 */
function jrNewLucid_modal(id, profile_url)
{
    $(id).modal();
    if (profile_url) {
        $('#action_update').text(profile_url + ' ');
    }
}

