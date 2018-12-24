module.exports = function (app) {
    let bar;
    if (window.innerWidth > 992 && document.querySelector('.simplebar')) {
        bar = new SimpleBar(document.querySelector('.simplebar'));
    }

    const togglers = document.querySelectorAll('.filters-list-item .toggler-link');
    if (togglers.length) {
        [].forEach.call(togglers, t => {
            t.addEventListener('click', event => {
                event.preventDefault();
                const link = event.target.hash.substr(1);

                const el = document.getElementById(link);
                el.classList.toggle('is-visible');
                el.parentNode.classList.toggle('is-active');

                if (window.innerWidth > 992 && document.querySelector('.simplebar')) {
                    bar.recalculate();
                }
            });
        });
    }

    if (app.$refs.hasOwnProperty('filter') || app.$refs.hasOwnProperty('filterDesktop')) {
        const filters = document.querySelector('.filters');

        app.$refs.filter.addEventListener('click', event => {
            event.preventDefault();
            filters.classList.toggle('is-active');
        });

        app.$refs.filterDesktop.addEventListener('click', event => {
            event.preventDefault();
            filters.classList.toggle('is-active');
        });
        const filterOuter = document.addEventListener('click', event => {
            const el = event.target;

            if ((!filters.contains(el) || !filters.contains(el.parentNode))
              && (!app.$refs.filter.contains(el) && !app.$refs.filter.contains(el.parentNode))
              && (!app.$refs.filterDesktop.contains(el) && !app.$refs.filterDesktop.contains(el.parentNode))) {
                filters.classList.remove('is-active');
                removeEventListener('click', filterOuter);
            }
        })
    }
};
