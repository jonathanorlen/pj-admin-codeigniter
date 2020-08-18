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
		name : "Sign_Out",
		thumbnail : "../public/images/icon/signout.png",
		content : "Sign Out",
		url : "/",
		size : "2x2",
		theme : "darkred",
		link : "signin/logout",
		target: "_self"
	}
],tiles2 = [{
        name: "Pembelian",
        thumbnail: "../public/images/icon/pembelian.png",
        content: "Pembelian",
        url: "/",
        size: "2x2",
        theme: "darkyellow",
        link: "pembelian",
        target: "_self"
    }, {
        name: "Retur",
        thumbnail: "../public/images/icon/retur.png",
        content: "Retur",
        url: "/",
        size: "2x2",
        theme: "darkblue",
        link: "retur_in",
        target: "_self"
    }, {
        name: "POS",
        thumbnail: "../public/images/icon/retur.png",
        content: "POS",
        url: "/",
        size: "4x2",
        theme: "blue",
        link: "penjualan",
        target: "_self"
    }, {
        name: "Kasir",
        thumbnail: "../public/images/icon/karyawan.png",
        content: "Kasir",
        url: "/",
        size: "4x2",
        theme: "darkgreen",
        link: "kasir",
        target: "_self"
    }, {
        name: "Gudang",
        thumbnail: "../public/images/icon/produk.png",
        content: "Gudang",
        url: "/",
        size: "2x2",
        theme: "green",
        link: "gudang",
        target: "_self"
    }, {
        name: "Order",
        thumbnail: "../public/images/icon/produk.png",
        content: "Order",
        url: "/",
        size: "2x2",
        theme: "darkred",
        link: "order",
        target: "_self"
    }, {
        name: "Laporan",
        thumbnail: "../public/images/icon/produk.png",
        content: "Laporan",
        url: "/",
        size: "2x2",
        theme: "magenta",
        link: "laporan",
        target: "_self"
    }
],tiles3 = [{
        name: "Setup Cabang",
        thumbnail: "../public/images/icon/pengaturan.png",
        content: "Setup Cabang",
        url: "/",
        size: "2x2",
        theme: "darkred",
        link: "setup",
        target: "_self"
    }
];
Metro.HTML.addContainer({
	size : "full",
	widgets : tiles1
});
Metro.HTML.addContainer({
    size: "middle",
    widgets: tiles2
});
Metro.HTML.addContainer({
    size: "half",
    widgets: tiles3
});
