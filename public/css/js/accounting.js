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
		name : "Help_Desk",
		thumbnail : "../public/images/icon/helpdesk.png",
		content : "Help Desk",
		url : "/",
		size : "4x2",
		theme : "magenta",
		link : "support.html",
		target: "_self"
	}, {
		name : "Synchronization",
		thumbnail : "../public/images/icon/sync.png",
		content : "Sync Now",
		url : "/",
		size : "4x2",
		theme : "green",
		link : "",
		target: "_self"
	}, {
		name : "User",
		thumbnail : "../public/images/icon/user.png",
		content : "Profile User",
		url : "/",
		size : "4x2",
		theme : "softblue",
		link : "profile.html",
		target: "_self"
	}, {
		name : "Notification",
		thumbnail : "../public/images/icon/notification.png",
		content : "Notification",
		url : "/",
		size : "2x2",
		theme : "blue",
		link : "notification.html",
		target: "_self"
	}, {
		name : "Message",
		thumbnail : "../public/images/icon/message.png",
		content : "Message",
		url : "/",
		size : "2x2",
		theme : "yellow",
		link : "message.html",
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
		name : "Sign_Out",
		thumbnail : "../public/images/icon/signout.png",
		content : "Sign Out",
		url : "/",
		size : "2x2",
		theme : "darkred",
		link : "signin/logout",
		target: "_self"
	}
], tiles2 = [
	{
		name : "Master Akun",
		thumbnail : "../public/images/icon/master-akun.png",
		content : "Master Akun",
		url : "/",
		size : "4x2",
		theme : "darkred",
		link : "master_akun",
		target: "_self"
	},  {
		name : "Kas",
		thumbnail : "../public/images/icon/acc-kas.png",
		content : "KAS",
		url : "/",
		size : "4x2",
		theme : "green",
		link : "arus_kas",
		target: "_self"
	},  {
		name : "Laporan",
		thumbnail : "../public/images/icon/laporan.png",
		content : "Laporan",
		url : "/",
		size : "4x2",
		theme : "darkmagenta",
		link : "report",
		target: "_self"
	},  {
		name : "Buku Besar",
		thumbnail : "../public/images/icon/acc-kas.png",
		content : "Buku Besar",
		url : "/",
		size : "4x2",
		theme : "darkblue",
		link : "buku_besar",
		target: "_self"
	}
], tiles3 = [
	{
		name : "Penjualan",
		thumbnail : "../public/images/icon/acc-penjualan.png",
		content : "Penjualan",
		url : "/",
		size : "2x2",
		theme : "darkred",
		link : "penjualan",
		target: "_self"
	},  {
		name : "Pembelian",
		thumbnail : "../public/images/icon/acc-pembelian.png",
		content : "Pembelian",
		url : "/",
		size : "2x2",
		theme : "darkblue",
		link : "pembelian",
		target: "_self"
	},  {
		name : "Hutang",
		thumbnail : "../public/images/icon/acc-hutang.png",
		content : "Hutang",
		url : "/",
		size : "2x2",
		theme : "green",
		link : "hutang",
		target: "_self"
	},  {
		name : "Piutang",
		thumbnail : "../public/images/icon/acc-piutang.png",
		content : "Piutang",
		url : "/",
		size : "2x2",
		theme : "darkmagenta",
		link : "piutang",
		target: "_self"
	}
];
Metro.HTML.addContainer({
	size : "full",
	widgets : tiles1
});
Metro.HTML.addContainer({
	size : "middle",
	widgets : tiles2
});
Metro.HTML.addContainer({
	size : "half",
	widgets : tiles3
});
Metro.HTML.addContainer({
	size : "half",
	widgets : tiles4
});
