$(function () {
	$layout = $('.metro-layout');
	$container = $('#widget_scroll_container');
	$('.next', $layout).click(function (ev) {
		ev.preventDefault();
		$container.stop().animate({
			scrollLeft : '+=' + ($('#widget_scroll_container').innerWidth() / 1.8)
		}, 400);
	});
	$('.prev', $layout).click(function (ev) {
		ev.preventDefault();
		$container.stop().animate({
			scrollLeft : '-=' + ($('#widget_scroll_container').innerWidth() / 1.8)
		}, 400);
	});
	$('#metro', $layout).bind('mousewheel', function (ev, delta, deltaX, deltaY) {
		if (delta) {
			ev.preventDefault();
				$container.stop().animate({
					scrollLeft : '-=' + ($('#widget_scroll_container').innerWidth() / 4 * delta)
				}, 10);
			console.log(delta, deltaX, deltaY);
		}
	});
})

var docCookies = {
	getItem : function (b) {
		return !b || !this.hasItem(b) ? null : unescape(document.cookie.replace(RegExp("(?:^|.*;\\s*)" + escape(b).replace(/[\-\.\+\*]/g, "\\$&") + "\\s*\\=\\s*((?:[^;](?!;))*[^;]?).*"), "$1"))
	},
	setItem : function (b, a, c, e, g, d) {
		if (b && !/^(?:expires|max\-age|path|domain|secure)$/i.test(b)) {
			var f = "";
			if (c)
				switch (c.constructor) {
				case Number:
					f = Infinity === c ? "; expires=Tue, 19 Jan 2038 03:14:07 GMT" : "; max-age=" + c;
					break;
				case String:
					f = "; expires=" + c;
					break;
				case Date:
					f = "; expires=" + c.toGMTString()
				}
			document.cookie =
				escape(b) + "=" + escape(a) + f + (g ? "; domain=" + g : "") + (e ? "; path=" + e : "") + (d ? "; secure" : "")
		}
	},
	removeItem : function (b, a) {
		b && this.hasItem(b) && (document.cookie = escape(b) + "=; expires=Thu, 01 Jan 1970 00:00:00 GMT" + (a ? "; path=" + a : ""))
	},
	hasItem : function (b) {
		return RegExp("(?:^|;\\s*)" + escape(b).replace(/[\-\.\+\*]/g, "\\$&") + "\\s*\\=").test(document.cookie)
	}
}, Metro = {
	window_width : 0,
	window_height : 0,
	scroll_container_width : 0,
	widget_preview : null,
	widget_sidebar : null,
	widgets : null,
	widget_scroll_container : null,
	widget_containers : null,
	widget_open : !1,
	dragging_x : 0,
	left : 10,
	widget_page_data : [],
	is_touch_device : !1,
	title_prefix : "Metro Dashboard",
	data : [],
	init : function () {
		Metro.HTML._build();
		Metro.is_touch_device = "ontouchstart" in document.documentElement ? !0 : !1;
		Metro.cacheElements();
		Metro.Events.onWindowResize();
		$('#metro').bind("resize", Metro.Events.onWindowResize).bind("hashchange", Metro.Events.onHashChange);
		$(document).click(Metro.Events.onClick);
		Metro.widget_sidebar.children("div").children("div").click(Metro.Events.sidebarClick);
		Metro.is_touch_device ?
		$('#metro').addClass("touch") : $(document).mousedown(Metro.Events.onMouseDown).mouseup(Metro.Events.onMouseUp).mousemove(Metro.Events.onMouseMove);
		if ("" !== window.location.hash) {
			var b = window.location.hash.replace(/[#!\/]/g, ""),
			b = Metro.widgets.filter('[data-name="' + b + '"]');
			b.length && Metro.openWidget(b)
		}
		$('#metro').addClass("loaded");
		Metro.widgets.each(function (a) {
			var b = $(this);
			setTimeout(function () {
				b.removeClass("unloaded");
				setTimeout(function () {
					b.removeClass("animation")
				}, 300)
			}, 100 * a)
		})
	},
	Events : {
		onWindowResize : function () {
			Metro.window_width = $('#metro').width();
			Metro.window_height = $('#metro').height()
		},
		onHashChange : function (b) {
			var a = window.location.hash,
			c = a.replace(/[#!\/]/g, ""),
			e = function () {
				var a = $('div.widget[data-name="' + c + '"]');
				a.length && Metro.openWidget(a)
			};
			Metro.widget_open ? "" === a ? Metro.closeWidget(b) : Metro.widget_open.data("name") !== c && e() : "" !== a && e()
		},
		onMouseDown : function (b) {
			Metro.widget_open || (Metro.dragging_x = b.clientX)
		},
		onMouseUp : function () {
			if (!Metro.widget_open && Metro.dragging_x) {
				$(document).scrollLeft(0);
				Metro.dragging_x = 0;
				var b = -1 * (Metro.scroll_container_width - Metro.window_width),
				a = function () {
					setTimeout(function () {
						Metro.widget_scroll_container.css("transition", "")
					}, 400)
				};
				10 < Metro.left || Metro.scroll_container_width + 10 < Metro.window_width ? (Metro.widget_scroll_container.css("transition", "left 0.2s ease-in"), Metro.widget_scroll_container.css("left", 10), Metro.left = 10, a()) : Metro.left < b && (Metro.widget_scroll_container.css("transition", "left 0.2s ease-in"), Metro.widget_scroll_container.css("left", b), Metro.left =
						b, a())
			}
		},
		onMouseMove : function (b) {
			if (!Metro.widget_open && Metro.dragging_x) {
				var a = Metro.left + b.clientX - Metro.dragging_x;
				Metro.widget_scroll_container.css("left", a);
				Metro.dragging_x = b.clientX;
				Metro.left = a
			}
		},
		onClick : function (b) {
			b = $(b.target);
			//b.hasClass("widget") ? Metro.openWidget(b) : b.parents("div.widget").length && Metro.openWidget(b.parents("div.widget"))
		},
		sidebarClick : function (b) {
			switch ($(b.target).attr("class")) {
			case "cancel":
				Metro.closeWidget(b);
				break;
			case "refresh":
				Metro.refreshWidget(b);
				break;
			case "download":
				window.open("http://codecanyon.net/user/leli2000",
					"_blank");
				break;
			case "back":
				Metro.previousWidget(b);
				break;
			case "next":
				Metro.nextWidget(b)
			}
		}
	},
	HTML : {
		_build : function () {
			var b = 0;
			$(Metro.data).each(function (a, c) {
				b = "full" === c.size ? b + 12 : b + 4
			});
			var a;
			a = "<style>";
			a += "#widget_scroll_container {\r\n" + ("width: " + (120 * b + 50 * (Metro.data.length - 1) + 20 * Metro.data.length) + "px;\r\n");
			a += "}\r\n";
			a += "div.widget_container {\r\n";
			a += "width: 1050px;\r\n";
			a += "}\r\n";
			a += "div.widget_container.half {\r\n";
			a += "width: 370px;\r\n";
			a += "}\r\n";
			a += "div.widget_container.middle {\r\n";
			a += "width: 700px;\r\n";
			a += "}\r\n";
			a += "@media screen and (max-height: 680px) {\r\n";
			a += "#widget_scroll_container {\r\n";
			a += "width: " + (95 * b + 50 * (Metro.data.length - 1) + 20 * Metro.data.length) + "px;\r\n";
			a += "}\r\n";
			a += "div.widget_container {\r\n";
			a += "width: 920px;\r\n";
			a += "}\r\n";
			a += "div.widget_container.half {\r\n";
			a += "width: 320px;\r\n";
			a += "}\r\n";
			a += "div.widget_container.middle {\r\n";
			a += "width: 620px;\r\n";
			a += "}\r\n";
			a += "}\r\n";
			a += "</style>";
			$(a).appendTo($('#metro'));
			var c = $("<div>").attr("id", "widget_scroll_container").appendTo($('#metro'));
			$(Metro.data).each(function (a, b) {
				var d = $("<div>").addClass("widget_container " + b.size).data("num", a).appendTo(c);
				$(b.widgets).each(function (a, b) {
					var c;
					c = "" + ('<a target="'+b.target+'" href="'+b.link+'"><div class="widget widget' + b.size + " widget_" + b.theme + ("undefined" !== typeof b.link ? " widget_link" : "") + ' animation unloaded"' + ("undefined" !== typeof b.colour ? ' style="background-color:' + b.colour + ';"' : "") + '  data-url="' + b.url + '" data-theme="' + b.theme + '" data-name="' + b.name + '"' + ("undefined" !== typeof b.link ? ' data-link="' + b.link + '"' : "") + ">");
					c = c + '<div class="widget_content">' + ('<div class="main"' + (b.thumbnail.length ? " style=\"background-image:url('" + b.thumbnail +
								"');\"" : "") + ">");
					c += "<span>" + b.content + "</span>";
					c += "</div>";
					c += "</div>";
					c += "</div></a>";
					$(c).appendTo(d)
				})
			});
			$("<div>").attr("id", "widget_preview").html(a).appendTo($('#metro'))
		},
		addContainer : function (b) {
			Metro.data.push(b)
		}
	},
	cacheElements : function () {
		Metro.widgets =
			$("div.widget");
		Metro.widget_containers = $("div.widget_container");
		Metro.widget_scroll_container = $("#widget_scroll_container");
		Metro.widget_preview = $("#widget_preview");
		Metro.widget_sidebar = $("#widget_sidebar");
		Metro.scroll_container_width = Metro.widget_scroll_container.width()
	},
	openWidget : function (b) {
		var a = b.data("name"),
		c = b.data("link");
		c && "" !== c ? window.open(c, "_blank") : $.trim(b.data("url")).length && (Metro.widget_open = b, window.location.hash = "#!/" + a, document.title = Metro.title_prefix + a, $("#widget_preview_content").remove(),
			Metro.widget_preview.addClass("open").css("background-color", b.css("background-color")).css("background-image", b.find(".main").css("background-image")), Metro.widget_scroll_container.hide(), Metro._loadWidget(b));
		"undefined" !== typeof _gaq && _gaq.push(["_trackPageview", "#" + a])
	},
	closeWidget : function () {
		window.location.hash = "";
		document.title = Metro.title_prefix + "Metro Framework";
		Metro.widget_scroll_container.show();
		Metro.widget_preview.removeClass("open");
		Metro.widget_open = !1;
		setTimeout(function () {
			$("#widget_preview_content").remove()
		},
			300)
	},
	refreshWidget : function () {
		Metro._loadWidget(Metro.widget_open, !1)
	},
	previousWidget : function (b) {
		var a = Metro.widget_open.prev();
		a.length || (a = Metro.widget_open.parent().children("div.widget").last());
		var c = a.data("url");
		c && "" !== c ? Metro.openWidget(a) : (Metro.widget_open = a, Metro.previousWidget(b))
	},
	nextWidget : function (b) {
		var a = Metro.widget_open.next();
		a.length || (a = Metro.widget_open.parent().children("div.widget").first());
		var c = a.data("url");
		c && "" !== c ? Metro.openWidget(a) : (Metro.widget_open = a, Metro.nextWidget(b))
	},
	_loadWidget : function (b, a) {
		var c = b.data("name"),
		e = function (a) {
			Metro.widget_preview.css("background-image", "none");
			var b = $("#widget_preview_content");
			b.length ? b.html(a) : b = $("<div>").attr("id", "widget_preview_content").insertAfter(Metro.widget_sidebar).html(a);
			"true" !== docCookies.getItem("metro_ui_sidebar_first_time") && (Metro.widget_sidebar.addClass("open"), Metro.widget_sidebar.mouseenter(function () {
					docCookies.setItem("metro_ui_sidebar_first_time", "true", Infinity);
					$(this).removeClass("open")
				}))
		},
		g = (new Date).getTime();
		Metro.widget_preview.children("div.dot").remove();
		for (var d = 1; 7 >= d; d++)
			$("<div>").addClass("dot").css("transition", "right " + (0.6 + d / 10).toFixed(1) + "s ease-out").prependTo(Metro.widget_preview);
		var f = function () {
			var a = $("div.dot");
			a.length && (a.toggleClass("open"), setTimeout(f, 1300))
		},
		h = function (a) {
			var b = (new Date).getTime() - g;
			1300 < b ? (Metro.widget_preview.children("div.dot").remove(), "undefined" !== typeof a && a()) : setTimeout(function () {
				Metro.widget_preview.children("div.dot").remove();
				"undefined" !== typeof a && a()
			}, 1300 - b)
		};
		Metro.widget_preview.width();
		f();
		"undefined" === typeof a && (a = !0);
		a && void 0 !== Metro.widget_page_data[c] ? h(function () {
			e(Metro.widget_page_data[c])
		}) : (d = $.trim(b.data("url")), 0 < d.length && $.ajax({
				url : d,
				cache : !1,
				type : "POST",
				data : {},
				beforeSend : function () {},
				complete : function () {},
				error : function () {},
				success : function (a) {
					h(function () {
						Metro.widget_page_data[c] = a;
						e(a)
					})
				}
			}))
	}
};
$(document).ready(Metro.init);
