import IMask from "imask";

const phone = document.querySelector('[name="phone"]');
if (!!phone) {
    phone.addEventListener('focus', (e) => {
        if (e.target.value === '')
            e.target.value = '+38 (';
    });
    new IMask(phone, {
        mask: '+{38} (000) 000-00-00'
    });
}
