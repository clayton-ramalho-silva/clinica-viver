/*	MooTools wrapper to embed QuickTime movies.	license: MIT-style,	author: Jose Prado	*/
(function(){var a=["begin","loadedmetadata","loadedfirstframe","canplay","canplaythrough","durationchange","load","ended","error","pause","play","progress","waiting","stalled","timechanged","volumechange"];Quickie=new Class({Implements:[Options,Events],version:"2.1",options:{id:null,height:1,width:1,container:null,attributes:{controller:"true",postdomevents:"true"}},initialize:function(e,d){this.setOptions(d);d=this.options;this.id=this.options.id||"Quickie_"+$time();this.path=e;var c=d.container;d.attributes=$H(d.attributes);d.attributes.src=e;this.html=this.toHTML();if(Browser.Engine.trident){document.getElementById(c).innerHTML=this.html;this.quickie=document.getElementById(this.id);this.ieFix.delay(10,this)}else{var f=document.createElement("div");f.innerHTML=this.html;this.quickie=f.firstChild;this.transferEvents();document.id(c).empty();document.getElementById(c).appendChild(this.quickie)}},toHTML:function(){if(!this.html){var d=this.options.attributes,c=(d.controller=="true")?this.options.height+16:this.options.height,f=this.options.width,e="";if(Browser.Engine.trident){e='<object id="'+this.id+'" ';e+='width="'+f+'" ';e+='height="'+c+'" ';e+='classid="clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B" ';e+='style="behavior:url(#qt_event_source);" ';e+='codebase="http://www.apple.com/qtactivex/qtplugin.cab">';d.each(function(h,g){e+='<param name="'+g+'" value="'+h+'" />'});e+="</object>"}else{e='<embed id="'+this.id+'" ';e+='width="'+f+'" ';e+='height="'+c+'" ';e+='pluginspage="http://www.apple.com/quicktime/download/" ';d.each(function(h,g){e+=g+'="'+h+'" '});e+="/>"}this.html=e}return this.html},ieFix:function(){document.getElementById(this.id).SetResetPropertiesOnReload(false);document.getElementById(this.id).SetURL(this.path);this.transferEvents.delay(10,this)},transferEvents:function(){var c=this.quickie;a.each(function(d){b(c,d,this.fireEvent.pass(d,this))}.bind(this))}});function b(e,g,d,c){g="qt_"+g;if(e.addEventListener){e.addEventListener(g,d,c);return true}else{if(e.attachEvent){var f=e.attachEvent("on"+g,d);return f}else{e[g]=d}}}})();Browser.Plugins.QuickTime=(function(){if(navigator.plugins){for(var b=0,a=navigator.plugins.length;b<a;b++){if(navigator.plugins[b].name.indexOf("QuickTime")>=0){return true}}}else{try{var d=new ActiveXObject("QuickTime.QuickTime")}catch(c){}if(d){return true}}return false})();