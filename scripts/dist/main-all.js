/*! Les intégristes - Theme - v0.1.0 - 2012-10-14
* https://github.com/lesintegristes/lesintegristes-theme
* Copyright (c) 2012 Pierre Bertet; Licensed MIT */

/**
 * Copyright (c) 2005 - 2010, James Auldridge
 * All rights reserved.
 *
 * Licensed under the BSD, MIT, and GPL (your choice!) Licenses:
 *  http://code.google.com/p/cookies/wiki/License
 *
 */
var jaaulde = window.jaaulde || {};
jaaulde.utils = jaaulde.utils || {};
jaaulde.utils.cookies = ( function()
{
	var resolveOptions, assembleOptionsString, parseCookies, constructor, defaultOptions = {
		expiresAt: null,
		path: '/',
		domain:  null,
		secure: false
	};
	/**
	* resolveOptions - receive an options object and ensure all options are present and valid, replacing with defaults where necessary
	*
	* @access private
	* @static
	* @parameter Object options - optional options to start with
	* @return Object complete and valid options object
	*/
	resolveOptions = function( options )
	{
		var returnValue, expireDate;

		if( typeof options !== 'object' || options === null )
		{
			returnValue = defaultOptions;
		}
		else
		{
			returnValue = {
				expiresAt: defaultOptions.expiresAt,
				path: defaultOptions.path,
				domain: defaultOptions.domain,
				secure: defaultOptions.secure
			};

			if( typeof options.expiresAt === 'object' && options.expiresAt instanceof Date )
			{
				returnValue.expiresAt = options.expiresAt;
			}
			else if( typeof options.hoursToLive === 'number' && options.hoursToLive !== 0 )
			{
				expireDate = new Date();
				expireDate.setTime( expireDate.getTime() + ( options.hoursToLive * 60 * 60 * 1000 ) );
				returnValue.expiresAt = expireDate;
			}

			if( typeof options.path === 'string' && options.path !== '' )
			{
				returnValue.path = options.path;
			}

			if( typeof options.domain === 'string' && options.domain !== '' )
			{
				returnValue.domain = options.domain;
			}

			if( options.secure === true )
			{
				returnValue.secure = options.secure;
			}
		}

		return returnValue;
		};
	/**
	* assembleOptionsString - analyze options and assemble appropriate string for setting a cookie with those options
	*
	* @access private
	* @static
	* @parameter options OBJECT - optional options to start with
	* @return STRING - complete and valid cookie setting options
	*/
	assembleOptionsString = function( options )
	{
		options = resolveOptions( options );

		return (
			( typeof options.expiresAt === 'object' && options.expiresAt instanceof Date ? '; expires=' + options.expiresAt.toGMTString() : '' ) +
			'; path=' + options.path +
			( typeof options.domain === 'string' ? '; domain=' + options.domain : '' ) +
			( options.secure === true ? '; secure' : '' )
		);
	};
	/**
	* parseCookies - retrieve document.cookie string and break it into a hash with values decoded and unserialized
	*
	* @access private
	* @static
	* @return OBJECT - hash of cookies from document.cookie
	*/
	parseCookies = function()
	{
		var cookies = {}, i, pair, name, value, separated = document.cookie.split( ';' ), unparsedValue;
		for( i = 0; i < separated.length; i = i + 1 )
		{
			pair = separated[i].split( '=' );
			name = pair[0].replace( /^\s*/, '' ).replace( /\s*$/, '' );

			try
			{
				value = decodeURIComponent( pair[1] );
			}
			catch( e1 )
			{
				value = pair[1];
			}

			if( typeof JSON === 'object' && JSON !== null && typeof JSON.parse === 'function' )
			{
				try
				{
					unparsedValue = value;
					value = JSON.parse( value );
				}
				catch( e2 )
				{
					value = unparsedValue;
				}
			}

			cookies[name] = value;
		}
		return cookies;
	};

	constructor = function(){};

	/**
	 * get - get one, several, or all cookies
	 *
	 * @access public
	 * @paramater Mixed cookieName - String:name of single cookie; Array:list of multiple cookie names; Void (no param):if you want all cookies
	 * @return Mixed - Value of cookie as set; Null:if only one cookie is requested and is not found; Object:hash of multiple or all cookies (if multiple or all requested);
	 */
	constructor.prototype.get = function( cookieName )
	{
		var returnValue, item, cookies = parseCookies();

		if( typeof cookieName === 'string' )
		{
			returnValue = ( typeof cookies[cookieName] !== 'undefined' ) ? cookies[cookieName] : null;
		}
		else if( typeof cookieName === 'object' && cookieName !== null )
		{
			returnValue = {};
			for( item in cookieName )
			{
				if( typeof cookies[cookieName[item]] !== 'undefined' )
				{
					returnValue[cookieName[item]] = cookies[cookieName[item]];
				}
				else
				{
					returnValue[cookieName[item]] = null;
				}
			}
		}
		else
		{
			returnValue = cookies;
		}

		return returnValue;
	};
	/**
	 * filter - get array of cookies whose names match the provided RegExp
	 *
	 * @access public
	 * @paramater Object RegExp - The regular expression to match against cookie names
	 * @return Mixed - Object:hash of cookies whose names match the RegExp
	 */
	constructor.prototype.filter = function( cookieNameRegExp )
	{
		var cookieName, returnValue = {}, cookies = parseCookies();

		if( typeof cookieNameRegExp === 'string' )
		{
			cookieNameRegExp = new RegExp( cookieNameRegExp );
		}

		for( cookieName in cookies )
		{
			if( cookieName.match( cookieNameRegExp ) )
			{
				returnValue[cookieName] = cookies[cookieName];
			}
		}

		return returnValue;
	};
	/**
	 * set - set or delete a cookie with desired options
	 *
	 * @access public
	 * @paramater String cookieName - name of cookie to set
	 * @paramater Mixed value - Any JS value. If not a string, will be JSON encoded; NULL to delete
	 * @paramater Object options - optional list of cookie options to specify
	 * @return void
	 */
	constructor.prototype.set = function( cookieName, value, options )
	{
		if( typeof options !== 'object' || options === null )
		{
			options = {};
		}

		if( typeof value === 'undefined' || value === null )
		{
			value = '';
			options.hoursToLive = -8760;
		}

		else if( typeof value !== 'string' )
		{
			if( typeof JSON === 'object' && JSON !== null && typeof JSON.stringify === 'function' )
			{
				value = JSON.stringify( value );
			}
			else
			{
				throw new Error( 'cookies.set() received non-string value and could not serialize.' );
			}
		}


		var optionsString = assembleOptionsString( options );

		document.cookie = cookieName + '=' + encodeURIComponent( value ) + optionsString;
	};
	/**
	 * del - delete a cookie (domain and path options must match those with which the cookie was set; this is really an alias for set() with parameters simplified for this use)
	 *
	 * @access public
	 * @paramater MIxed cookieName - String name of cookie to delete, or Bool true to delete all
	 * @paramater Object options - optional list of cookie options to specify ( path, domain )
	 * @return void
	 */
	constructor.prototype.del = function( cookieName, options )
	{
		var allCookies = {}, name;

		if( typeof options !== 'object' || options === null )
		{
			options = {};
		}

		if( typeof cookieName === 'boolean' && cookieName === true )
		{
			allCookies = this.get();
		}
		else if( typeof cookieName === 'string' )
		{
			allCookies[cookieName] = true;
		}

		for( name in allCookies )
		{
			if( typeof name === 'string' && name !== '' )
			{
				this.set( name, null, options );
			}
		}
	};
	/**
	 * test - test whether the browser is accepting cookies
	 *
	 * @access public
	 * @return Boolean
	 */
	constructor.prototype.test = function()
	{
		var returnValue = false, testName = 'cT', testValue = 'data';

		this.set( testName, testValue );

		if( this.get( testName ) === testValue )
		{
			this.del( testName );
			returnValue = true;
		}

		return returnValue;
	};
	/**
	 * setOptions - set default options for calls to cookie methods
	 *
	 * @access public
	 * @param Object options - list of cookie options to specify
	 * @return void
	 */
	constructor.prototype.setOptions = function( options )
	{
		if( typeof options !== 'object' )
		{
			options = null;
		}

		defaultOptions = resolveOptions( options );
	};

	return new constructor();
} )();

