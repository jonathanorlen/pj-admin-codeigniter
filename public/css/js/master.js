function makeRandomTile(a) {
    return {
        name: "tile_000" + a,
        thumbnail: "../public/images/help.png",
        content: "Unknown",
        url: "pages/blank.php",
        size: "2x2",
        theme: "darkmagenta",
        target: "_self"
    }
}
var tiles1 = [{
    name: "Help_Desk",
    thumbnail: "../public/../public/images/icon/helpdesk.png",
    content: "Help Desk",
    url: "/",
    size: "4x2",
    theme: "magenta",
    link: "support.html",
    target: "_self"
}, {
    name: "Synchronization",
    thumbnail: "../public/images/icon/sync.png",
    content: "Sync Now",
    url: "/",
    size: "4x2",
    theme: "green",
    link: "",
    target: "_self"
}, {
    name: "User",
    thumbnail: "../public/images/icon/user.png",
    content: "Profile User",
    url: "/",
    size: "4x2",
    theme: "softblue",
    link: "profile.html",
    target: "_self"
}, {
    name: "Notification",
    thumbnail: "../public/images/icon/notification.png",
    content: "Notification",
    url: "/",
    size: "2x2",
    theme: "blue",
    link: "notification.html",
    target: "_self"
}, {
    name: "Message",
    thumbnail: "../public/images/icon/message.png",
    content: "Message",
    url: "/",
    size: "2x2",
    theme: "yellow",
    link: "message.html",
    target: "_self"
}, {
    name: "Troubleshooting",
    thumbnail: "../public/images/icon/userguide.png",
    content: "Troubleshoot and User Guide",
    url: "/",
    size: "4x2",
    theme: "darkblue",
    link: "userguide/index.html",
    target: "_blank"
}, {
    name: "Sign_Out",
    thumbnail: "../public/images/icon/signout.png",
    content: "Sign Out",
    url: "/",
    size: "2x2",
    theme: "darkred",
    link: "login.html",
    target: "_self"
}],
    tiles2 = [{
        name: "Produk",
        thumbnail: "../public/images/icon/produk.png",
        content: "Product",
        url: "/",
        size: "2x2",
        theme: "darkblue",
        link: "produk",
        target: "_self"
    }, {
        name: "Pelanggan",
        thumbnail: "../public/images/icon/pelanggan.png",
        content: "Pelanggan",
        url: "/",
        size: "2x2",
        theme: "yellow",
        link: "pelanggan",
        target: "_self"
    }, {
        name: "Pemasok",
        thumbnail: "../public/images/icon/pemasok.png",
        content: "Pemasok",
        url: "/",
        size: "4x2",
        theme: "darkyellow",
        link: "pemasok",
        target: "_self"
    },{
        name: "Karyawan",
        thumbnail: "../public/images/icon/karyawan.png",
        content: "Karyawan",
        url: "/",
        size: "4x2",
        theme: "darkgreen",
        link: "karyawan",
        target: "_self"
    }, {
        name: "Gudang",
        thumbnail: "../public/images/icon/gudang.png",
        content: "Gudang dan Rak",
        url: "/",
        size: "2x2",
        theme: "darkblue",
        link: "rak_gudang",
        target: "_self"
    }, ],
    tiles3 = [{
        name: "Pengaturan",
        thumbnail: "../public/images/icon/pengaturan.png",
        content: "Pengaturan",
        url: "/",
        size: "2x2",
        theme: "darkred",
        link: "pengaturan.html",
        target: "_self"
    }];
Metro.HTML.addContainer({
    size: "full",
    widgets: tiles1
});
Metro.HTML.addContainer({
    size: "middle",
    widgets: tiles2
});
Metro.HTML.addContainer({
    size: "half",
    widgets: tiles3
});
Metro.HTML.addContainer({
    size: "half",
    widgets: tiles4
});