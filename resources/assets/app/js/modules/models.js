const modelsTogglers = document.querySelectorAll('.models-toggler');

if (modelsTogglers.length) {
    Array.from(modelsTogglers).forEach((toggler) => {
        toggler.addEventListener('click', (e) => {
            e.preventDefault();

            const elems = toggler.parentElement.parentElement.querySelectorAll('.extra-models');
            if (elems.length) {
                Array.from(elems, (el) => {
                    el.classList.toggle('is-visible');
                });
            }
        })
    })
}
