;(function($){
  
  /* Meteo */
  (function(){
    
    var $meteoContainer = $("#sidebar section.meteo");
  	var buttonsData = [["Soleil", "sunny"], ["Pluie", "rain"], ["Nuageux", "cloudy"], ["Neige", "snow"], ["Nuit", "night"]];
  	var buttons = '';
	  
    for (i in buttonsData) {
  		buttons += '<button type="button" value="' + buttonsData[i][1] + '"><span><span>' + buttonsData[i][0] + '</span></span></button>';
  	}
  	
  	$(buttons).appendTo($meteoContainer).click(function(){
  		$body = $("body");
  		for (i in buttonsData) {
  			$body.removeClass(buttonsData[i][1]);
  		}
  		$body.addClass($(this).val());
  	});
  	
	})();
  
  /* "Last articles" (nom temporaire) height */
  $(function(){
    var maxHeight = 0;
    $("ul.last-articles li:lt(3) dt a").each(function(){
      var thisHeight = $(this).height();
      if (thisHeight > maxHeight) {
        maxHeight = thisHeight;
      }
    }).parent().height(maxHeight);
  });
  
  /* Archives toggle button */
  $('<button type="button">Replier</button>')
    .appendTo("#wrapper > footer .archives li strong")
    .click(function() {
      var $this = $(this);
      
      if ($this.hasClass("expanded")) {
        $(this).removeClass("expanded").text("Déplier").parent().next().slideUp(150);
      } else {  
        $(this).addClass("expanded").text("Replier").parent().next().slideDown(150);
      }
    })
    .filter(":not(:first)").parent().next().hide().end().end()
    .end().filter(":first").addClass("expanded").text("Replier")
  
  /* Back to top */
	$('#wrapper > footer nav .top a').click(function(e){
		e.preventDefault();
		var curHref = $(this).attr("href");
		$('html').animate({scrollTop: 0}, 100, function(){
			window.location.hash = curHref.slice(1);
			$(curHref).focus();
		});
	});
  
})(jQuery);