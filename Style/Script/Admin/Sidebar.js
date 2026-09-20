document.addEventListener('DOMContentLoaded', function () {
    const recycleToggle = document.querySelector('a[href="#recycleCollapse"]');
    const collapseEl = document.getElementById('recycleCollapse');

    if (!recycleToggle || !collapseEl) return;

    const arrowIcon = recycleToggle.querySelector('.arrow-icon');

    // Lắng nghe sự kiện Bootstrap
    collapseEl.addEventListener('shown.bs.collapse', function () {
        arrowIcon.classList.add('rotate');
    });

    collapseEl.addEventListener('hidden.bs.collapse', function () {
        arrowIcon.classList.remove('rotate');
    });

    // Nếu đang mở sẵn (F5 khi đang trong RecycleBin)
    if (collapseEl.classList.contains('show')) {
        arrowIcon.classList.add('rotate');
    }
});
recycleToggle.addEventListener('click', function (e) {
    e.preventDefault();
    const isOpen = collapseEl.classList.contains('show');
    if (isOpen) {
        arrowIcon.classList.remove('rotate');
    } else {
        arrowIcon.classList.add('rotate');
    }
});