( function()
{
	if( window.jQuery )
	{
		( function( $ )
		{
			$.cookies = jaaulde.utils.cookies;

			var extensions = {
				/**
				* $( 'selector' ).cookify - set the value of an input field, or the innerHTML of an element, to a cookie by the name or id of the field or element
				*                           (field or element MUST have name or id attribute)
				*
				* @access public
				* @param options OBJECT - list of cookie options to specify
				* @return jQuery
				*/
				cookify: function( options )
				{
					return this.each( function()
					{
						var i, nameAttrs = ['name', 'id'], name, $this = $( this ), value;

						for( i in nameAttrs )
						{
							if( ! isNaN( i ) )
							{
								name = $this.attr( nameAttrs[ i ] );
								if( typeof name === 'string' && name !== '' )
								{
									if( $this.is( ':checkbox, :radio' ) )
									{
										if( $this.attr( 'checked' ) )
										{
											value = $this.val();
										}
									}
									else if( $this.is( ':input' ) )
									{
										value = $this.val();
									}
									else
									{
										value = $this.html();
									}

									if( typeof value !== 'string' || value === '' )
									{
										value = null;
									}

									$.cookies.set( name, value, options );

									break;
								}
							}
						}
					} );
				},
				/**
				* $( 'selector' ).cookieFill - set the value of an input field or the innerHTML of an element from a cookie by the name or id of the field or element
				*
				* @access public
				* @return jQuery
				*/
				cookieFill: function()
				{
					return this.each( function()
					{
						var n, getN, nameAttrs = ['name', 'id'], name, $this = $( this ), value;

						getN = function()
						{
							n = nameAttrs.pop();
							return !! n;
						};

						while( getN() )
						{
							name = $this.attr( n );
							if( typeof name === 'string' && name !== '' )
							{
								value = $.cookies.get( name );
								if( value !== null )
								{
									if( $this.is( ':checkbox, :radio' ) )
									{
										if( $this.val() === value )
										{
											$this.attr( 'checked', 'checked' );
										}
										else
										{
											$this.removeAttr( 'checked' );
										}
									}
									else if( $this.is( ':input' ) )
									{
										$this.val( value );
									}
									else
									{
										$this.html( value );
									}
								}
								
								break;
							}
						}
					} );
				},
				/**
				* $( 'selector' ).cookieBind - call cookie fill on matching elements, and bind their change events to cookify()
				*
				* @access public
				* @param options OBJECT - list of cookie options to specify
				* @return jQuery
				*/
				cookieBind: function( options )
				{
					return this.each( function()
					{
						var $this = $( this );
						$this.cookieFill().change( function()
						{
							$this.cookify( options );
						} );
					} );
				}
			};

			$.each( extensions, function( i )
			{
				$.fn[i] = this;
			} );

		} )( window.jQuery );
	}
} )();
/* global jQuery:false, LESINTEGRISTES:false */
;(function($, LESINTEGRISTES){

  /* Weather */
  (function(){

    var $body = $("body"),
        $buttons,
        buttonsData = ["sunny", "rain", "cloudy", "snow", "night", "auto"],
        ajaxCall,
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
    }

    // Auto change weather (Yahoo Weather API)
    function autoChangeWeather() {
      showLoading();
      ajaxCall = $.ajax({
        url: LESINTEGRISTES.themeUrl + "/weather_service/service.php",
        success: function(data) {
          hideLoading();
          changeWeather(data, {hoursToLive: 1});
          $.cookies.set("weather_auto", "1", {hoursToLive: 1});
        },
        cache: false
      });
    }

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
    }

    // Change body weather class
    function updateBodyClass(weather) {
      $body
        .removeClass("weather-" + buttonsData.join(" weather-"))
        .addClass("weather-" + weather);
    }

    function showLoading() {

      loaderVisible = true;

      $headerLoader.fadeIn(100);
      $headerOverlay.show().fadeTo(100, 0.55, function(){
        if (loaderVisible) {
          $body.addClass("loading");
        }
      });
    }

    function hideLoading() {

      loaderVisible = false;

      $headerLoader.fadeOut(100);
      $headerOverlay.fadeOut(100, function(){
        $body.removeClass("loading");
      });
    }

  })();

  /* Collapsible box */
  $(function(){
    $("#sidebar section.collapsible").each(function(){
      var $button = $('<button type="button" title="Déplier">Déplier</button>'),
          $title = $(this).children("h1");

      $title.addClass("collapsed");
      $button.appendTo($title);

      $button.click(function() {
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
    .end().filter(":first").addClass("expanded").text("Replier");

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
        background: "url("+ LESINTEGRISTES.themeUrl +"/styles/i/grid.png) repeat 0 0",
        cursor: "pointer",
        display: "none"
      }).children().css("background", "url("+ LESINTEGRISTES.themeUrl +"/styles/i/h-grid.png) repeat-y 50% 0").end();

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
    }

    function resizeGrid() {
      $grid.add($grid.children()).css({
        width: $("body").outerWidth(),
        height: $("body").outerHeight()
      });
    }

    function showGrid() {
      if (!$grid) {
        initGrid();
      }
      resizeGrid();
      $grid.add($gridBtn).fadeIn(150);
    }

    function hideGrid() {
      if (!!$grid) {
        $grid.add($gridBtn).fadeOut(150);
      }
    }
    
    $.lesintegristes = {}; // compat
    LESINTEGRISTES.grid = $.lesintegristes.toggleGrid = function() {
      if (jQuery('body > .grid').is(':visible')) {
        hideGrid();
      } else {
        showGrid();
      }
    };
  })();

})(jQuery, LESINTEGRISTES);