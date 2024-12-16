const tablet_toHide = [
    '.app-sidebar', '.app-header', '.app-wrapper-footer', '.app-page-title'
];

tablet_toHide.forEach(hide => {
    document.querySelectorAll(hide).forEach(element => element.style.display = 'none');
});

$(document).ready(() => {
    const nav = $('#nav');
    const buttons = $('#nav-buttons');
    const back = $('#tablet-back-button');

    const changeWidth = () => {
        const width = nav.innerWidth();
        const backWidth = back.outerWidth();
        buttons.outerWidth(width - backWidth - 6);
    };
    changeWidth();

    $(window).on('resize', changeWidth);
});
