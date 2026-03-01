document.addEventListener('DOMContentLoaded', function() {
    const sliderContainer = document.querySelector('.captcha-slider-container');
    if (!sliderContainer) return;

    const sliderHandle = sliderContainer.querySelector('.captcha-slider-handle');
    const sliderTrack = sliderContainer.querySelector('.captcha-slider-track');
    const sliderText = sliderContainer.querySelector('.captcha-text');
    const hiddenToken = document.getElementById('captcha_token');

    let isDragging = false;
    let isVerified = false;
    let startX = 0;

    sliderHandle.addEventListener('mousedown', startDrag);
    sliderHandle.addEventListener('touchstart', startDrag, {passive: true});

    function startDrag(e) {
        if (isVerified) return;
        isDragging = true;
        startX = e.type === 'mousedown' ? e.clientX : e.touches[0].clientX;
        sliderHandle.style.transition = 'none';
        sliderTrack.style.transition = 'none';
    }

    document.addEventListener('mousemove', drag);
    document.addEventListener('touchmove', drag, {passive: false});

    function drag(e) {
        if (!isDragging || isVerified) return;

        let clientX = e.type === 'mousemove' ? e.clientX : e.touches[0].clientX;
        let containerRect = sliderContainer.getBoundingClientRect();
        let handleWidth = sliderHandle.offsetWidth;

        let newLeft = clientX - containerRect.left - (handleWidth / 2);

        // Limits
        if (newLeft < 0) newLeft = 0;
        let maxLeft = containerRect.width - handleWidth;

        if (newLeft > maxLeft) {
            newLeft = maxLeft;
            verifyCaptcha();
        }

        sliderHandle.style.left = newLeft + 'px';
        sliderTrack.style.width = (newLeft + (handleWidth / 2)) + 'px';
    }

    document.addEventListener('mouseup', stopDrag);
    document.addEventListener('touchend', stopDrag);

    function stopDrag() {
        if (!isDragging || isVerified) return;
        isDragging = false;

        // Reset if not fully dragged
        sliderHandle.style.transition = 'all 0.3s ease';
        sliderTrack.style.transition = 'all 0.3s ease';
        sliderHandle.style.left = '0px';
        sliderTrack.style.width = '0px';
    }

    function verifyCaptcha() {
        isVerified = true;
        isDragging = false;

        sliderHandle.classList.add('verified');
        sliderTrack.classList.add('verified');
        sliderText.innerText = 'Verificado';
        sliderText.style.color = '#fff';

        // Disable drag
        sliderHandle.style.cursor = 'default';

        // Simular token de frontend
        hiddenToken.value = 'verified_' + Math.floor(Math.random() * 100000);

        // Deshabilitar reset
        sliderHandle.style.left = 'calc(100% - ' + sliderHandle.offsetWidth + 'px)';
        sliderTrack.style.width = '100%';
    }
});
