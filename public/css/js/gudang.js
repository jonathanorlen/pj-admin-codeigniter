function makeRandomTile(a) {
	return {
		name : "tile_000" + a,
		thumbnail : "../public/images/help.png",
		content : "Unknown",
		url : "pages/blank.php",
		size : "2x2",
		theme : "darkmagenta",
		target: "_self"
	}
}
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
	},{
		name : "Pembelian",
		thumbnail : "../public/images/icon/pembelian.png",
		content : "Pembelian",
		url : "/",
		size : "2x2",
		theme : "softgreen",
		link : "pembelian",
		target: "_self"
	}, {
		name : "Mutasi",
		thumbnail : "../public/images/icon/mutasi.png",
		content : "Mutasi",
		url : "/",
		size : "2x2",
		theme : "darkgreen",
		link : "mutasi",
		target: "_self"
	}, {
		name : "Stok_Opname",
		thumbnail : "../public/images/icon/stokopname.png",
		content : "Stok",
		url : "/",
		size : "2x2",
		theme : "darkmagenta",
		link : "stok",
		target: "_self"
	}, {
		name : "Retur",
		thumbnail : "../public/images/icon/retur.png",
		content : "Retur",
		url : "/",
		size : "2x2",
		theme : "blue",
		link : "retur_pembelian",
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

