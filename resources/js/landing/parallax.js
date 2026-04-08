const phone = document.getElementById('heroPhone');
const float1 = document.getElementById('float1');
const float2 = document.getElementById('float2');

document.addEventListener('mousemove', (e) => {
    if (window.innerWidth <= 992) return;

    const x = (window.innerWidth / 2 - e.pageX) / 35;
    const y = (window.innerHeight / 2 - e.pageY) / 35;

    if (phone) {
        phone.style.transform = `translateY(${-y}px) rotateX(${8 + y / 2}deg) rotateY(${-12 + x / 2}deg)`;
    }
    if (float1) {
        float1.style.transform = `translate(${x * 1.6}px, ${y * 1.6}px) rotate(-4deg)`;
    }
    if (float2) {
        float2.style.transform = `translate(${-x * 2}px, ${-y * 2}px) rotate(4deg)`;
    }
});
