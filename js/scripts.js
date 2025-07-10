function loadComponents() {
  // Load Header
  fetch('../components/header.html')
    .then(response => {
      if (!response.ok) throw new Error('Failed to fetch header.html');
      return response.text();
    })
    .then(data => document.getElementById('header').innerHTML = data)
    .catch(error => console.error('Error loading header:', error));

  // Load Footer
  fetch('../components/footer.html')
    .then(response => {
      if (!response.ok) throw new Error('Failed to fetch footer.html');
      return response.text();
    })
    .then(data => document.getElementById('footer').innerHTML = data)
    .catch(error => console.error('Error loading footer:', error));
}

// Counter Animation Logic
document.addEventListener("DOMContentLoaded", () => {
  loadComponents(); // Ensure components are loaded first

  const counters = [
    { id: "yearFounded", target: 2005 },
    { id: "activeAlumni", target: 5000 },
    { id: "eventsOrganized", target: 150 },
    { id: "countriesRepresented", target: 25 },
  ];

  const startCounter = (element, target) => {
    let count = 0;
    const step = Math.ceil(target / 100); // Control the animation smoothness
    const speed = 20; // Milliseconds between increments

    const timer = setInterval(() => {
      count += step;
      if (count >= target) {
        count = target;
        clearInterval(timer);
      }
      element.textContent = count; // Update the number
    }, speed);
  };

  // Trigger counters only when in viewport
  const options = { threshold: 0.5 }; // Trigger when 50% of the section is visible
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        counters.forEach(counter => {
          const element = document.getElementById(counter.id);
          if (element && element.textContent == "0") {
            startCounter(element, counter.target);
          }
        });
      }
    });
  });

  // Observe the section containing counters
  const counterSection = document.querySelector("section.py-12");
  if (counterSection) observer.observe(counterSection);
});

