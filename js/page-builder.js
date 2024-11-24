document.addEventListener('DOMContentLoaded', function () {
    const collectionCards = document.querySelectorAll('.collection-card');
    const activeCollection = document.querySelector('.active-collection');
    const photographyCollections = document.querySelector('.photography-collections');
    let activeIndex = 0;

    // Function to update the active collection info
    // Function to update the active collection info
    function updateActiveCollection(card) {
        const backgroundImage = card.getAttribute('data-background');
        const title = card.querySelector('h3').innerText;
        const description = card.getAttribute('data-description');
        const link = card.getAttribute('data-link');
        const ctaText = card.getAttribute('data-cta-text');

        // Fade out effect
        const activeInfo = document.querySelector('.active-info');
        activeInfo.classList.add('fade-out');

        setTimeout(() => {
            // Update content after fade-out completes
            photographyCollections.style.backgroundImage = `url(${backgroundImage})`;
            activeCollection.querySelector('h2').innerText = title;
            activeCollection.querySelector('p').innerText = description;

            const ctaButton = activeCollection.querySelector('.cta-button');
            ctaButton.setAttribute('href', link);
            ctaButton.innerText = ctaText;

            // Fade in effect
            activeInfo.classList.remove('fade-out');
            activeInfo.classList.add('fade-in');
        }, 500); // Adjust to match fade-out duration
    }

    // Function to shift cards and create the sliding effect
    function slideCards() {
        collectionCards.forEach((card, index) => {
            // Calculate the new position for each card
            let newPosition = (index - activeIndex + collectionCards.length) % collectionCards.length;
            
            // Calculate scaling factor for card size
            let scale = 1 - 0.03 * newPosition; // Adjust this scale factor as needed (e.g., 0.2)

            // Set the new transform for position and size
            card.style.transform = `translateX(${newPosition * 100}%) scale(${scale})`;

            // Manage the z-index: the card in the active position should have the highest z-index
            let zIndex = (newPosition === 0) ? 100 : 1; // Highest z-index for the active card

            // Apply opacity and z-index changes based on position
            card.style.opacity = (newPosition === 0) ? '1' : '0.5'; // Full opacity for active card, semi-transparent for others
            card.style.zIndex = zIndex; // Apply the z-index change

            // Reset the card when it's transitioning to the back
            if (newPosition === 0) {
                card.style.opacity = '0'; // Fade out the card when it's moving left
                setTimeout(() => {
                    card.style.transform = `translateX(${(collectionCards.length - 1) * 100}%) scale(1)`; // Reset to the end position and scale
                    setTimeout(() => {
                        card.style.opacity = '1'; // Make the card visible again after 3 seconds
                    }, 3000); // Delay the opacity change by 3 seconds
                }, 1500); // Match the transition duration for the sliding effect
            } else {
                card.style.opacity = '1'; // Ensure visible cards are not faded
            }
        });

        // Update active collection info
        updateActiveCollection(collectionCards[activeIndex]);

        // Increment activeIndex in a loop
        activeIndex = (activeIndex + 1) % collectionCards.length;
    }

    // Initial setup for the first card
    updateActiveCollection(collectionCards[activeIndex]);

    // Trigger the first click to start the sliding effect automatically
    setTimeout(() => {
        collectionCards[activeIndex].click(); // Simulate a click on the first card
    }, 100); // Delay slightly to ensure initial layout is ready

    // Add click event listener to the collection cards to trigger the slide
    collectionCards.forEach((card, index) => {
        card.addEventListener('click', function () {
            // Set the clicked card as the active card
            activeIndex = index;
            slideCards(); // Manually trigger the card sliding effect
        });
    });
});

document.querySelectorAll('.collection-card h3').forEach(h3 => {
    h3.addEventListener('mouseenter', function () {
        h3.closest('.collection-card').classList.add('hover-h3');
    });
    h3.addEventListener('mouseleave', function () {
        h3.closest('.collection-card').classList.remove('hover-h3');
    });
});


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
