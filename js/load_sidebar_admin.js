// load_sidebar.js
function loadSidebar() {
    fetch('/shared/admin_sidebar.html') // Adjust this path based on your directory structure
      .then(response => {
        if (!response.ok) {
          throw new Error('Failed to load sidebar');
        }
        return response.text();
      })
      .then(html => {
        document.getElementById("sidebar-container").innerHTML = `
        <div class="sidebar">
          <h2 class="text-white text-xl font-bold p-4">Admin Dashboard</h2>
          <a href="/private/admin/dashboard.html">Dashboard</a>
          <a href="/private/admin/manage_users.html">Manage Users</a>
          <a href="/private/admin/alumni_directory.html">Alumni Directory</a>
          <a href="/private/admin/manage_events.html">Manage Events</a>
          <a href="/private/admin/manage_jobs.html">Manage Job Posts</a>
          <a href="/private/admin/logout.php">Logout</a>
        </div>
      `;
      

      })
      .catch(error => {
        console.error('Error loading sidebar:', error);
      });
  }
  
  // Call the function to load the sidebar
  loadSidebar();
  