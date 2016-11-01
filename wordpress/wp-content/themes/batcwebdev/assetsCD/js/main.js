$(function() {
    // Cache the window object
    var $window = $(window);
    
    // Parallax background effect
    $('section[data-type="background"]').each(function() {
        var $bgobj = $(this); // assigning the object
         $(window).scroll(function() {
             
             // scroll the backgound at var speed
             // the yPos is a necgative value because we're scrolling UP
             
             var yPos = -($window.scrollTop() / $bgobj.data('speed'));
             
             // final background position
             var coords = '50% ' + yPos + 'px';
             
             // Move the background
             $bgobj.css({ backgroundPosition: coords });
         }); // end window scroll
    });
});