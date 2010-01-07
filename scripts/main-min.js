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
(function(A){(function(){var H=A("body"),E,J=["sunny","rain","cloudy","snow","night","auto"],K,L,F=A('<div class="overlay" />').appendTo("#header").css("opacity","0"),G=A('<div class="loader"><div></div></div>').insertAfter(F),M=false;A(function(){I();if(!A.cookies.get("meteo")){E.filter(".meteo-auto").click();}else{if(A.cookies.get("meteo_auto")&&A.cookies.get("meteo_auto")==="1"){E.removeClass("active").filter(".meteo-auto").addClass("active");}}});function I(){var P=[];A("#sidebar > .meteo label").each(function(Q){var R=A(this);P[Q]=A('<button type="button" class="'+R.attr("for")+" "+R.attr("class")+'" value="'+R.attr("for").slice(6)+'" title="'+R.text()+'"></button>').insertAfter(this)[0];});E=A(P);E=E.add(A('<p><button type="button" class="meteo-auto" value="auto" title="Auto"></button></p>').insertAfter(E.filter(":last").closest("p")).children());E.click(function(){if(!!K){K.abort();}var Q=A(this).attr("value");A.cookies.del("meteo");A.cookies.del("meteo_auto");E.removeClass("active");A(this).addClass("active");if(Q==="auto"){B();}else{D(Q);}});}function B(){C();K=A.get(A.lesintegristes.themeUrl+"/meteo_service/service.php",function(P){N();D(P,{hoursToLive:1});A.cookies.set("meteo_auto","1",{hoursToLive:1});});}function D(Q,P){if(M){N();}P=A.extend({hoursToLive:24},P);O(Q);A.cookies.set("meteo",Q,P);}function O(P){H.removeClass("meteo-"+J.join(" meteo-")).addClass("meteo-"+P);}function C(){M=true;G.fadeIn(100);F.show().fadeTo(100,0.55,function(){if(M){H.addClass("loading");}});}function N(){M=false;G.fadeOut(100);F.fadeOut(100,function(){H.removeClass("loading");});}})();A(function(){A("#sidebar section.collapsible").each(function(){$button=A('<button type="button" title="Déplier">Déplier</button>').appendTo(A(this).children("h1").addClass("collapsed")).click(function(){var C=A(this),B=C.parent();if(!B.hasClass("expanded")){A(this).text("Replier").attr("title","Replier");B.removeClass("collapsed").addClass("expanded animated").next().slideDown(150,function(){B.removeClass("animated");});}else{A(this).text("Déplier").attr("title","Déplier");B.removeClass("expanded").addClass("collapsed animated").next().slideUp(150,function(){B.removeClass("animated");});}}).parent().next().hide();});});A(function(){var B=0;A("ul.last-articles li:lt(3) dt").each(function(){var C=A(this).height();if(C>B){B=C;}}).height(B);});A('<button type="button">Replier</button>').appendTo("#footer .archives li strong").click(function(){var C=A(this).addClass("animated");var B=function(){C.removeClass("animated");};if(C.hasClass("expanded")){C.removeClass("expanded").text("Déplier").parent().next().slideUp(150,B);}else{C.addClass("expanded").text("Replier").parent().next().slideDown(150,B);}}).filter(":not(:first)").parent().next().hide().end().end().end().filter(":first").addClass("expanded").text("Replier");A("#wrapper > footer nav .top a").click(function(C){C.preventDefault();var B=A(this).attr("href");A("html").animate({scrollTop:0},100,function(){window.location.hash=B.slice(1);A(B).focus();});});(function(){var B,C;function F(){B=A('<div class="grid"><div></div></div>').appendTo("body").css({position:"absolute",top:"0",left:"0",zIndex:"9998",background:"url("+A.lesintegristes.themeUrl+"/i/grid.png) repeat 0 0",cursor:"pointer",display:"none"}).children().css("background","url("+A.lesintegristes.themeUrl+"/i/h-grid.png) repeat-y 50% 0").end();C=A('<button type="button">Fermer la grille</button>').appendTo("body").css({position:"fixed",top:"0",right:"0",zIndex:"9999",padding:"10px",color:"#fff",background:"#494949",display:"none"});C.add(B).click(function(H){H.stopImmediatePropagation();E();});}function D(){B.add(B.children()).css({width:A("body").outerWidth(),height:A("body").outerHeight()});}function G(){if(!B){F();}D();B.add(C).fadeIn(150);}function E(){if(!!B){B.add(C).fadeOut(150);}}A.lesintegristes.toggleGrid=function(){if(jQuery("body > .grid").is(":visible")){E();}else{G();}};})();})(jQuery);