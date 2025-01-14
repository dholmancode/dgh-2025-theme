// Scroll animation
document.addEventListener('DOMContentLoaded', function () {
    const animatedElements = document.querySelectorAll(
        '.column, .two-column-image, .two-column-content, .active-info, .collections-list, .two-column-image-2'
    );

    const observerOptions = {
        threshold: 0.3, // Trigger when 10% of the element is visible
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible'); // Add visible class
            } else {
                entry.target.classList.remove('visible'); // Remove visible class
            }
        });
    }, observerOptions);

    animatedElements.forEach(el => observer.observe(el));
});
