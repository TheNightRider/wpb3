(function($) {
    $(".bttrlazyloading").bttrlazyloading();
    $("#commentform #submit").addClass("btn btn-primary");
// prettyPhoto
	jQuery(document).ready(function(){
		jQuery('a[data-gal]').each(function() {
			jQuery(this).attr('rel', jQuery(this).data('gal'));
		});  	
		jQuery("a[data-rel^='prettyPhoto']").prettyPhoto({animationSpeed:'slow',theme:'light_square',slideshow:false,overlay_gallery: false,social_tools:false,deeplinking:false});
	}); 

var $container = $('.portfolio'),
$items = $container.find('.portfolio-item'),
portfolioLayout = 'fitRows';

if ( $container.hasClass('portfolio-centered')) 
    portfolioLayout = 'masonry';

$container.isotope({
    filter: '*',
    animationEngine: 'best-available',
    layoutMode: portfolioLayout,
    animationOptions: {
        duration: 750,
        easing: 'linear',
        queue: false
    },
    masonry: {
    }
}, refreshWaypoints());

$('nav.portfolio-filter ul a').on('click', function() {
    var selector = $(this).attr('data-filter');
    $container.isotope({ filter: selector }, refreshWaypoints());
    $('nav.portfolio-filter ul li').removeClass('active');
    $(this).parent('li').addClass('active');
    return true;
});

$container.imagesLoaded( function () {
    setPortfolio();
});

$(window).on('resize', function() {
    setPortfolio();
});

function getColumnNumber() {
    var winWidth = jQuery(window).width(),
            columnNumber = 1;
    
    if (winWidth > 1200) 
        columnNumber = 5;
    else if (winWidth > 950)
        columnNumber = 4;
    else if (winWidth > 600)
        columnNumber = 3;
    else if (winWidth > 400)
        columnNumber = 2;
    else if (winWidth > 250)
        columnNumber = 1;
    
    return columnNumber;
}

function setColumns() {
    var winWidth = jQuery(window).width(),
            columnNumber = getColumnNumber(),
            itemWidth = Math.floor(winWidth / columnNumber);
    
    $container.find('.portfolio-item').each(function() {
        jQuery(this).css({
            width: itemWidth + 'px'
        });
    });
}

function setPortfolio() {
    setColumns();
    $container.isotope('reLayout');
}

function refreshWaypoints() {
    setTimeout(function() {
    }, 1000);
}
 
})(jQuery);

function share_facebook_post(link) {
    u = link.getAttribute('href');
// t=document.title;
    t = link.getAttribute('title');
    window.open('http://www.facebook.com/sharer.php?u=' + encodeURIComponent(u) + '\&t=' + encodeURIComponent(t), 'sharer', 'toolbar=0,status=0,width=626,height=436');
    return false;
}

function share_twitter_post(link) {
    u = link.getAttribute('href');
    
    window.open('https://www.twitter.com/share?url=' + encodeURIComponent(u), 'shar\er', 'toolbar=0, status=0, width=626, height=436');
    return false;
}

function share_google_post(link) {
    u = link.getAttribute('href');
    window.open('https://plus.google.com/share?url=' + encodeURIComponent(u), 'shar\er', 'toolbar=0, status=0, width=626, height=436');
    return false;
}

function share_tumblr_post(link) {
    u = link.getAttribute('href');
    t = link.getAttribute('title');
    window.open('http://www.tumblr.com/share/link?url=' + encodeURIComponent(u) + '\&name=' + encodeURIComponent(t), 'sharer', 'toolbar=0, status=0, width=626, height=436');
    return false;
}

//Za ocjenjivanje
function vote(post_id, user_id){
    if (user_id == 0) return;
    
    var voteAction = 'vote_up';
    var THIS = jQuery("#voteUp");
    
    if (THIS.hasClass("btn-danger")){
        THIS.removeClass("btn-danger");
        THIS.addClass("btn-success");
        
        voteAction = 'vote_down';
    }
    else {
        THIS.addClass("btn-danger");
        THIS.removeClass("btn-success");
    }
    
    jQuery.ajax({
        url: ajaxurl,
        data: {
            'action': voteAction,
            'post_id': post_id,
            'user_id': user_id
        },
        success: function(response){
            jQuery("#voteResult").html(response);
        },
        error: function(response){
            if(THIS.hasClass("btn-danger")){
                THIS.removeClass("btn-danger");
                THIS.addClass("btn-success");
            }
            else {
                THIS.addClass("btn-danger");
                THIS.removeClass("btn-success");
            }
            alert("Došlo je do greške prilikom ocjenjivanja");
        }
    });
}