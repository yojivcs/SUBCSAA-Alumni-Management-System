// load_sidebar.js
function loadSidebar() {
    fetch('/shared/user_sidebar.html') // Adjust this path based on your directory structure
      .then(response => {
        if (!response.ok) {
          throw new Error('Failed to load sidebar');
        }
        return response.text();
      })
      .then(html => {
        document.getElementById('sidebar-container').innerHTML = html;
      })
      .catch(error => {
        console.error('Error loading sidebar:', error);
      });
  }
  
  // Call the function to load the sidebar
  loadSidebar();
  