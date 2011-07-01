/* single.js */
(function($){$(function(){var $imgs=$("#content article.hentry > div.content img").each(function(){var $this=$(this),thisHeight=$this.height(),$target=$this,additionnalMargin=24-thisHeight%24,mode="margin";if($this.parent().is('a,div.wp-caption')){$target=$this.parent();}
if($this.parent().is('a'),$this.parent('a').next().is('.wp-caption-text')){$target=$this.parents('.wp-caption');}
if(!$target.is(".wp-caption")&&!$target.is("img.alignleft")&&!$target.is("img.alignright")&&additionnalMargin<10){additionnalMargin+=24;}
if($target.is("a")){if(!$target.parent().is(".img-only")){$target.css("display","inline-block");}else{$target=$target.parent();mode="padding";}}
$target.css(mode+"Bottom",additionnalMargin+"px");});var $htmlHelp=$("#respond p.html-help");$htmlHelp.height($htmlHelp.height()).hide();$("#respond textarea").focus(function(){if(!$htmlHelp.is(":visible")){$htmlHelp.slideDown(150);}});$('#comments .post-comment a, article.hentry > footer a[href=#respond]').click(function(e){e.preventDefault();var curHref=$(this).attr("href");$('html').animate({scrollTop:$(curHref).offset().top},100,function(){window.location.hash=curHref.slice(1);$(curHref).focus();});});});})(jQuery);

/**
 * SyntaxHighlighter
 * http://alexgorbatchev.com/
 *
 * SyntaxHighlighter is donationware. If you are using it, please donate.
 * http://alexgorbatchev.com/wiki/SyntaxHighlighter:Donate
 *
 * @version
 * 2.1.364 (October 15 2009)
 * 
 * @copyright
 * Copyright (C) 2004-2009 Alex Gorbatchev.
 *
 * @license
 * This file is part of SyntaxHighlighter.
 * 
 * SyntaxHighlighter is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * SyntaxHighlighter is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with SyntaxHighlighter.  If not, see <http://www.gnu.org/copyleft/lesser.html>.
 */

