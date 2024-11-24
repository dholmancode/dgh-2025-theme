jQuery(document).ready(function ($) {
    const $tabs = $('.filter-tab');
    const $gallery = $('.photo-gallery');
    const $underline = $('.underline');

    function updateUnderline(tab) {
        const tabOffset = $(tab).position().left + 20; // 20px offset for the underline
        const tabWidth = $(tab).outerWidth();
        $underline.css({ left: tabOffset, width: tabWidth });
    }

    // Initially position the underline
    updateUnderline($('.filter-tab.active'));

    // Function to update the URL with the category parameter
    function updateURL(filter) {
        const url = new URL(window.location.href);
        url.searchParams.set('category', filter); // Update the 'category' query parameter
        history.pushState(null, '', url.toString()); // Update the URL without reloading
    }

    // Function to handle the filter update
    function updateFilter(filter) {
        // Update active tab
        $tabs.removeClass('active');
        $(`.filter-tab[data-filter="${filter}"]`).addClass('active');

        // Move the underline
        updateUnderline($(`.filter-tab[data-filter="${filter}"]`));

        // Update gallery content
        $gallery.addClass('fade-out').removeClass('fade-in');

        setTimeout(() => {
            if (filter === 'all') {
                $('.photo-item').show();
            } else {
                $('.photo-item').hide();
                $(`.photo-item[data-collection*="${filter}"]`).show();
            }

            // Fade in photos
            $gallery.removeClass('fade-out').addClass('fade-in');
        }, 700); // Match this delay with the CSS transition time
    }

    // Initially load filter based on the URL parameter
    const urlParams = new URLSearchParams(window.location.search);
    const categoryFromURL = urlParams.get('category') || 'featured'; // Default to 'all'
    updateFilter(categoryFromURL);

    // Bind click event for the filter tabs
    $tabs.on('click', function (e) {
        e.preventDefault();
        const filter = $(this).data('filter');

        // Update the URL with the selected filter
        updateURL(filter);

        // Update the filter content
        updateFilter(filter);
    });

    // Handle dropdown on mobile
    const filterTabs = document.getElementById("filterTabs");
    const tabs = filterTabs.querySelectorAll(".filter-tab");
    const select = document.createElement("select");

    // Create dropdown options from tabs
    tabs.forEach(tab => {
        const option = document.createElement("option");
        option.value = tab.dataset.filter;
        option.textContent = tab.textContent.trim();
        select.appendChild(option);
    });

    // Insert the dropdown at the top of the list
    filterTabs.prepend(select);

    // Handle selection change in the dropdown
    select.addEventListener("change", (event) => {
        const selectedFilter = event.target.value;

        // Update the URL with the selected filter
        updateURL(selectedFilter);

        // Update the filter content
        updateFilter(selectedFilter);

        // Sync active state with tabs
        tabs.forEach(tab => {
            tab.classList.toggle("active", tab.dataset.filter === selectedFilter);
        });
    });

    // Sync dropdown with the current URL filter
    select.value = categoryFromURL;
});
