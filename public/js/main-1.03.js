/*
 *  Document   : main.js
 *  Author     : pixelcave
 */
var webApp=function(){var e=$("body"),t=$("header"),n=$("#sidebar-left-toggle"),a=$("#sidebar-right-toggle"),i=$(".sidebar-left-scroll"),s=$(".sidebar-right-scroll"),r=$(window).height()-51,o=function(){var e=$("#year-copy"),n=new Date;2013===n.getFullYear()?e.html("2013"):e.html("2013-"+n.getFullYear()),$(window).scroll(function(){$(this).scrollTop()>60?t.addClass("add-opacity"):t.removeClass("add-opacity")}),$('[data-toggle="tabs"] a, .enable-tabs a').click(function(e){e.preventDefault(),$(this).tab("show")}),$('[data-toggle="tooltip"], .enable-tooltip').tooltip({container:"body",animation:!1}),$('[data-toggle="popover"], .enable-popover').popover({container:"body",animation:!1}),$('[data-toggle="lightbox-image"]').magnificPopup({type:"image",image:{titleSrc:"title"}}),$('[data-toggle="lightbox-gallery"]').magnificPopup({delegate:"a.gallery-link",type:"image",gallery:{enabled:!0,navigateByImgClick:!0,arrowMarkup:'<button type="button" class="mfp-arrow mfp-arrow-%dir%" title="%title%"></button>',tPrev:"Previous",tNext:"Next",tCounter:'<span class="mfp-counter">%curr% of %total%</span>'},image:{titleSrc:"title"}}),$("textarea.textarea-elastic").elastic(),$(".textarea-editor").wysihtml5(),$(".select-chosen").chosen(),$(".input-datepicker").datepicker(),$(".pie-chart").easyPieChart({barColor:"#f39c12",trackColor:"#eeeeee",scaleColor:!1,lineWidth:3,size:$(this).data("size"),animate:1200})},l=function(){var e=250,t=300,n=$(".sidebar-nav a"),a=$(".menu-link");a.each(function(e,t){$(t).append("<span>"+$(t).next("ul").find("a").not(".submenu-link").length+"</span>")}),n.mouseenter(function(){$("i",this).addClass("animation-bigEntrance")}).mouseleave(function(){$("i",this).removeClass("animation-bigEntrance")}),a.click(function(){var n=$(this);return n.parent().hasClass("active")!==!0&&(n.hasClass("open")?n.removeClass("open").next().slideUp(e):($(".menu-link.open").removeClass("open").next().slideUp(e),n.addClass("open").next().slideDown(t))),!1})},c=function(t){"init"===t?(i.add(s).slimScroll({height:r,color:"#fff",size:"3px",touchScrollStep:750}),$(window).resize(function(){c("resize-scroll")}),$(window).bind("orientationchange",c("resize-scroll")),n.click(function(){c("toggle-left")}),$("#sidebar-left").mouseenter(function(){c("open-left")}).mouseleave(function(){c("close-left")}),a.click(function(){c("toggle-right")}),$("#sidebar-right").mouseleave(function(){c("close-right")}),$(".sidebars-swipe").swipe({swipeRight:function(){e.hasClass("sidebar-right-open")?c("close-right"):c("open-left")},swipeLeft:function(){e.hasClass("sidebar-left-open")?c("close-left"):c("open-right")}})):"resize-scroll"===t?i.add(s).css("height",$(window).height()-51):"open-left"===t?(e.removeClass("sidebar-right-open").addClass("sidebar-left-open"),n.parent("li").addClass("active"),a.parent("li").removeClass("active")):"close-left"===t?(e.removeClass("sidebar-left-open"),n.parent("li").removeClass("active")):"toggle-left"===t?(e.removeClass("sidebar-right-open").toggleClass("sidebar-left-open"),n.parent("li").toggleClass("active"),a.parent("li").removeClass("active")):"open-right"===t?(e.removeClass("sidebar-left-open").addClass("sidebar-right-open"),a.parent("li").addClass("active"),n.parent("li").removeClass("active")):"close-right"===t?(e.removeClass("sidebar-right-open"),a.parent("li").removeClass("active")):"toggle-right"===t&&(e.removeClass("sidebar-left-open").toggleClass("sidebar-right-open"),a.parent("li").toggleClass("active"),n.parent("li").removeClass("active"))},d=function(){var e=$("#to-top");$(window).scroll(function(){$(this).scrollTop()>150?e.fadeIn(100):e.fadeOut(100)}),e.click(function(){return $("html, body").animate({scrollTop:0},200),!1})},u=function(){$(".dropdown-custom a").click(function(e){e.stopPropagation()});var n=$("#page-container"),a=$("#options-fw-disable"),i=$("#options-fw-enable");n.hasClass("full-width")?i.addClass("active"):a.addClass("active"),a.click(function(){n.removeClass("full-width"),$(this).addClass("active"),i.removeClass("active")}),i.click(function(){n.addClass("full-width"),$(this).addClass("active"),a.removeClass("active")});var s=$("#options-header-default"),r=$("#options-header-inverse"),o=$("#options-header-top"),l=$("#options-header-bottom");t.hasClass("navbar-default")?s.addClass("active"):r.addClass("active"),t.hasClass("navbar-fixed-top")?o.addClass("active"):l.addClass("active"),s.click(function(){t.removeClass("navbar-inverse").addClass("navbar-default"),$(this).addClass("active"),r.removeClass("active")}),r.click(function(){t.removeClass("navbar-default").addClass("navbar-inverse"),$(this).addClass("active"),s.removeClass("active")}),o.click(function(){e.removeClass("header-fixed-bottom").addClass("header-fixed-top"),t.removeClass("navbar-fixed-bottom").addClass("navbar-fixed-top"),$(this).addClass("active"),l.removeClass("active")}),l.click(function(){e.removeClass("header-fixed-top").addClass("header-fixed-bottom"),t.removeClass("navbar-fixed-top").addClass("navbar-fixed-bottom"),$(this).addClass("active"),o.removeClass("active")});var c=$("#sidebar-left"),d=$("#options-hover-enable"),u=$("#options-hover-disable");c.hasClass("enable-hover")?d.addClass("active"):u.addClass("active"),d.click(function(){c.addClass("enable-hover"),$(this).addClass("active"),u.removeClass("active")}),u.click(function(){c.removeClass("enable-hover"),$(this).addClass("active"),d.removeClass("active")});var h=$("#fx-container"),p=$("#option-effects");$("button[data-fx='"+h.attr("class")+"']",p).addClass("active"),$("button",p).click(function(){h.removeClass().addClass($(this).data("fx")),$("button",p).removeClass("active"),$(this).addClass("active")})},h=function(){Modernizr.input.placeholder||$("[placeholder]").focus(function(){var e=$(this);e.val()===e.attr("placeholder")&&(e.val(""),e.removeClass("ph"))}).blur(function(){var e=$(this);(""===e.val()||e.val()===e.attr("placeholder"))&&(e.addClass("ph"),e.val(e.attr("placeholder")))}).blur().parents("form").submit(function(){$(this).find("[placeholder]").each(function(){var e=$(this);e.val()===e.attr("placeholder")&&e.val("")})})},p=function(){$.extend(!0,$.fn.dataTable.defaults,{sDom:"<'row'<'col-md-6'l><'col-md-6'f>r>t<'row'<'col-md-5'i><'col-md-7'p>>",sPaginationType:"bootstrap",oLanguage:{sLengthMenu:"_MENU_",sSearch:'<div class="input-group">_INPUT_<span class="input-group-addon"><i class="icon-search"></i></span></div>',sInfo:"<strong>_START_</strong>-<strong>_END_</strong> of <strong>_TOTAL_</strong>",oPaginate:{sPrevious:"",sNext:""}}}),$.extend($.fn.dataTableExt.oStdClasses,{sWrapper:"dataTables_wrapper form-inline"}),$.fn.dataTableExt.oApi.fnPagingInfo=function(e){return{iStart:e._iDisplayStart,iEnd:e.fnDisplayEnd(),iLength:e._iDisplayLength,iTotal:e.fnRecordsTotal(),iFilteredTotal:e.fnRecordsDisplay(),iPage:Math.ceil(e._iDisplayStart/e._iDisplayLength),iTotalPages:Math.ceil(e.fnRecordsDisplay()/e._iDisplayLength)}},$.extend($.fn.dataTableExt.oPagination,{bootstrap:{fnInit:function(e,t,n){var a=e.oLanguage.oPaginate,i=function(t){t.preventDefault(),e.oApi._fnPageChange(e,t.data.action)&&n(e)};$(t).append('<ul class="pagination pagination-sm remove-margin"><li class="prev disabled"><a href="javascript:void(0)"><i class="icon-chevron-left"></i> '+a.sPrevious+"</a></li>"+'<li class="next disabled"><a href="javascript:void(0)">'+a.sNext+' <i class="icon-chevron-right"></i></a></li>'+"</ul>");var s=$("a",t);$(s[0]).bind("click.DT",{action:"previous"},i),$(s[1]).bind("click.DT",{action:"next"},i)},fnUpdate:function(e,t){var n,a,i,s,r,o=5,l=e.oInstance.fnPagingInfo(),c=e.aanFeatures.p,d=Math.floor(o/2);for(l.iTotalPages<o?(s=1,r=l.iTotalPages):l.iPage<=d?(s=1,r=o):l.iPage>=l.iTotalPages-d?(s=l.iTotalPages-o+1,r=l.iTotalPages):(s=l.iPage-d+1,r=s+o-1),n=0,iLen=c.length;iLen>n;n++){for($("li:gt(0)",c[n]).filter(":not(:last)").remove(),a=s;r>=a;a++)i=a===l.iPage+1?'class="active"':"",$("<li "+i+'><a href="javascript:void(0)">'+a+"</a></li>").insertBefore($("li:last",c[n])[0]).bind("click",function(n){n.preventDefault(),e._iDisplayStart=(parseInt($("a",this).text(),10)-1)*l.iLength,t(e)});0===l.iPage?$("li:first",c[n]).addClass("disabled"):$("li:first",c[n]).removeClass("disabled"),l.iPage===l.iTotalPages-1||0===l.iTotalPages?$("li:last",c[n]).addClass("disabled"):$("li:last",c[n]).removeClass("disabled")}}}})};return{init:function(){o(),c("init"),l(),d(),u(),h()},sidebars:function(e){c(e)},datatables:function(){p()}}}();$(function(){webApp.init()});