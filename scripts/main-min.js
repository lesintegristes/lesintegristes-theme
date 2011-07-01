/**
 * jQuery Cookies - Copyright (c) 2005 - 2009, James Auldridge - All rights reserved.
 * Licensed under the BSD, MIT, and GPL (your choice!) Licenses:
 * http://code.google.com/p/cookies/wiki/License
 */
var jaaulde=window.jaaulde||{};jaaulde.utils=jaaulde.utils||{};jaaulde.utils.cookies=(function()
{var cookies=[];var defaultOptions={hoursToLive:null,path:'/',domain:null,secure:false};var resolveOptions=function(options)
{var returnValue;if(typeof options!=='object'||options===null)
{returnValue=defaultOptions;}
else
{returnValue={hoursToLive:(typeof options.hoursToLive==='number'&&options.hoursToLive!==0?options.hoursToLive:defaultOptions.hoursToLive),path:(typeof options.path==='string'&&options.path!==''?options.path:defaultOptions.path),domain:(typeof options.domain==='string'&&options.domain!==''?options.domain:defaultOptions.domain),secure:(typeof options.secure==='boolean'&&options.secure?options.secure:defaultOptions.secure)};}
return returnValue;};var expiresGMTString=function(hoursToLive)
{var dateObject=new Date();dateObject.setTime(dateObject.getTime()+(hoursToLive*60*60*1000));return dateObject.toGMTString();};var assembleOptionsString=function(options)
{options=resolveOptions(options);return((typeof options.hoursToLive==='number'?'; expires='+expiresGMTString(options.hoursToLive):'')+'; path='+options.path+
(typeof options.domain==='string'?'; domain='+options.domain:'')+
(options.secure===true?'; secure':''));};var splitCookies=function()
{cookies={};var pair,name,value,separated=document.cookie.split(';');for(var i=0;i<separated.length;i=i+1)
{pair=separated[i].split('=');name=pair[0].replace(/^\s*/,'').replace(/\s*$/,'');value=decodeURIComponent(pair[1]);cookies[name]=value;}
return cookies;};var constructor=function(){};constructor.prototype.get=function(cookieName)
{var returnValue;splitCookies();if(typeof cookieName==='string')
{returnValue=(typeof cookies[cookieName]!=='undefined')?cookies[cookieName]:null;}
else if(typeof cookieName==='object'&&cookieName!==null)
{returnValue={};for(var item in cookieName)
{if(typeof cookies[cookieName[item]]!=='undefined')
{returnValue[cookieName[item]]=cookies[cookieName[item]];}
else
{returnValue[cookieName[item]]=null;}}}
else
{returnValue=cookies;}
return returnValue;};constructor.prototype.filter=function(cookieNameRegExp)
{var returnValue={};splitCookies();if(typeof cookieNameRegExp==='string')
{cookieNameRegExp=new RegExp(cookieNameRegExp);}
for(var cookieName in cookies)
{if(cookieName.match(cookieNameRegExp))
{returnValue[cookieName]=cookies[cookieName];}}
return returnValue;};constructor.prototype.set=function(cookieName,value,options)
{if(typeof value==='undefined'||value===null)
{if(typeof options!=='object'||options===null)
{options={};}
value='';options.hoursToLive=-8760;}
var optionsString=assembleOptionsString(options);document.cookie=cookieName+'='+encodeURIComponent(value)+optionsString;};constructor.prototype.del=function(cookieName,options)
{var allCookies={};if(typeof options!=='object'||options===null)
{options={};}
if(typeof cookieName==='boolean'&&cookieName===true)
{allCookies=this.get();}
else if(typeof cookieName==='string')
{allCookies[cookieName]=true;}
for(var name in allCookies)
{if(typeof name==='string'&&name!=='')
{this.set(name,null,options);}}};constructor.prototype.test=function()
{var returnValue=false,testName='cT',testValue='data';this.set(testName,testValue);if(this.get(testName)===testValue)
{this.del(testName);returnValue=true;}
return returnValue;};constructor.prototype.setOptions=function(options)
{if(typeof options!=='object')
{options=null;}
defaultOptions=resolveOptions(options);};return new constructor();})();(function()
{if(window.jQuery)
{(function($)
{$.cookies=jaaulde.utils.cookies;var extensions={cookify:function(options)
{return this.each(function()
{var i,resolvedName=false,resolvedValue=false,name='',value='',nameAttrs=['name','id'],nodeName,inputType;for(i in nameAttrs)
{if(!isNaN(i))
{name=$(this).attr(nameAttrs[i]);if(typeof name==='string'&&name!=='')
{resolvedName=true;break;}}}
if(resolvedName)
{nodeName=this.nodeName.toLowerCase();if(nodeName!=='input'&&nodeName!=='textarea'&&nodeName!=='select'&&nodeName!=='img')
{value=$(this).html();resolvedValue=true;}
else
{inputType=$(this).attr('type');if(typeof inputType==='string'&&inputType!=='')
{inputType=inputType.toLowerCase();}
if(inputType!=='radio'&&inputType!=='checkbox')
{value=$(this).val();resolvedValue=true;}}
if(resolvedValue)
{if(typeof value!=='string'||value==='')
{value=null;}
$.cookies.set(name,value,options);}}});},cookieFill:function()
{return this.each(function()
{var i,resolvedName=false,name='',value,nameAttrs=['name','id'],iteration=0,nodeName;for(i in nameAttrs)
{if(!isNaN(i))
{name=$(this).attr(nameAttrs[i]);if(typeof name==='string'&&name!=='')
{resolvedName=true;break;}}}
if(resolvedName)
{value=$.cookies.get(name);if(value!==null)
{nodeName=this.nodeName.toLowerCase();if(nodeName==='input'||nodeName==='textarea'||nodeName==='select')
{$(this).val(value);}
else
{$(this).html(value);}}}
iteration=0;});},cookieBind:function(options)
{return this.each(function()
{$(this).cookieFill().change(function()
{$(this).cookify(options);});});}};$.each(extensions,function(i)
{$.fn[i]=this;});})(window.jQuery);}})();

