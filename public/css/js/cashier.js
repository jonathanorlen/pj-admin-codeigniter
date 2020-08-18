var tiles1 = [
	{
		name : "User",
		thumbnail : "../public/images/icon/user.png",
		content : "Profile User",
		url : "/",
		size : "4x2",
		theme : "softblue",
		link : "profile.html",
		target: "_self"
	}, {
		name : "Troubleshooting",
		thumbnail : "../public/images/icon/userguide.png",
		content : "Troubleshoot and User Guide",
		url : "/",
		size : "4x2",
		theme : "darkblue",
		link : "userguide/index.html",
		target: "_blank"
	}, {
		name : "Penjualan",
		thumbnail : "../public/images/icon/cash-register.png",
		content : "Penjualan",
		url : "/",
		size : "4x2",
		theme : "green",
		link : "penjualan",
		target: "_self"
	}, {
		name : "Retur",
		thumbnail : "../public/images/icon/retur.png",
		content : "Retur",
		url : "/",
		size : "4x2",
		theme : "blue",
		link : "retur",
		target: "_self"
	}, {
		name : "Sign_Out",
		thumbnail : "../public/images/icon/signout.png",
		content : "Sign Out",
		url : "/",
		size : "2x2",
		theme : "darkred",
		link : "signin/logout",
		target: "_self"
	}
];
Metro.HTML.addContainer({
	size : "full",
	widgets : tiles1
});