/* Compression by http://www.refresh-sf.com/yui/ ; shCore + shBrushCss + shBrushJScript + shBrushPhp + shBrushPlain + shBrushXml */
if(!window.SyntaxHighlighter){var SyntaxHighlighter=function(){var a={defaults:{"class-name":"","first-line":1,"pad-line-numbers":true,highlight:null,"smart-tabs":true,"tab-size":4,gutter:true,toolbar:true,collapse:false,"auto-links":true,light:false,"wrap-lines":true,"html-script":false},config:{useScriptTags:true,clipboardSwf:null,toolbarItemWidth:16,toolbarItemHeight:16,bloggerMode:false,stripBrs:false,tagName:"pre",strings:{expandSource:"show source",viewSource:"Afficher la source dans une nouvelle fenêtre",copyToClipboard:"copy to clipboard",copyToClipboardConfirmation:"The code is in your clipboard now",print:"print",help:"?",alert:"SyntaxHighlighter\n\n",noBrush:"Can't find brush for: ",brushNotHtmlScript:"Brush wasn't configured for html-script option: ",aboutDialog:'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>About SyntaxHighlighter</title></head><body style="font-family:Geneva,Arial,Helvetica,sans-serif;background-color:#fff;color:#000;font-size:1em;text-align:center;"><div style="text-align:center;margin-top:3em;"><div style="font-size:xx-large;">SyntaxHighlighter</div><div style="font-size:.75em;margin-bottom:4em;"><div>version 2.1.364 (October 15 2009)</div><div><a href="http://alexgorbatchev.com" target="_blank" style="color:#0099FF;text-decoration:none;">http://alexgorbatchev.com</a></div><div>If you like this script, please <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=2930402" style="color:#0099FF;text-decoration:none;">donate</a> to keep development active!</div></div><div>JavaScript code syntax highlighter.</div><div>Copyright 2004-2009 Alex Gorbatchev.</div></div></body></html>'},debug:false},vars:{discoveredBrushes:null,spaceWidth:null,printFrame:null,highlighters:{}},brushes:{},regexLib:{multiLineCComments:/\/\*[\s\S]*?\*\//gm,singleLineCComments:/\/\/.*$/gm,singleLinePerlComments:/#.*$/gm,doubleQuotedString:/"([^\\"\n]|\\.)*"/g,singleQuotedString:/'([^\\'\n]|\\.)*'/g,multiLineDoubleQuotedString:/"([^\\"]|\\.)*"/g,multiLineSingleQuotedString:/'([^\\']|\\.)*'/g,xmlComments:/(&lt;|<)!--[\s\S]*?--(&gt;|>)/gm,url:/&lt;\w+:\/\/[\w-.\/?%&=@:;]*&gt;|\w+:\/\/[\w-.\/?%&=@:;]*/g,phpScriptTags:{left:/(&lt;|<)\?=?/g,right:/\?(&gt;|>)/g},aspScriptTags:{left:/(&lt;|<)%=?/g,right:/%(&gt;|>)/g},scriptScriptTags:{left:/(&lt;|<)\s*script.*?(&gt;|>)/gi,right:/(&lt;|<)\/\s*script\s*(&gt;|>)/gi}},toolbar:{create:function(d){var h=document.createElement("DIV"),b=a.toolbar.items;h.className="toolbar";for(var c in b){var f=b[c],g=new f(d),e=g.create();d.toolbarCommands[c]=g;if(e==null){continue}if(typeof(e)=="string"){e=a.toolbar.createButton(e,d.id,c)}e.className+="item "+c;h.appendChild(e)}return h},createButton:function(f,c,g){var d=document.createElement("a"),i=d.style,e=a.config,h=e.toolbarItemWidth,b=e.toolbarItemHeight;d.href="#"+g;d.title=f;d.highlighterId=c;d.commandName=g;d.innerHTML=f;if(isNaN(h)==false){i.width=h+"px"}if(isNaN(b)==false){i.height=b+"px"}d.onclick=function(j){try{a.toolbar.executeCommand(this,j||window.event,this.highlighterId,this.commandName)}catch(j){a.utils.alert(j.message)}return false};return d},executeCommand:function(f,g,b,e,d){var c=a.vars.highlighters[b],h;if(c==null||(h=c.toolbarCommands[e])==null){return null}return h.execute(f,g,d)},items:{expandSource:function(b){this.create=function(){if(b.getParam("collapse")!=true){return}return a.config.strings.expandSource};this.execute=function(d,e,c){var f=b.div;d.parentNode.removeChild(d);f.className=f.className.replace("collapsed","")}},viewSource:function(b){this.create=function(){return a.config.strings.viewSource};this.execute=function(d,g,c){var f=a.utils.fixInputString(b.originalCode).replace(/</g,"&lt;"),e=a.utils.popup("","_blank",750,400,"location=0, resizable=1, menubar=0, scrollbars=1");f=a.utils.unindent(f);e.document.write("<pre>"+f+"</pre>");e.document.close()}},copyToClipboard:function(d){var e,c,b=d.id;this.create=function(){var g=a.config;if(g.clipboardSwf==null){return null}function l(o){var m="";for(var n in o){m+="<param name='"+n+"' value='"+o[n]+"'/>"}return m}function f(o){var m="";for(var n in o){m+=" "+n+"='"+o[n]+"'"}return m}var k={width:g.toolbarItemWidth,height:g.toolbarItemHeight,id:b+"_clipboard",type:"application/x-shockwave-flash",title:a.config.strings.copyToClipboard},j={allowScriptAccess:"always",wmode:"transparent",flashVars:"highlighterId="+b,menu:"false"},i=g.clipboardSwf,h;if(/msie/i.test(navigator.userAgent)){h="<object"+f({classid:"clsid:d27cdb6e-ae6d-11cf-96b8-444553540000",codebase:"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0"})+f(k)+">"+l(j)+l({movie:i})+"</object>"}else{h="<embed"+f(k)+f(j)+f({src:i})+"/>"}e=document.createElement("div");e.innerHTML=h;return e};this.execute=function(g,i,f){var j=f.command;switch(j){case"get":var h=a.utils.unindent(a.utils.fixInputString(d.originalCode).replace(/&lt;/g,"<").replace(/&gt;/g,">").replace(/&amp;/g,"&"));if(window.clipboardData){window.clipboardData.setData("text",h)}else{return a.utils.unindent(h)}case"ok":a.utils.alert(a.config.strings.copyToClipboardConfirmation);break;case"error":a.utils.alert(f.message);break}}},printSource:function(b){this.create=function(){return a.config.strings.print};this.execute=function(e,g,d){var f=document.createElement("IFRAME"),h=null;if(a.vars.printFrame!=null){document.body.removeChild(a.vars.printFrame)}a.vars.printFrame=f;f.style.cssText="position:absolute;width:0px;height:0px;left:-500px;top:-500px;";document.body.appendChild(f);h=f.contentWindow.document;c(h,window.document);h.write('<div class="'+b.div.className.replace("collapsed","")+' printing">'+b.div.innerHTML+"</div>");h.close();f.contentWindow.focus();f.contentWindow.print();function c(j,m){var k=m.getElementsByTagName("link");for(var l=0;l<k.length;l++){if(k[l].rel.toLowerCase()=="stylesheet"&&/shCore\.css$/.test(k[l].href)){j.write('<link type="text/css" rel="stylesheet" href="'+k[l].href+'"></link>')}}}}},about:function(b){this.create=function(){return a.config.strings.help};this.execute=function(c,e){var d=a.utils.popup("","_blank",500,250,"scrollbars=0"),f=d.document;f.write(a.config.strings.aboutDialog);f.close();d.focus()}}}},utils:{indexOf:function(e,b,d){d=Math.max(d||0,0);for(var c=d;c<e.length;c++){if(e[c]==b){return c}}return -1},guid:function(b){return b+Math.round(Math.random()*1000000).toString()},merge:function(e,d){var b={},c;for(c in e){b[c]=e[c]}for(c in d){b[c]=d[c]}return b},toBoolean:function(b){switch(b){case"true":return true;case"false":return false}return b},popup:function(f,e,g,c,d){var b=(screen.width-g)/2,i=(screen.height-c)/2;d+=", left="+b+", top="+i+", width="+g+", height="+c;d=d.replace(/^,/,"");var h=window.open(f,e,d);h.focus();return h},addEvent:function(d,b,c){if(d.attachEvent){d["e"+b+c]=c;d[b+c]=function(){d["e"+b+c](window.event)};d.attachEvent("on"+b,d[b+c])}else{d.addEventListener(b,c,false)}},alert:function(b){alert(a.config.strings.alert+b)},findBrush:function(f,h){var g=a.vars.discoveredBrushes,b=null;if(g==null){g={};for(var d in a.brushes){var c=a.brushes[d].aliases;if(c==null){continue}a.brushes[d].name=d.toLowerCase();for(var e=0;e<c.length;e++){g[c[e]]=d}}a.vars.discoveredBrushes=g}b=a.brushes[g[f]];if(b==null&&h!=false){a.utils.alert(a.config.strings.noBrush+f)}return b},eachLine:function(d,e){var b=d.split("\n");for(var c=0;c<b.length;c++){b[c]=e(b[c])}return b.join("\n")},trimFirstAndLastLines:function(b){return b.replace(/^[ ]*[\n]+|[\n]*[ ]*$/g,"")},parseParams:function(h){var d,c={},e=new XRegExp("^\\[(?<values>(.*?))\\]$"),f=new XRegExp("(?<name>[\\w-]+)\\s*:\\s*(?<value>[\\w-%#]+|\\[.*?\\]|\".*?\"|'.*?')\\s*;?","g");while((d=f.exec(h))!=null){var g=d.value.replace(/^['"]|['"]$/g,"");if(g!=null&&e.test(g)){var b=e.exec(g);g=b.values.length>0?b.values.split(/\s*,\s*/):[]}c[d.name]=g}return c},decorate:function(c,b){if(c==null||c.length==0||c=="\n"){return c}c=c.replace(/</g,"&lt;");c=c.replace(/ {2,}/g,function(d){var e="";for(var f=0;f<d.length-1;f++){e+="&nbsp;"}return e+" "});if(b!=null){c=a.utils.eachLine(c,function(d){if(d.length==0){return""}var e="";d=d.replace(/^(&nbsp;| )+/,function(f){e=f;return""});if(d.length==0){return e}return e+'<code class="'+b+'">'+d+"</code>"})}return c},padNumber:function(d,c){var b=d.toString();while(b.length<c){b="0"+b}return b},measureSpace:function(){var c=document.createElement("div"),h,j=0,f=document.body,d=a.utils.guid("measureSpace"),i='<div class="',g="</div>",e="</span>";c.innerHTML=i+'syntaxhighlighter">'+i+'lines">'+i+'line">'+i+'content"><span class="block"><span id="'+d+'">&nbsp;'+e+e+g+g+g+g;f.appendChild(c);h=document.getElementById(d);if(/opera/i.test(navigator.userAgent)){var b=window.getComputedStyle(h,null);j=parseInt(b.getPropertyValue("width"))}else{j=h.offsetWidth}f.removeChild(c);return j},processTabs:function(d,e){var c="";for(var b=0;b<e;b++){c+=" "}return d.replace(/\t/g,c)},processSmartTabs:function(f,g){var b=f.split("\n"),e="\t",c="";for(var d=0;d<50;d++){c+="                    "}function h(i,k,j){return i.substr(0,k)+c.substr(0,j)+i.substr(k+1,i.length)}f=a.utils.eachLine(f,function(i){if(i.indexOf(e)==-1){return i}var k=0;while((k=i.indexOf(e))!=-1){var j=g-k%g;i=h(i,k,j)}return i});return f},fixInputString:function(c){var b=/<br\s*\/?>|&lt;br\s*\/?&gt;/gi;if(a.config.bloggerMode==true){c=c.replace(b,"\n")}if(a.config.stripBrs==true){c=c.replace(b,"")}return c},trim:function(b){return b.replace(/^\s+|\s+$/g,"")},unindent:function(j){var c=a.utils.fixInputString(j).split("\n"),h=new Array(),f=/^\s*/,e=1000;for(var d=0;d<c.length&&e>0;d++){var b=c[d];if(a.utils.trim(b).length==0){continue}var g=f.exec(b);if(g==null){return j}e=Math.min(g[0].length,e)}if(e>0){for(var d=0;d<c.length;d++){c[d]=c[d].substr(e)}}return c.join("\n")},matchesSortCallback:function(c,b){if(c.index<b.index){return -1}else{if(c.index>b.index){return 1}else{if(c.length<b.length){return -1}else{if(c.length>b.length){return 1}}}}return 0},getMatches:function(f,g){function h(i,j){return[new a.Match(i[0],i.index,j.css)]}var d=0,c=null,b=[],e=g.func?g.func:h;while((c=g.regex.exec(f))!=null){b=b.concat(e(c,g))}return b},processUrls:function(d){var b="&lt;",c="&gt;";return d.replace(a.regexLib.url,function(e){var g="",f="";if(e.indexOf(b)==0){f=b;e=e.substring(b.length)}if(e.indexOf(c)==e.length-c.length){e=e.substring(0,e.length-c.length);g=c}return f+'<a href="'+e+'">'+e+"</a>"+g})},getSyntaxHighlighterScriptTags:function(){var c=document.getElementsByTagName("script"),b=[];for(var d=0;d<c.length;d++){if(c[d].type=="syntaxhighlighter"){b.push(c[d])}}return b},stripCData:function(c){var d="<![CDATA[",b="]]>",f=a.utils.trim(c),e=false;if(f.indexOf(d)==0){f=f.substring(d.length);e=true}if(f.indexOf(b)==f.length-b.length){f=f.substring(0,f.length-b.length);e=true}return e?f:c}},highlight:function(h,f){function e(s){var q=[];for(var r=0;r<s.length;r++){q.push(s[r])}return q}var b=f?[f]:e(document.getElementsByTagName(a.config.tagName)),j="innerHTML",n=null,l=a.config;if(l.useScriptTags){b=b.concat(a.utils.getSyntaxHighlighterScriptTags())}if(b.length===0){return}for(var g=0;g<b.length;g++){var k=b[g],d=a.utils.parseParams(k.className),o,c,p;d=a.utils.merge(h,d);o=d.brush;if(o==null){continue}if(d["html-script"]=="true"||a.defaults["html-script"]==true){n=new a.HtmlScript(o);o="htmlscript"}else{var m=a.utils.findBrush(o);if(m){o=m.name;n=new m()}else{continue}}c=k[j];if(l.useScriptTags){c=a.utils.stripCData(c)}d["brush-name"]=o;n.highlight(c,d);p=n.div;if(a.config.debug){p=document.createElement("textarea");p.value=n.div.innerHTML;p.style.width="70em";p.style.height="30em"}k.parentNode.replaceChild(p,k)}},all:function(b){a.utils.addEvent(window,"load",function(){a.highlight(b)})}};a.Match=function(d,b,c){this.value=d;this.index=b;this.length=d.length;this.css=c;this.brushName=null};a.Match.prototype.toString=function(){return this.value};a.HtmlScript=function(b){var d=a.utils.findBrush(b),c,h=new a.brushes.Xml(),g=null;if(d==null){return}c=new d();this.xmlBrush=h;if(c.htmlScript==null){a.utils.alert(a.config.strings.brushNotHtmlScript+b);return}h.regexList.push({regex:c.htmlScript.code,func:f});function e(k,l){for(var i=0;i<k.length;i++){k[i].index+=l}}function f(r,l){var k=r.code,q=[],p=c.regexList,n=r.index+r.left.length,s=c.htmlScript,t;for(var o=0;o<p.length;o++){t=a.utils.getMatches(k,p[o]);e(t,n);q=q.concat(t)}if(s.left!=null&&r.left!=null){t=a.utils.getMatches(r.left,s.left);e(t,r.index);q=q.concat(t)}if(s.right!=null&&r.right!=null){t=a.utils.getMatches(r.right,s.right);e(t,r.index+r[0].lastIndexOf(r.right));q=q.concat(t)}for(var m=0;m<q.length;m++){q[m].brushName=d.name}return q}};a.HtmlScript.prototype.highlight=function(b,c){this.xmlBrush.highlight(b,c);this.div=this.xmlBrush.div};a.Highlighter=function(){};a.Highlighter.prototype={getParam:function(d,c){var b=this.params[d];return a.utils.toBoolean(b==null?c:b)},create:function(b){return document.createElement(b)},findMatches:function(e,d){var b=[];if(e!=null){for(var c=0;c<e.length;c++){if(typeof(e[c])=="object"){b=b.concat(a.utils.getMatches(d,e[c]))}}}return b.sort(a.utils.matchesSortCallback)},removeNestedMatches:function(){var f=this.matches;for(var e=0;e<f.length;e++){if(f[e]===null){continue}var b=f[e],d=b.index+b.length;for(var c=e+1;c<f.length&&f[e]!==null;c++){var g=f[c];if(g===null){continue}else{if(g.index>d){break}else{if(g.index==b.index&&g.length>b.length){this.matches[e]=null}else{if(g.index>=b.index&&g.index<d){this.matches[c]=null}}}}}}},createDisplayLines:function(b){var n=b.split(/\n/g),l=parseInt(this.getParam("first-line")),h=this.getParam("pad-line-numbers"),m=this.getParam("highlight",[]),f=this.getParam("gutter");b="";if(h==true){h=(l+n.length-1).toString().length}else{if(isNaN(h)==true){h=0}}for(var g=0;g<n.length;g++){var o=n[g],c=/^(&nbsp;|\s)+/.exec(o),k="alt"+(g%2==0?1:2),d=a.utils.padNumber(l+g,h),e=a.utils.indexOf(m,(l+g).toString())!=-1,j=null;if(c!=null){j=c[0].toString();o=o.substr(j.length)}o=a.utils.trim(o);if(o.length==0){o="&nbsp;"}if(e){k+=" highlighted"}b+='<div class="line '+k+'"><table><tr>'+(f?'<td class="number"><code>'+d+"</code></td>":"")+'<td class="content">'+(j!=null?'<code class="spaces">'+j.replace(" ","&nbsp;")+"</code>":"")+o+"</td></tr></table></div>"}return b},processMatches:function(b,h){var j=0,l="",c=a.utils.decorate,k=this.getParam("brush-name","");function e(m){var i=m?(m.brushName||k):k;return i?i+" ":""}for(var f=0;f<h.length;f++){var g=h[f],d;if(g===null||g.length===0){continue}d=e(g);l+=c(b.substr(j,g.index-j),d+"plain")+c(g.value,d+g.css);j=g.index+g.length}l+=c(b.substr(j),e()+"plain");return l},highlight:function(c,e){var j=a.config,k=a.vars,b,g,h,d="important";this.params={};this.div=null;this.lines=null;this.code=null;this.bar=null;this.toolbarCommands={};this.id=a.utils.guid("highlighter_");k.highlighters[this.id]=this;if(c===null){c=""}this.params=a.utils.merge(a.defaults,e||{});if(this.getParam("light")==true){this.params.toolbar=this.params.gutter=false}this.div=b=this.create("DIV");this.lines=this.create("DIV");this.lines.className="lines";className="syntaxhighlighter";b.id=this.id;if(this.getParam("collapse")){className+=" collapsed"}if(this.getParam("gutter")==false){className+=" nogutter"}if(this.getParam("wrap-lines")==false){this.lines.className+=" no-wrap"}className+=" "+this.getParam("class-name");className+=" "+this.getParam("brush-name");b.className=className;this.originalCode=c;this.code=a.utils.trimFirstAndLastLines(c).replace(/\r/g," ");h=this.getParam("tab-size");this.code=this.getParam("smart-tabs")==true?a.utils.processSmartTabs(this.code,h):a.utils.processTabs(this.code,h);this.code=a.utils.unindent(this.code);if(this.getParam("toolbar")){this.bar=this.create("DIV");this.bar.className="bar";this.bar.appendChild(a.toolbar.create(this));b.appendChild(this.bar);var i=this.bar;function f(){i.className=i.className.replace("show","")}b.onmouseover=function(){f();i.className+=" show"};b.onmouseout=function(){f()}}b.appendChild(this.lines);this.matches=this.findMatches(this.regexList,this.code);this.removeNestedMatches();c=this.processMatches(this.code,this.matches);c=this.createDisplayLines(a.utils.trim(c));if(this.getParam("auto-links")){c=a.utils.processUrls(c)}this.lines.innerHTML=c},getKeywords:function(b){b=b.replace(/^\s+|\s+$/g,"").replace(/\s+/g,"|");return"\\b(?:"+b+")\\b"},forHtmlScript:function(b){this.htmlScript={left:{regex:b.left,css:"script"},right:{regex:b.right,css:"script"},code:new XRegExp("(?<left>"+b.left.source+")(?<code>.*?)(?<right>"+b.right.source+")","sgi")}}};return a}()}if(!window.XRegExp){(function(){var e={exec:RegExp.prototype.exec,match:String.prototype.match,replace:String.prototype.replace,split:String.prototype.split},d={part:/(?:[^\\([#\s.]+|\\(?!k<[\w$]+>|[pP]{[^}]+})[\S\s]?|\((?=\?(?!#|<[\w$]+>)))+|(\()(?:\?(?:(#)[^)]*\)|<([$\w]+)>))?|\\(?:k<([\w$]+)>|[pP]{([^}]+)})|(\[\^?)|([\S\s])/g,replaceVar:/(?:[^$]+|\$(?![1-9$&`']|{[$\w]+}))+|\$(?:([1-9]\d*|[$&`'])|{([$\w]+)})/g,extended:/^(?:\s+|#.*)+/,quantifier:/^(?:[?*+]|{\d+(?:,\d*)?})/,classLeft:/&&\[\^?/g,classRight:/]/g},b=function(j,g,h){for(var f=h||0;f<j.length;f++){if(j[f]===g){return f}}return -1},c=/()??/.exec("")[1]!==undefined,a={};XRegExp=function(o,i){if(o instanceof RegExp){if(i!==undefined){throw TypeError("can't supply flags when constructing one RegExp from another")}return o.addFlags()}var i=i||"",f=i.indexOf("s")>-1,k=i.indexOf("x")>-1,p=false,r=[],h=[],g=d.part,l,j,n,m,q;g.lastIndex=0;while(l=e.exec.call(g,o)){if(l[2]){if(!d.quantifier.test(o.slice(g.lastIndex))){h.push("(?:)")}}else{if(l[1]){r.push(l[3]||null);if(l[3]){p=true}h.push("(")}else{if(l[4]){m=b(r,l[4]);h.push(m>-1?"\\"+(m+1)+(isNaN(o.charAt(g.lastIndex))?"":"(?:)"):l[0])}else{if(l[5]){h.push(a.unicode?a.unicode.get(l[5],l[0].charAt(1)==="P"):l[0])}else{if(l[6]){if(o.charAt(g.lastIndex)==="]"){h.push(l[6]==="["?"(?!)":"[\\S\\s]");g.lastIndex++}else{j=XRegExp.matchRecursive("&&"+o.slice(l.index),d.classLeft,d.classRight,"",{escapeChar:"\\"})[0];h.push(l[6]+j+"]");g.lastIndex+=j.length+1}}else{if(l[7]){if(f&&l[7]==="."){h.push("[\\S\\s]")}else{if(k&&d.extended.test(l[7])){n=e.exec.call(d.extended,o.slice(g.lastIndex-1))[0].length;if(!d.quantifier.test(o.slice(g.lastIndex-1+n))){h.push("(?:)")}g.lastIndex+=n-1}else{h.push(l[7])}}}else{h.push(l[0])}}}}}}}q=RegExp(h.join(""),e.replace.call(i,/[sx]+/g,""));q._x={source:o,captureNames:p?r:null};return q};XRegExp.addPlugin=function(f,g){a[f]=g};RegExp.prototype.exec=function(k){var h=e.exec.call(this,k),g,j,f;if(h){if(c&&h.length>1){f=new RegExp("^"+this.source+"$(?!\\s)",this.getNativeFlags());e.replace.call(h[0],f,function(){for(j=1;j<arguments.length-2;j++){if(arguments[j]===undefined){h[j]=undefined}}})}if(this._x&&this._x.captureNames){for(j=1;j<h.length;j++){g=this._x.captureNames[j-1];if(g){h[g]=h[j]}}}if(this.global&&this.lastIndex>(h.index+h[0].length)){this.lastIndex--}}return h}})()}RegExp.prototype.getNativeFlags=function(){return(this.global?"g":"")+(this.ignoreCase?"i":"")+(this.multiline?"m":"")+(this.extended?"x":"")+(this.sticky?"y":"")};RegExp.prototype.addFlags=function(a){var b=new XRegExp(this.source,(a||"")+this.getNativeFlags());if(this._x){b._x={source:this._x.source,captureNames:this._x.captureNames?this._x.captureNames.slice(0):null}}return b};RegExp.prototype.call=function(a,b){return this.exec(b)};RegExp.prototype.apply=function(b,a){return this.exec(a[0])};XRegExp.cache=function(c,a){var b="/"+c+"/"+(a||"");return XRegExp.cache[b]||(XRegExp.cache[b]=new XRegExp(c,a))};XRegExp.escape=function(a){return a.replace(/[-[\]{}()*+?.\\^$|,#\s]/g,"\\$&")};XRegExp.matchRecursive=function(p,d,s,f,b){var b=b||{},v=b.escapeChar,k=b.valueNames,f=f||"",q=f.indexOf("g")>-1,c=f.indexOf("i")>-1,h=f.indexOf("m")>-1,u=f.indexOf("y")>-1,f=f.replace(/y/g,""),d=d instanceof RegExp?(d.global?d:d.addFlags("g")):new XRegExp(d,"g"+f),s=s instanceof RegExp?(s.global?s:s.addFlags("g")):new XRegExp(s,"g"+f),i=[],a=0,j=0,n=0,l=0,m,e,o,r,g,t;if(v){if(v.length>1){throw SyntaxError("can't supply more than one escape character")}if(h){throw TypeError("can't supply escape character when using the multiline flag")}g=XRegExp.escape(v);t=new RegExp("^(?:"+g+"[\\S\\s]|(?:(?!"+d.source+"|"+s.source+")[^"+g+"])+)+",c?"i":"")}while(true){d.lastIndex=s.lastIndex=n+(v?(t.exec(p.slice(n))||[""])[0].length:0);o=d.exec(p);r=s.exec(p);if(o&&r){if(o.index<=r.index){r=null}else{o=null}}if(o||r){j=(o||r).index;n=(o?d:s).lastIndex}else{if(!a){break}}if(u&&!a&&j>l){break}if(o){if(!a++){m=j;e=n}}else{if(r&&a){if(!--a){if(k){if(k[0]&&m>l){i.push([k[0],p.slice(l,m),l,m])}if(k[1]){i.push([k[1],p.slice(m,e),m,e])}if(k[2]){i.push([k[2],p.slice(e,j),e,j])}if(k[3]){i.push([k[3],p.slice(j,n),j,n])}}else{i.push(p.slice(e,j))}l=n;if(!q){break}}}else{d.lastIndex=s.lastIndex=0;throw Error("subject data contains unbalanced delimiters")}}if(j===n){n++}}if(q&&!u&&k&&k[0]&&p.length>l){i.push([k[0],p.slice(l),l,p.length])}d.lastIndex=s.lastIndex=0;return i};SyntaxHighlighter.brushes.CSS=function(){function a(f){return"\\b([a-z_]|)"+f.replace(/ /g,"(?=:)\\b|\\b([a-z_\\*]|\\*|)")+"(?=:)\\b"}function c(f){return"\\b"+f.replace(/ /g,"(?!-)(?!:)\\b|\\b()")+":\\b"}var d="ascent azimuth background-attachment background-color background-image background-position background-repeat background baseline bbox border-collapse border-color border-spacing border-style border-top border-right border-bottom border-left border-top-color border-right-color border-bottom-color border-left-color border-top-style border-right-style border-bottom-style border-left-style border-top-width border-right-width border-bottom-width border-left-width border-width border bottom cap-height caption-side centerline clear clip color content counter-increment counter-reset cue-after cue-before cue cursor definition-src descent direction display elevation empty-cells float font-size-adjust font-family font-size font-stretch font-style font-variant font-weight font height left letter-spacing line-height list-style-image list-style-position list-style-type list-style margin-top margin-right margin-bottom margin-left margin marker-offset marks mathline max-height max-width min-height min-width orphans outline-color outline-style outline-width outline overflow padding-top padding-right padding-bottom padding-left padding page page-break-after page-break-before page-break-inside pause pause-after pause-before pitch pitch-range play-during position quotes right richness size slope src speak-header speak-numeral speak-punctuation speak speech-rate stemh stemv stress table-layout text-align top text-decoration text-indent text-shadow text-transform unicode-bidi unicode-range units-per-em vertical-align visibility voice-family volume white-space widows width widths word-spacing x-height z-index";var b="above absolute all always aqua armenian attr aural auto avoid baseline behind below bidi-override black blink block blue bold bolder both bottom braille capitalize caption center center-left center-right circle close-quote code collapse compact condensed continuous counter counters crop cross crosshair cursive dashed decimal decimal-leading-zero default digits disc dotted double embed embossed e-resize expanded extra-condensed extra-expanded fantasy far-left far-right fast faster fixed format fuchsia gray green groove handheld hebrew help hidden hide high higher icon inline-table inline inset inside invert italic justify landscape large larger left-side left leftwards level lighter lime line-through list-item local loud lower-alpha lowercase lower-greek lower-latin lower-roman lower low ltr marker maroon medium message-box middle mix move narrower navy ne-resize no-close-quote none no-open-quote no-repeat normal nowrap n-resize nw-resize oblique olive once open-quote outset outside overline pointer portrait pre print projection purple red relative repeat repeat-x repeat-y rgb ridge right right-side rightwards rtl run-in screen scroll semi-condensed semi-expanded separate se-resize show silent silver slower slow small small-caps small-caption smaller soft solid speech spell-out square s-resize static status-bar sub super sw-resize table-caption table-cell table-column table-column-group table-footer-group table-header-group table-row table-row-group teal text-bottom text-top thick thin top transparent tty tv ultra-condensed ultra-expanded underline upper-alpha uppercase upper-latin upper-roman url visible wait white wider w-resize x-fast x-high x-large x-loud x-low x-slow x-small x-soft xx-large xx-small yellow";var e="[mM]onospace [tT]ahoma [vV]erdana [aA]rial [hH]elvetica [sS]ans-serif [sS]erif [cC]ourier mono sans serif";this.regexList=[{regex:SyntaxHighlighter.regexLib.multiLineCComments,css:"comments"},{regex:SyntaxHighlighter.regexLib.doubleQuotedString,css:"string"},{regex:SyntaxHighlighter.regexLib.singleQuotedString,css:"string"},{regex:/\#[a-fA-F0-9]{3,6}/g,css:"value"},{regex:/(-?\d+)(\.\d+)?(px|em|pt|\:|\%|)/g,css:"value"},{regex:/!important/g,css:"color3"},{regex:new RegExp(a(d),"gm"),css:"keyword"},{regex:new RegExp(c(b),"g"),css:"value"},{regex:new RegExp(this.getKeywords(e),"g"),css:"color1"}];this.forHtmlScript({left:/(&lt;|<)\s*style.*?(&gt;|>)/gi,right:/(&lt;|<)\/\s*style\s*(&gt;|>)/gi})};SyntaxHighlighter.brushes.CSS.prototype=new SyntaxHighlighter.Highlighter();SyntaxHighlighter.brushes.CSS.aliases=["css"];SyntaxHighlighter.brushes.JScript=function(){var a="break case catch continue default delete do else false  for function if in instanceof new null return super switch this throw true try typeof var while with";this.regexList=[{regex:SyntaxHighlighter.regexLib.singleLineCComments,css:"comments"},{regex:SyntaxHighlighter.regexLib.multiLineCComments,css:"comments"},{regex:SyntaxHighlighter.regexLib.doubleQuotedString,css:"string"},{regex:SyntaxHighlighter.regexLib.singleQuotedString,css:"string"},{regex:/\s*#.*/gm,css:"preprocessor"},{regex:new RegExp(this.getKeywords(a),"gm"),css:"keyword"}];this.forHtmlScript(SyntaxHighlighter.regexLib.scriptScriptTags)};SyntaxHighlighter.brushes.JScript.prototype=new SyntaxHighlighter.Highlighter();SyntaxHighlighter.brushes.JScript.aliases=["js","jscript","javascript"];SyntaxHighlighter.brushes.Xml=function(){function a(e,i){var f=SyntaxHighlighter.Match,h=e[0],c=new XRegExp("(&lt;|<)[\\s\\/\\?]*(?<name>[:\\w-\\.]+)","xg").exec(h),b=[];if(e.attributes!=null){var d,g=new XRegExp("(?<name> [\\w:\\-\\.]+)\\s*=\\s*(?<value> \".*?\"|'.*?'|\\w+)","xg");while((d=g.exec(h))!=null){b.push(new f(d.name,e.index+d.index,"color1"));b.push(new f(d.value,e.index+d.index+d[0].indexOf(d.value),"string"))}}if(c!=null){b.push(new f(c.name,e.index+c[0].indexOf(c.name),"keyword"))}return b}this.regexList=[{regex:new XRegExp("(\\&lt;|<)\\!\\[[\\w\\s]*?\\[(.|\\s)*?\\]\\](\\&gt;|>)","gm"),css:"color2"},{regex:SyntaxHighlighter.regexLib.xmlComments,css:"comments"},{regex:new XRegExp("(&lt;|<)[\\s\\/\\?]*(\\w+)(?<attributes>.*?)[\\s\\/\\?]*(&gt;|>)","sg"),func:a}]};SyntaxHighlighter.brushes.Xml.prototype=new SyntaxHighlighter.Highlighter();SyntaxHighlighter.brushes.Xml.aliases=["xml","xhtml","xslt","html"];SyntaxHighlighter.brushes.Php=function(){var a="abs acos acosh addcslashes addslashes array_change_key_case array_chunk array_combine array_count_values array_diff array_diff_assoc array_diff_key array_diff_uassoc array_diff_ukey array_fill array_filter array_flip array_intersect array_intersect_assoc array_intersect_key array_intersect_uassoc array_intersect_ukey array_key_exists array_keys array_map array_merge array_merge_recursive array_multisort array_pad array_pop array_product array_push array_rand array_reduce array_reverse array_search array_shift array_slice array_splice array_sum array_udiff array_udiff_assoc array_udiff_uassoc array_uintersect array_uintersect_assoc array_uintersect_uassoc array_unique array_unshift array_values array_walk array_walk_recursive atan atan2 atanh base64_decode base64_encode base_convert basename bcadd bccomp bcdiv bcmod bcmul bindec bindtextdomain bzclose bzcompress bzdecompress bzerrno bzerror bzerrstr bzflush bzopen bzread bzwrite ceil chdir checkdate checkdnsrr chgrp chmod chop chown chr chroot chunk_split class_exists closedir closelog copy cos cosh count count_chars date decbin dechex decoct deg2rad delete ebcdic2ascii echo empty end ereg ereg_replace eregi eregi_replace error_log error_reporting escapeshellarg escapeshellcmd eval exec exit exp explode extension_loaded feof fflush fgetc fgetcsv fgets fgetss file_exists file_get_contents file_put_contents fileatime filectime filegroup fileinode filemtime fileowner fileperms filesize filetype floatval flock floor flush fmod fnmatch fopen fpassthru fprintf fputcsv fputs fread fscanf fseek fsockopen fstat ftell ftok getallheaders getcwd getdate getenv gethostbyaddr gethostbyname gethostbynamel getimagesize getlastmod getmxrr getmygid getmyinode getmypid getmyuid getopt getprotobyname getprotobynumber getrandmax getrusage getservbyname getservbyport gettext gettimeofday gettype glob gmdate gmmktime ini_alter ini_get ini_get_all ini_restore ini_set interface_exists intval ip2long is_a is_array is_bool is_callable is_dir is_double is_executable is_file is_finite is_float is_infinite is_int is_integer is_link is_long is_nan is_null is_numeric is_object is_readable is_real is_resource is_scalar is_soap_fault is_string is_subclass_of is_uploaded_file is_writable is_writeable mkdir mktime nl2br parse_ini_file parse_str parse_url passthru pathinfo readlink realpath rewind rewinddir rmdir round str_ireplace str_pad str_repeat str_replace str_rot13 str_shuffle str_split str_word_count strcasecmp strchr strcmp strcoll strcspn strftime strip_tags stripcslashes stripos stripslashes stristr strlen strnatcasecmp strnatcmp strncasecmp strncmp strpbrk strpos strptime strrchr strrev strripos strrpos strspn strstr strtok strtolower strtotime strtoupper strtr strval substr substr_compare";var c="and or xor array as break case cfunction class const continue declare default die do else elseif enddeclare endfor endforeach endif endswitch endwhile extends for foreach function include include_once global if new old_function return static switch use require require_once var while abstract interface public implements extends private protected throw";var b="__FILE__ __LINE__ __METHOD__ __FUNCTION__ __CLASS__";this.regexList=[{regex:SyntaxHighlighter.regexLib.singleLineCComments,css:"comments"},{regex:SyntaxHighlighter.regexLib.multiLineCComments,css:"comments"},{regex:SyntaxHighlighter.regexLib.doubleQuotedString,css:"string"},{regex:SyntaxHighlighter.regexLib.singleQuotedString,css:"string"},{regex:/\$\w+/g,css:"variable"},{regex:new RegExp(this.getKeywords(a),"gmi"),css:"functions"},{regex:new RegExp(this.getKeywords(b),"gmi"),css:"constants"},{regex:new RegExp(this.getKeywords(c),"gm"),css:"keyword"}];this.forHtmlScript(SyntaxHighlighter.regexLib.phpScriptTags)};SyntaxHighlighter.brushes.Php.prototype=new SyntaxHighlighter.Highlighter();SyntaxHighlighter.brushes.Php.aliases=["php"];SyntaxHighlighter.brushes.Plain=function(){};SyntaxHighlighter.brushes.Plain.prototype=new SyntaxHighlighter.Highlighter();SyntaxHighlighter.brushes.Plain.aliases=["text","plain"];
/* Init SyntaxHighlighter */
SyntaxHighlighter.all();