module.exports = function(app) {
    const togglers = document.querySelectorAll('.filters-list-item .toggler-link');
    if (togglers.length) {
        [].forEach.call(togglers, t => {
            t.addEventListener('click', event => {
                event.preventDefault();
                const link = event.target.hash.substr(1);

                const el = document.getElementById(link);
                el.classList.toggle('is-visible');
                el.parentNode.classList.toggle('is-active');
            });
        });
    }

    if (app.$refs.hasOwnProperty('filter')) {
        const filters = document.querySelector('.filters');

        app.$refs.filter.addEventListener('click', event => {
            event.preventDefault();
            filters.classList.toggle('is-active');
        });

        const filterOuter = document.addEventListener('click', event => {
            if (!filters.contains(event.target) && event.target !== app.$refs.filter) {
                filters.classList.remove('is-active');
                removeEventListener('click', filterOuter);
            }
        })
    }

}
