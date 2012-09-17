;(function($){

  /* Weather */
  (function(){

    var $body = $("body"),
        $buttons,
        buttonsData = ["sunny", "rain", "cloudy", "snow", "night", "auto"],
        ajaxCall,
        preload,
        $headerOverlay = $('<div class="overlay" />').appendTo("#header").css("opacity","0"),
        $headerLoader = $('<div class="loader"><div></div></div>').insertAfter($headerOverlay),
        loaderVisible = false;

    // Document ready
    $(function(){

      initButtons();

      if (!$.cookies.get("weather")) {
        $buttons.filter(".weather-auto").click();

      } else if ($.cookies.get("weather_auto") && $.cookies.get("weather_auto") === "1") {
        $buttons.removeClass("active").filter(".weather-auto").addClass("active");
      }

    });

    // Create buttons
    function initButtons() {

      var buttons = [];

      $("#sidebar > .weather label").each(function(i){
        var $this = $(this);
        buttons[i] = $('<button type="button" class="'+ $this.attr("for") + " "
                     + $this.attr("class") +'" value="'+ $this.attr("for").slice(8) +'" title="'
                     + $this.text() +'"></button>').insertAfter(this)[0];
      });

      $buttons = $(buttons);

      $buttons = $buttons.add(
          $('<p><button type="button" class="weather-auto" value="auto" title="Auto"></button></p>')
          .insertAfter( $buttons.filter(":last").closest("p") ).children()
      );

      $buttons.click(function() {

        if (!!ajaxCall) {
          ajaxCall.abort();
        }

        var curWeather = $(this).attr("value");

        $.cookies.del("weather");
        $.cookies.del("weather_auto");

        $buttons.removeClass("active");
        $(this).addClass("active");

        if (curWeather === "auto") {
          autoChangeWeather();

        } else {
          changeWeather(curWeather);
        }
      });
    };

    // Auto change weather (Yahoo Weather API)
    function autoChangeWeather() {
      showLoading();
      ajaxCall = $.ajax({
        url: $.lesintegristes.themeUrl + "/weather_service/service.php",
        success: function(data) {
          hideLoading();
          changeWeather(data, {hoursToLive: 1});
          $.cookies.set("weather_auto", "1", {hoursToLive: 1});
        },
        cache: false
      });
    };

    // Change weather
    function changeWeather(weather, settings) {

      if (loaderVisible) {
        hideLoading();
      }

      settings = $.extend({
        hoursToLive: 24
      }, settings);

      updateBodyClass(weather);

      $.cookies.set("weather", weather, settings);
    };

    // Change body weather class
    function updateBodyClass(weather) {
      $body
        .removeClass("weather-" + buttonsData.join(" weather-"))
        .addClass("weather-" + weather);
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
      $button = $('<button type="button" title="Déplier">Déplier</button>').appendTo($(this).children("h1").addClass("collapsed"))

        .click(function() {

          var $this = $(this),
              $parent = $this.parent();

          if (!$parent.hasClass("expanded")) {
            $(this).text("Replier").attr("title","Replier");
            $parent.removeClass("collapsed").addClass("expanded animated").next().slideDown(150, function(){
              $parent.removeClass("animated");
            });
          } else {
            $(this).text("Déplier").attr("title","Déplier");
            $parent.removeClass("expanded").addClass("collapsed animated").next().slideUp(150, function(){
              $parent.removeClass("animated");
            });
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
    .appendTo("#footer .archives li strong")

    .click(function() {
      var $this = $(this).addClass("animated");
      var slideCallback = function(){
        $this.removeClass("animated");
      };

      if ($this.hasClass("expanded")) {
        $this.removeClass("expanded").text("Déplier").parent().next().slideUp(150, slideCallback);

      } else {
        $this.addClass("expanded").text("Replier").parent().next().slideDown(150, slideCallback);
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
  (function(){
    var $grid, $gridBtn;

    function initGrid() {
      $grid = $('<div class="grid"><div></div></div>').appendTo("body").css({
        position: "absolute",
        top: "0",
        left: "0",
        zIndex: "9998",
        background: "url("+$.lesintegristes.themeUrl+"/i/grid.png) repeat 0 0",
        cursor: "pointer",
        display: "none"
      }).children().css("background", "url("+$.lesintegristes.themeUrl+"/i/h-grid.png) repeat-y 50% 0").end();

      $gridBtn = $('<button type="button">Fermer la grille</button>').appendTo('body').css({
        position: "fixed",
        top: "0",
        right: "0",
        zIndex: "9999",
        padding: "10px",
        color: "#fff",
        background: "#494949",
        display: "none"
      });

      $gridBtn.add($grid).click(function(e){
        e.stopImmediatePropagation();
        hideGrid();
      });
    };

    function resizeGrid() {
      $grid.add($grid.children()).css({
        width: $("body").outerWidth(),
        height: $("body").outerHeight()
      });
    };

    function showGrid() {
      if (!$grid) {
        initGrid();
      }
      resizeGrid();
      $grid.add($gridBtn).fadeIn(150);
    };

    function hideGrid() {
      if (!!$grid) {
        $grid.add($gridBtn).fadeOut(150);
      }
    };

    $.lesintegristes.toggleGrid = function() {
      if (jQuery('body > .grid').is(':visible')) {
        hideGrid();
      } else {
        showGrid();
      }
    };
  })();

})(jQuery);