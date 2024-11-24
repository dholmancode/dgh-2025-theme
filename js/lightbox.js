document.addEventListener('DOMContentLoaded', () => {
    const lightbox = document.getElementById('lightbox');
    const lightboxImg = document.querySelector('.lightbox-img');
    const lightboxTitle = document.querySelector('.lightbox-title');
    const lightboxLocation = document.querySelector('.lightbox-location');
    const prevBtn = document.getElementById('prev');
    const nextBtn = document.getElementById('next');
    const closeBtn = document.querySelector('.close');

    let currentPhotoIndex = 0;
    let photos = [];
    const allPhotos = Array.from(document.querySelectorAll('.photo-item'));

    function getVisiblePhotos() {
        // Filter photos that are currently visible in the gallery
        return allPhotos.filter(photo => photo.style.display !== 'none');
    }

    function showLightboxByIndex(index) {
        if (!photos[index]) return;

        const photo = photos[index];
        const imgSrc = photo.getAttribute('data-url');
        const title = photo.getAttribute('data-title');
        const location = photo.getAttribute('data-location');

        // Fade-out and update content
        lightboxImg.classList.add('fade-out');
        lightboxTitle.classList.add('fade-out');
        lightboxLocation.classList.add('fade-out');

        setTimeout(() => {
            lightboxImg.src = imgSrc;
            lightboxTitle.textContent = title;
            lightboxLocation.textContent = location;

            lightboxImg.classList.remove('fade-out');
            lightboxImg.classList.add('fade-in');
            lightboxTitle.classList.remove('fade-out');
            lightboxTitle.classList.add('fade-in');
            lightboxLocation.classList.remove('fade-out');
            lightboxLocation.classList.add('fade-in');
        }, 500);

        // Show lightbox
        lightbox.style.display = 'flex';
        setTimeout(() => lightbox.classList.add('visible'), 10);
    }

    allPhotos.forEach((photo) => {
        photo.addEventListener('click', () => {
            photos = getVisiblePhotos(); // Update photos based on the visible items
            currentPhotoIndex = photos.indexOf(photo); // Get the index of the clicked photo
            showLightboxByIndex(currentPhotoIndex);
        });
    });

    closeBtn.addEventListener('click', hideLightbox);

    prevBtn.addEventListener('click', () => {
        currentPhotoIndex = (currentPhotoIndex === 0) ? photos.length - 1 : currentPhotoIndex - 1;
        showLightboxByIndex(currentPhotoIndex);
    });

    nextBtn.addEventListener('click', () => {
        currentPhotoIndex = (currentPhotoIndex === photos.length - 1) ? 0 : currentPhotoIndex + 1;
        showLightboxByIndex(currentPhotoIndex);
    });

    function hideLightbox() {
        lightbox.classList.remove('visible');
        setTimeout(() => lightbox.style.display = 'none', 500);
    }

    document.addEventListener('keydown', (e) => {
        if (lightbox.classList.contains('visible')) {
            if (e.key === 'ArrowLeft') prevBtn.click();
            else if (e.key === 'ArrowRight') nextBtn.click();
            else if (e.key === 'Escape') hideLightbox();
        }
    });
});
