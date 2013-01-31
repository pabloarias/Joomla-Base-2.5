((function(){var a=function(){var b=document.id("rt-transition");if(Browser.Engine.gecko19||(Browser.Engine.trident&&!Browser.Engine.trident7)){if(b){b.set("tween",{duration:800,transition:"quad:out"});
b.setStyles({visibility:"hidden",opacity:0});b.removeClass("rt-hidden").fade("in");}return;}if(b){b.removeClass("rt-hidden").addClass("rt-visible");}};
window.addEvent("load",a);})());