/* main.js */
;(function($){(function(){var $body=$("body"),$buttons,buttonsData=["sunny","rain","cloudy","snow","night","auto"],ajaxCall,preload,$headerOverlay=$('<div class="overlay" />').appendTo("#header").css("opacity","0"),$headerLoader=$('<div class="loader"><div></div></div>').insertAfter($headerOverlay),loaderVisible=false;$(function(){initButtons();if(!$.cookies.get("meteo")){$buttons.filter(".meteo-auto").click();}else if($.cookies.get("meteo_auto")&&$.cookies.get("meteo_auto")==="1"){$buttons.removeClass("active").filter(".meteo-auto").addClass("active");}});function initButtons(){var buttons=[];$("#sidebar > .meteo label").each(function(i){var $this=$(this);buttons[i]=$('<button type="button" class="'+$this.attr("for")+" "
+$this.attr("class")+'" value="'+$this.attr("for").slice(6)+'" title="'
+$this.text()+'"></button>').insertAfter(this)[0];});$buttons=$(buttons);$buttons=$buttons.add($('<p><button type="button" class="meteo-auto" value="auto" title="Auto"></button></p>').insertAfter($buttons.filter(":last").closest("p")).children());$buttons.click(function(){if(!!ajaxCall){ajaxCall.abort();}
var curMeteo=$(this).attr("value");$.cookies.del("meteo");$.cookies.del("meteo_auto");$buttons.removeClass("active");$(this).addClass("active");if(curMeteo==="auto"){autoChangeMeteo();}else{changeMeteo(curMeteo);}});};function autoChangeMeteo(){showLoading();ajaxCall=$.ajax({url:$.lesintegristes.themeUrl+"/meteo_service/service.php",success:function(data){hideLoading();changeMeteo(data,{hoursToLive:1});$.cookies.set("meteo_auto","1",{hoursToLive:1});},cache:false});};function changeMeteo(weather,settings){if(loaderVisible){hideLoading();}
settings=$.extend({hoursToLive:24},settings);updateBodyClass(weather);$.cookies.set("meteo",weather,settings);};function updateBodyClass(weather){$body.removeClass("meteo-"+buttonsData.join(" meteo-")).addClass("meteo-"+weather);}
function showLoading(){loaderVisible=true;$headerLoader.fadeIn(100);$headerOverlay.show().fadeTo(100,.55,function(){if(loaderVisible){$body.addClass("loading");}});};function hideLoading(){loaderVisible=false;$headerLoader.fadeOut(100);$headerOverlay.fadeOut(100,function(){$body.removeClass("loading");});};})();$(function(){$("#sidebar section.collapsible").each(function(){$button=$('<button type="button" title="Déplier">Déplier</button>').appendTo($(this).children("h1").addClass("collapsed")).click(function(){var $this=$(this),$parent=$this.parent();if(!$parent.hasClass("expanded")){$(this).text("Replier").attr("title","Replier");$parent.removeClass("collapsed").addClass("expanded animated").next().slideDown(150,function(){$parent.removeClass("animated");});}else{$(this).text("Déplier").attr("title","Déplier");$parent.removeClass("expanded").addClass("collapsed animated").next().slideUp(150,function(){$parent.removeClass("animated");});}}).parent().next().hide();});});$(function(){var maxHeight=0;$("ul.last-articles li:lt(3) dt").each(function(){var thisHeight=$(this).height();if(thisHeight>maxHeight){maxHeight=thisHeight;}}).height(maxHeight);});$('<button type="button">Replier</button>').appendTo("#footer .archives li strong").click(function(){var $this=$(this).addClass("animated");var slideCallback=function(){$this.removeClass("animated");};if($this.hasClass("expanded")){$this.removeClass("expanded").text("Déplier").parent().next().slideUp(150,slideCallback);}else{$this.addClass("expanded").text("Replier").parent().next().slideDown(150,slideCallback);}}).filter(":not(:first)").parent().next().hide().end().end().end().filter(":first").addClass("expanded").text("Replier")
$('#wrapper > footer nav .top a').click(function(e){e.preventDefault();var curHref=$(this).attr("href");$('html').animate({scrollTop:0},100,function(){window.location.hash=curHref.slice(1);$(curHref).focus();});});(function(){var $grid,$gridBtn;function initGrid(){$grid=$('<div class="grid"><div></div></div>').appendTo("body").css({position:"absolute",top:"0",left:"0",zIndex:"9998",background:"url("+$.lesintegristes.themeUrl+"/i/grid.png) repeat 0 0",cursor:"pointer",display:"none"}).children().css("background","url("+$.lesintegristes.themeUrl+"/i/h-grid.png) repeat-y 50% 0").end();$gridBtn=$('<button type="button">Fermer la grille</button>').appendTo('body').css({position:"fixed",top:"0",right:"0",zIndex:"9999",padding:"10px",color:"#fff",background:"#494949",display:"none"});$gridBtn.add($grid).click(function(e){e.stopImmediatePropagation();hideGrid();});};function resizeGrid(){$grid.add($grid.children()).css({width:$("body").outerWidth(),height:$("body").outerHeight()});};function showGrid(){if(!$grid){initGrid();}
resizeGrid();$grid.add($gridBtn).fadeIn(150);};function hideGrid(){if(!!$grid){$grid.add($gridBtn).fadeOut(150);}};$.lesintegristes.toggleGrid=function(){if(jQuery('body > .grid').is(':visible')){hideGrid();}else{showGrid();}};})();})(jQuery);