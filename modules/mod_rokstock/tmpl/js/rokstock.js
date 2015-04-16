/*
 * @author RocketTheme, LLC http://www.rockettheme.com
 * @copyright Copyright (C) 2007 - 2012 RocketTheme, LLC
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */
var RokStock=new Class({Implements:[Events,Options],version:"0.6",options:{types:["type0","type1","type2","type3","type4"],chartURL:"http://www.google.com/finance/chart?cht=c&q=",detailURL:"",comparison:4,errorColor:"#dd8888",warnColor:"#f0ce94",okColor:"#acdd88",externalLinks:true,cookie:true,cookieDuration:30,mainChart:true,toolTips:false,autoupdate:false,updatedelay:5000},initialize:function(b){this.setOptions(b);
this.container=document.id("rokstock");if(!this.container){return;}this.ajaxDetail=new Request.HTML({url:this.options.detailURL,method:"get",onComplete:this.addTicker.bind(this)});
this.ajaxUpdate=new Request.HTML({url:this.options.detailURL,method:"get",onComplete:this.refresh.bind(this)});this.rowsContainer=this.container.getElement(".rokstock-list");
this.rows=this.container.getElements(".row");this.circles=this.container.getElements(".legend").setStyle("cursor","move");this.indexes=this.circles.getNext().get("rel");
this.comparison=this.container.getElement(".rokstock-comparison");this.tooltip=this.container.getElement(".rokstock-tooltip");if(this.tooltip&&this.options.toolTips){this.tooltipInit();
}if(this.options.mainChart){this.graphContainer=this.container.getElement(".rokstock-image").setStyle("position","relative");}this.input=this.container.getElement(".rokstock-add input");
this.deleters=this.container.getElements(".delete");this.refresher=this.container.getElement(".rokstock-add .rokstock-reload");this.inputFx=new Fx.Tween(this.input,{duration:300});
if(this.options.mainChart){this.graphSpinner=new Element("div",{"class":"centerloader",styles:{position:"absolute",left:0,top:0,width:this.graphContainer.getSize().x,height:this.graphContainer.getSize().y}}).inject(this.graphContainer);
}if(this.options.mainChart){this.graphFx=new Fx.Tween(this.graphSpinner,{link:"cancel",duration:300}).set("opacity",0);}this.sortables=new Sortables(this.rowsContainer,{ghost:false,handles:this.circles,onStart:this.moveStart.bind(this),onComplete:this.moveEnd.bind(this)});
if(this.options.externalLinks){this.container.getElements(".external").set("target","_blank");}this.inputStart=this.input.value;var a=this;this.input.addEvents({focus:function(){if(this.value==a.inputStart){this.value="";
this.removeClass("rokstock-note");}},blur:function(){if(this.value==""){this.addClass("rokstock-note");this.value=a.inputStart;}}});if(this.options.mainChart){this.comparisonEvent();
}this.inputEvent();this.refreshEvent();this.deletersEvent();if(this.options.autoupdate){this.refresher.fireEvent("click");}},comparisonEvent:function(){var a=this;
this.comparison.addEvent("change",function(){var b=this.value.replace("count","").toInt();a.setOptions({comparison:b});a.updateComparison();});},inputEvent:function(){var a=this;
this.input.addEvent("keyup",function(b){if(b.key=="enter"&&!a.ajaxDetail.isRunning()){this.value=this.value.toUpperCase();if(this.value.length&&a.indexes.indexOf(this.value)==-1){a.ajaxDetail.cancel();
a.input.addClass("loading");a.ajaxDetail.get(a.ajaxDetail.options.url+"&output_type=detail&detail_values="+this.value);}else{a.inputFx.start("background-color",[a.options.warnColor,a.input.getStyle("background-color")]);
}}});},refreshEvent:function(){this.refresher.addEvent("click",function(){if(this.ajaxUpdate.isRunning()||!this.rows.length){return;}this.input.addClass("loading");
this.sortables.detach();this.ajaxUpdate.get(this.ajaxUpdate.options.url+"&values="+this.indexes.join(","));}.bind(this));},deletersEvent:function(){var a=this;
this.deleters.each(function(b,c){this.deleteEventFunction(b);},this);},deleteEventFunction:function(a){a.addEvent("click",function(){var b=this.rows.indexOf(a.getParent().getParent());
var c=new Fx.Tween(this.rows[b],{duration:300}).set("opacity",1);c.start("opacity",0).chain(function(){this.rows[b].dispose();this.sortables.detach();this.rows=this.container.getElements(".row");
this.circles=this.container.getElements(".legend").setStyle("cursor","move");this.indexes=this.circles.getNext().get("rel");this.deleters=this.container.getElements(".delete");
this.sortables.elements.erase(a.getParent().getParent());this.sortables.attach();this.store();this.reorderTypes();if(this.options.mainChart){this.loadGraph();
}else{this.sortables.attach();}}.bind(this));}.bind(this));},addTicker:function(c,h,b){var a=this;this.input.removeClass("loading");if(b=="false\n"){this.inputFx.start("background-color",[this.options.errorColor,this.input.getStyle("background-color")]);
}else{var e=new Element("div").set("html",b);var g=e.getElements(".row");if(a.options.externalLinks){e.getElements(".external").set("target","_blank");
}var d=[],f=[];g.each(function(l,k){var j=l.getElement("a").get("rel");j=this.indexes.indexOf(j);if(j==-1){d.push(l);f.push(new Fx.Tween(l,{duration:300}).set("opacity",0));
}},this);if(!d.length){this.inputFx.start("background-color",[this.options.warnColor,this.input.getStyle("background-color")]);}else{d.each(function(j,k){j.inject(a.rowsContainer);
var l=j.getElement(".delete");this.reorderTypes();this.rows.push(j);this.updateSortable(j);this.updateCompList();this.deleteEventFunction(l);this.tooltipEvents(j.getElements(".title a"));
this.store();if(this.options.mainChart){this.loadGraph();}else{this.sortables.attach();}f[k].start("opacity",1);this.inputFx.start("background-color",[this.options.okColor,this.input.getStyle("background-color")]);
},this);}}},refresh:function(b,e,a){if(a=="false\n"){return;}var c=new Element("div").set("html",a);var d=c.getElement(".rokstock-list");if(this.options.mainChart){this.loadGraph();
}else{this.sortables.attach();}d.replaces(this.rowsContainer);this.circles=this.container.getElements(".legend").setStyle("cursor","move");this.rowsContainer=this.container.getElement(".rokstock-list");
this.rows=this.container.getElements(".row");this.deleters=this.container.getElements(".delete");this.sortables.addLists($$(this.rowsContainer));this.reorderTypes();
this.deletersEvent();if(this.tooltip&&this.options.toolTips){this.tooltipEvents();}this.sortables.attach();this.store();this.input.removeClass("loading");
if(this.options.autoupdate){this.refresher.fireEvent(this.options.updatedelay,"click");}},tooltipInit:function(){this.tooltip.inject(document.body);this.tooltipEvents();
this.tooltipAjax=new Request.HTML({url:this.options.detailURL,method:"get",onComplete:this.tooltipUpdate.bind(this),onCancel:function(){this.input.removeClass("loading");
}.bind(this)});this.tooltipFx=new Fx.Tween(this.tooltip,{duration:300,link:"cancel",transition:Fx.Transitions.Back.easeOut}).set("opacity",0);this.tooltip.setStyle("display","block");
},tooltipEvents:function(a,b){((a)?$$(a):this.rows.getElement(".title a")).each(function(d,c){d.addEvents({mouseenter:function(){var e=this.rows.indexOf(d.getParent().getParent());
this.input.addClass("loading");this.tooltipAjax.cancel();this.tooltipAjax.tmp=e;this.tooltipAjax.get(this.tooltipAjax.options.url+"&output_type=moredetails&details_value="+this.indexes[e]);
}.bind(this),mouseleave:function(){this.tooltipAjax.cancel();this.tooltipFx.cancel().start("opacity",0);}.bind(this)});},this);this.container.addEvent("mouseleave",function(){this.tooltipFx.cancel().start("opacity",0);
}.bind(this));},tooltipUpdate:function(b,d,a){this.tooltipFx.cancel();this.tooltip.empty().set("html",a);var c=this.rows[this.tooltipAjax.tmp].getCoordinates();
var f=this.tooltip.getSize();var e={};e.left=c.left-f.x;if(e.left<0){e.left=c.left+c.width;}e.top=c.top;this.tooltip.setStyles(e);this.input.removeClass("loading");
this.tooltipFx.start("opacity",1);},updateComparison:function(){this.reorderTypes();this.sortables.detach();if(this.options.mainChart){this.loadGraph();
}else{this.sortables.attach();}},updateCompList:function(){},updateSortable:function(a){},moveStart:function(){},moveEnd:function(){var b=this.circles.getNext().get("rel").splice(0,this.options.comparison);
this.reorderTypes();var a=this.circles.getNext().get("rel").splice(0,this.options.comparison);b=b.join(",");a=a.join(",");if(b!==a){this.sortables.detach();
if(this.options.mainChart){this.loadGraph();}else{this.sortables.attach();}}this.rows=this.container.getElements(".row");this.store();},reorderTypes:function(){if(!this.options.mainChart){this.options.comparison=0;
}this.circles=this.container.getElements(".legend").setStyle("cursor","move");(this.options.types.length).times(function(a){this.circles.removeClass(this.options.types[a]);
}.bind(this));this.circles.each(function(b,a){if(a<this.options.comparison){b.addClass(this.options.types[a]);}else{b.addClass(this.options.types[this.options.types.length-1]);
}},this);this.indexes=this.circles.getNext().get("rel");},loadGraph:function(){var a=this,d,b=this.circles.length,c=this.options.comparison;if(b<1){return;
}this.graphFx.start("opacity",1).chain(function(){if(c==1||b==1){d=a.circles[0].getNext().get("rel");}else{if(c==2||b==2){d=a.circles[0].getNext().get("rel")+","+a.circles[1].getNext().get("rel");
}else{if(c==3||b==3){d=a.circles[0].getNext().get("rel")+","+a.circles[1].getNext().get("rel")+","+a.circles[2].getNext().get("rel");}else{d=a.circles[0].getNext().get("rel")+","+a.circles[1].getNext().get("rel")+","+a.circles[2].getNext().getProperty("rel")+","+a.circles[3].getNext().get("rel");
}}}new Asset.image(a.options.chartURL+d+"&nocache="+$time(),{onload:function(){this.replaces(a.graphContainer.getFirst());a.graphFx.start("opacity",0);
a.sortables.attach();}});});},store:function(){if(this.options.cookie){Cookie.write("rokstock_tickers",this.indexes.join(","),{duration:this.options.cookieDuration,path:"/"});
}}});