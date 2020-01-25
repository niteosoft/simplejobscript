    
    // Scroll page with easing effect
    $('#top-menu li a').bind('click', function(e) {
    	if($(this)[0].href.indexOf('#') === -1)
    		return true;

        e.preventDefault();
        target = this.hash;
        $.scrollTo(target, 1500, {
        	easing: 'easeOutCubic'
        });

        $(".btn-navbar").click();
   	});

	// Show/Hide Sticky "Go top" button
	$(window).scroll(function(){
		if($(this).scrollTop()>200){
			$(".go-top").fadeIn(200);
		}
		else{
			$(".go-top").fadeOut(200);	
		}
	});
	
	// Scroll Page to Top when clicked on "go top" button
	$(".brand, .go-top").click(function(event){
		event.preventDefault();

		$.scrollTo('#headerSection', 1500, {
        	easing: 'easeOutCubic'
        });
	});

$(function(){	

});


