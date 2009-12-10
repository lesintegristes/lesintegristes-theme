(function($){
  $(function(){
    
    
  	/* Rectify images line-height */
  	var $imgs = $("#content article.hentry > div.content img").each(function(){
  	  var $this = $(this),
  	      thisHeight = $this.height(),
  	      $target = ($this.parent().is("a,figure"))? $this.parent() : $this,
  	      additionnlMargin = 24 - thisHeight % 24;
  	  
  	  if (additionnlMargin <= 10) {
  	    additionnlMargin += 24;
  	  }
  	  
  	  $target.css({
  	    "display": "inline-block",
  	    "marginBottom": additionnlMargin + "px"
  	  });
  	  
  	});
    
    /* HTML Help animation */
    var $htmlHelp = $("#respond p.html-help");
    $htmlHelp.height($htmlHelp.height()).hide();
    $("#respond textarea").focus(function(){
    	if (!$htmlHelp.is(":visible")) {
    		$htmlHelp.slideDown(150);
    	}
    });
    
    /* Post comment animation */
  	$('#comments .post-comment a, article.hentry > footer a[href=#respond]').click(function(e){
  		e.preventDefault();
  		var curHref = $(this).attr("href");
  		$('html').animate({scrollTop: $(curHref).offset().top}, 100, function(){
  			window.location.hash = curHref.slice(1);
  			$(curHref).focus();
  		});
  	});
  });
})(jQuery);