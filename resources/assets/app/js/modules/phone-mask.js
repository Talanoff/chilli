import IMask from "imask";

const phones = document.querySelectorAll('[name="phone"]');

if (phones.length) {
    Array.from(phones).forEach(phone => {
        phone.addEventListener('focus', (e) => {
            if (e.target.value === '')
                e.target.value = '+38 (';
        });
        new IMask(phone, {
            mask: '+{38} (000) 000-00-00'
        });
    })
}
