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
		thumbnail : "../public/images/icon/laporan.png",
		content : "Supplier",
		url : "/",
		size : "4x2",
		theme : "softblue",
		link : "supplier",
		target: "_self"
	}, {
		name : "Troubleshooting",
		thumbnail : "../public/images/icon/laporan.png",
		content : "Stok Barang",
		url : "/",
		size : "4x2",
		theme : "darkblue",
		link : "stok",
		target: "_blank"
	},{
		name : "Pembelian",
		thumbnail : "../public/images/icon/laporan.png",
		content : "Penjualan",
		url : "/",
		size : "2x2",
		theme : "softgreen",
		link : "penjualan",
		target: "_self"
	}, {
		name : "Retur",
		thumbnail : "../public/images/icon/laporan.png",
		content : "Retur",
		url : "/",
		size : "2x2",
		theme : "darkgreen",
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

