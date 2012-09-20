((function(){var b=function(){var a=document.id("rt-transition");if(Browser.Engine.gecko19||(Browser.Engine.trident&&!Browser.Engine.trident7)){if(a){a.set("tween",{duration:800,transition:"quad:out"});
a.setStyles({visibility:"hidden",opacity:0});a.removeClass("rt-hidden").fade("in");}return;}if(a){a.removeClass("rt-hidden").addClass("rt-visible");}};
window.addEvent("load",b);})());