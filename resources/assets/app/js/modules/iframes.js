const iframes = document.getElementsByTagName('iframe');
window.onload = function () {
    calculateIframeSize();
};
window.onresize = function () {
    calculateIframeSize()
};

function calculateIframeSize() {
    [].forEach.call(iframes, (frame) => {
        const parent = getComputedStyle(frame.parentElement);

        let width = frame.width,
            height = frame.height,
            ratio = height / width,
            parentWidth = parseFloat(parent.width) - (parseFloat(parent.paddingLeft) + parseFloat(parent.paddingRight));

        frame.width = parentWidth;
        frame.height = parentWidth * ratio;
    })
}
