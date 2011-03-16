$(document).ready(function() {
  $(function() {
      setInterval( function slideSwitch() {

        var $active = $('#slideshow div.active');
        if ( $active.length == 0 ) $active = $('#slideshow div:last');

        // use this to pull the divs in the order they appear in the markup
        var $next =  $active.next().length ? $active.next()
          : $('#slideshow div:first');

        $active.addClass('last-active');

        $next.css({opacity: 0.0}).addClass('active')
          .animate({opacity: 1.0}, 1000, function() {
              $active.removeClass('active last-active');
          });
    }, 8000 );
  });
});
