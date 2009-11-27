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
  	    preload,
  	    $headerOverlay = $('<div class="overlay" />').appendTo("#header").css("opacity","0"),
  	    $headerLoader = $('<div class="loader"><div></div></div>').insertAfter($headerOverlay),
  	    loaderVisible = false;
	  
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
      showLoading();
      ajaxCall = $.get($.lesintegristes.themeUrl + "/meteo_service/service.php", function(data) {
        hideLoading();
        changeMeteo(data, {hoursToLive: 1});
        $.cookies.set("meteo_auto", "1", {hoursToLive: 1});
  	  });
  	};
    
    function changeMeteo(weather, settings) {
      
      if (loaderVisible) {
        hideLoading();
      }
      
      settings = $.extend({
        hoursToLive: 24
      }, settings);
      
      updateBodyClass(weather);
      
      $.cookies.set("meteo", weather, settings);
    };
    
    function updateBodyClass(weather) {
      $body
			  .removeClass("meteo-" + buttonsData.join(" meteo-"))
			  .addClass("meteo-" + weather);
    }
  	
  	function showLoading() {
  	  
  	  loaderVisible = true;
  	  
  	  $headerLoader.fadeIn(100);
      $headerOverlay.show().fadeTo(100, .55, function(){
  	    if (loaderVisible) {
  	      $body.addClass("loading");
  	    }
  		});
  	};
  	
  	function hideLoading() {
	    
	    loaderVisible = false;
			
			$headerLoader.fadeOut(100);
		  $headerOverlay.fadeOut(100, function(){
  		  $body.removeClass("loading");
  		});
  	};
  	
	})();
  
  /* Collapsible box */
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
  });
  
  /* "Last articles" height */
  $(function(){
    var maxHeight = 0;
    $("ul.last-articles li:lt(3) dt").each(function(){
      var thisHeight = $(this).height();
      if (thisHeight > maxHeight) {
        maxHeight = thisHeight;
      }
    }).height(maxHeight);
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
	
	/* Grid */
	var $grid;
	function initGrid() {
	  $grid = $('<div class="grid">').appendTo("body").css({
  	  position: "absolute",
  	  top: "0",
  	  left: "0",
  	  background: "url("+$.lesintegristes.themeUrl+"/i/grid.png) repeat 0 0"
  	});
	};
	function resizeGrid() {
	  $grid.css({
	    width: $("body").outerWidth(),
  	  height: $("body").outerHeight()
	  });
	}
	$.lesintegristes.showGrid = function() {
	  if (!$grid) {
	    initGrid();
    }
    resizeGrid();
    $grid.show();
	};
	$.lesintegristes.hideGrid = function() {
	  if (!!$grid) {
	    $grid.hide();
	  }
	};
  
})(jQuery);