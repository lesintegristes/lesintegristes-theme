;(function($){
  
  /* Meteo */
  (function(){
    
    var $body = $("body"),
  	    $buttons = $("#sidebar section.meteo label"),
  	    buttonsData = ["sunny", "rain", "cloudy", "snow", "night", "auto"],
  	    ajaxCall,
  	    preload;
	  
	  $buttons = $buttons.add( $('<p><label for="meteo-auto">Auto</label></p>').insertAfter($buttons.filter(":last").closest("p")).children() );
	  
	  $buttons.click(function() {
	    
	    if (!!ajaxCall) {
	      ajaxCall.abort();
      }
  	  
  	  var curMeteo = $(this).attr("for").slice(6);
  	  
  	  $.cookies.del("meteo");
      $.cookies.del("meteo_auto");
  	  
  	  $buttons.removeClass("active");
  	  $(this).addClass("active");
  	  
  	  if (curMeteo === "auto") {
        autoChangeMeteo();
        
      } else {
        changeMeteo(curMeteo);
      }
  	});
  	
  	if (!$.cookies.get("meteo")) {
  	  $buttons.filter("[for=meteo-auto]").click();
  	  
	  } else if ($.cookies.get("meteo_auto") && $.cookies.get("meteo_auto") === "1") {
	    $buttons.removeClass("active").filter("[for=meteo-auto]").addClass("active");
	  }
    
    function autoChangeMeteo() {
      ajaxCall = $.get($.lesintegristes.themeUrl + "/meteo_service/service.php", function(data) {
        changeMeteo(data, {hoursToLive: 1});
        $.cookies.set("meteo_auto", "1", {hoursToLive: 1});
  	  });
  	}
    
    function changeMeteo(weather, settings) {
      
      if (!!preload) {
        preload.stop();
      }
      
      settings = $.extend({
        hoursToLive: 24
      }, settings);
      
  		for (i in buttonsData) {
  			$body.removeClass("meteo-" + buttonsData[i]);
  		}
  		
  		preload = preloadImg(
  		  jQuery.lesintegristes.themeUrl + "/i/meteo/sunny/header-" + ( ($body.hasClass("home"))? "large" : "small" ) + ".jpg",
  		  function() {
    		  $body.addClass("meteo-" + weather);
    		  preload = null;
  		  });
  		
  		$.cookies.set("meteo", weather, settings);
    };
  	
  	function preloadImg(img, callback) {
  	  $imgToLoad = $('<img src="'+ img +'" style="position:absolute;left:-9999px;" />').appendTo("body");
  	  $imgToLoad.load(function(){
  	    $imgToLoad.remove();
  	    callback();
  	  });
  	  
  	  return {
  	    stop: function() {
  	      $imgToLoad.unbind("load").remove();
  	    }
  	  };
  	}
  	
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