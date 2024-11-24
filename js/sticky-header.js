document.addEventListener('DOMContentLoaded', function () {
    const header = document.querySelector('.site-header');
    
    // Check scroll position and add/remove class
    function handleScroll() {
        if (window.scrollY > 1) {
            header.classList.add('sticky-header-small');
        } else {
            header.classList.remove('sticky-header-small');
        }
    }

    // Listen for scroll events
    window.addEventListener('scroll', handleScroll);
});

document.addEventListener("DOMContentLoaded", function() {
    const hamburger = document.querySelector(".hamburger-menu");
    const sidebar = document.querySelector(".sidebar-menu");

    hamburger.addEventListener("click", function() {
        sidebar.classList.toggle("active");
        hamburger.classList.toggle("active"); // Toggle the active class on hamburger as well
    });

    // Optional: Add a close button functionality
    const closeBtn = document.querySelector(".sidebar-close");
    if (closeBtn) {
        closeBtn.addEventListener("click", function() {
            sidebar.classList.remove("active");
            hamburger.classList.remove("active"); // Remove active class from hamburger when sidebar closes
        });
    }
});


// Loading Animation
document.addEventListener('DOMContentLoaded', function () {
    setTimeout(() => {
        const loadingAnimation = document.querySelector('.loading-animation');
        if (loadingAnimation) {
            loadingAnimation.style.opacity = '0';
            loadingAnimation.style.transition = 'opacity 0.5s';
            setTimeout(() => loadingAnimation.remove(), 500); // Fully remove after fade-out
        }
    }, 2100);
});