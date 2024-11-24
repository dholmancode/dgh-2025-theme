const projects = document.querySelectorAll(".featured-project");

if (projects.length > 0) {
  let currentIndex = 0;

  // Initialize: Show the first project initially with a smooth fade-in effect
  projects[currentIndex].classList.add("active");
  projects[currentIndex].style.display = "flex"; // Make sure it is visible
  projects[currentIndex].style.opacity = "0"; // Start invisible
  setTimeout(() => {
    projects[currentIndex].style.opacity = "1"; // Fade in
  }, 50); // Small delay to allow CSS transition to take effect

  // Cycle through projects every 6 seconds
  setInterval(() => {
    // Fade out the current project
    projects[currentIndex].style.opacity = "0";
    projects[currentIndex].classList.remove("active");

    // Timeout to allow fade-out transition to complete
    setTimeout(() => {
      // Hide the current project
      projects[currentIndex].style.display = "none";

      // Move to the next project
      currentIndex = (currentIndex + 1) % projects.length;

      // Show the next project
      projects[currentIndex].style.display = "flex";
      projects[currentIndex].classList.add("active");
      projects[currentIndex].style.opacity = "0"; // Start hidden
      setTimeout(() => {
        projects[currentIndex].style.opacity = "1"; // Fade in smoothly
      }, 50); // Small delay for smooth transition
    }, 1500); // Match this duration with your CSS fade-out time
  }, 10000); // Change every 10 seconds
}


  // Project tabs --------------------------------------------------------------------------------------------
  window.onload = function() {
    const projectTabs = document.querySelectorAll(".project-item");

    projectTabs.forEach((project) => {
        const tabs = project.querySelectorAll(".tab");
        const tabContents = project.querySelectorAll(".tab-content");
        const underline = project.querySelector(".tab-underline");

        const activateTab = (tab) => {
            // Remove active class from all tabs
            tabs.forEach((t) => t.classList.remove("active"));

            // Fade out and hide all tab contents
            tabContents.forEach((content) => {
                content.style.opacity = 0;
                setTimeout(() => {
                    content.classList.remove("active");
                    content.style.visibility = "hidden";
                }, 500); // Matches fade-out duration
            });

            // Activate the clicked tab and fade in its content
            tab.classList.add("active");
            const targetContent = document.getElementById(tab.dataset.tab);

            // Delay to allow fade-out of previous content before fading in new content
            setTimeout(() => {
                targetContent.classList.add("active");
                targetContent.style.visibility = "visible";
                targetContent.style.opacity = 1; // Fade in smoothly
            }, 500); // Matches fade-out delay

            // Position and resize underline based on the active tab
            const tabRect = tab.getBoundingClientRect();
            const titlesRect = project.querySelector(".tab-titles").getBoundingClientRect();
            underline.style.width = `${tabRect.width}px`;
            underline.style.transform = `translateX(${tabRect.left - titlesRect.left}px)`;
        };

        // Initialize by activating the first tab and its content
        if (tabs.length > 0) {
            activateTab(tabs[0]);
        }

        // Add click event listener to each tab
        tabs.forEach((tab) => {
            tab.addEventListener("click", () => activateTab(tab));
        });
    });
};
// Scroll Animations

document.addEventListener('DOMContentLoaded', () => {
  const animateElements = document.querySelectorAll('.project-item');

  const observer = new IntersectionObserver((entries) => {
      entries.forEach((entry) => {
          console.log(`Observing: ${entry.target}`); // Debugging
          if (entry.isIntersecting) {
              // Add 'visible' class when the element enters the viewport
              entry.target.classList.add('visible');
          } else {
              // Remove 'visible' class when the element leaves the viewport
              entry.target.classList.remove('visible');
          }
      });
  }, { threshold: 0.25 }); // Adjust to your desired visibility threshold

  animateElements.forEach((element) => observer.observe(element));
});
