;(function($){
  
  /* Meteo */
  (function(){
    
    var $body = $("body"),
  	    $buttons = (function(){
  	      var buttons = [];
  	      $("#sidebar section.meteo label").each(function(i){
  	        var $this = $(this);
  	        buttons[i] = $('<button type="button" class="'+ $this.attr("for") + " " + $this.attr("class") +'" value="'+ $this.attr("for").slice(6) +'" title="'+ $this.text() +'">'+ $this.text() +'</button>').insertAfter(this)[0];
  	      });
  	      return $(buttons);
  	    })(),
  	    buttonsData = ["sunny", "rain", "cloudy", "snow", "night", "auto"],
  	    ajaxCall,
  	    preload;
	  
	  $buttons = $buttons.add( $('<p><button type="button" class="meteo-auto" value="auto" title="Auto">Auto</button></p>').insertAfter( $buttons.filter(":last").closest("p") ).children() );
	  
	  $buttons.click(function() {
	    
	    if (!!ajaxCall) {
	      ajaxCall.abort();
      }
  	  
  	  var curMeteo = $(this).val();
  	  
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
  	  $buttons.filter(".meteo-auto").click();
  	  
	  } else if ($.cookies.get("meteo_auto") && $.cookies.get("meteo_auto") === "1") {
	    $buttons.removeClass("active").filter(".meteo-auto").addClass("active");
	  }
    
    function autoChangeMeteo() {
      $body.addClass("loading");
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
  		
  		$body.addClass("loading");
  		
  		preload = preloadImg(
  		  jQuery.lesintegristes.themeUrl + "/i/meteo/" + weather + "/header-" + ( ($body.hasClass("home"))? "large" : "small" ) + ".jpg",
  		  function() {
    		  $body.removeClass("loading").addClass("meteo-" + weather);
    		  preload = null;
  		  });
  		
  		$.cookies.set("meteo", weather, settings);
    };
  	
  	function preloadImg(img, callback) {
  	  $imgToLoad = $('<img src="'+ img +'" style="position:absolute;top:0;left:-9999px;" />').appendTo("body");
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
  
  $(function(){
    $("#sidebar section.collapsible").each(function(){
      $button = $('<button type="button">Replier</button>').appendTo($(this).children("h1").addClass("collapsed"))
        .click(function() {
          
          var $this = $(this),
              $parent = $this.parent();
              
          if ($parent.hasClass("collapsed")) {
            $(this).text("Replier");
            $parent.removeClass("collapsed").next().slideDown(150);
          } else {
            $(this).text("Déplier");
            $parent.addClass("collapsed").next().slideUp(150);
          }
        }).parent().next().hide();
    });
  })
  
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