const notifications = document.querySelectorAll('.notification');
if (notifications.length) {
    setTimeout(() => {
        [].forEach.call(notifications, function (n) {
            n.style.display = 'none';
        });
    }, 4000)
}
