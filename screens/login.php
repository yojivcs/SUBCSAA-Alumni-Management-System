<?php
require_once '../php/config.php';
require_once '../php/utils.php';
require_once '../php/session_handler.php';

CustomSessionHandler::init();

// If user is already logged in, redirect to appropriate dashboard
if (CustomSessionHandler::isAuthenticated()) {
    $user = CustomSessionHandler::getCurrentUser();
    $redirect = $user['role'] === 'admin' 
        ? BASE_URL . '/private/admin/dashboard.php'
        : BASE_URL . '/private/users/dashboard.php';
    header('Location: ' . $redirect);
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login / Signup - <?php echo APP_NAME; ?></title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Inter', sans-serif;
    }
    @keyframes fadeInUp {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
    .animate-fadeInUp {
      animation: fadeInUp 1s ease-out;
    }
  </style>
</head>
<body class="bg-gray-900 text-gray-100">
  <div class="flex h-screen">
    <!-- Left Section: Image with Transparent Overlay -->
    <div class="relative w-1/2 h-full hidden md:block">
      <img src="../assets/images/gallery-image.jpg" alt="Login Background" class="w-full h-full object-cover">
      <div class="absolute inset-0 bg-[#5E3792] opacity-80"></div>
      <a href="home.html" class="absolute top-6 right-6 bg-white text-[#5E3792] py-1.5 px-4 rounded-full shadow-md text-sm hover:bg-gray-200 transition duration-300 z-10 cursor-pointer">
        Back to Website →
      </a>
      <div class="absolute inset-0 flex items-center justify-center text-white text-center px-6">
        <h2 class="text-4xl md:text-5xl font-bold italic leading-relaxed">
          Connecting Alumni, Inspiring Futures
        </h2>
      </div>
    </div>

    <!-- Right Section: Login/Signup Form -->
    <div class="w-full md:w-1/2 flex items-center justify-center bg-gray-50 text-gray-800 px-6">
      <div class="w-full max-w-md animate-fadeInUp">
        <!-- Toggle Buttons -->
        <div class="flex justify-center mb-6 space-x-6">
          <button id="login-btn" class="text-[#5E3792] border-b-2 border-[#5E3792] pb-2 font-semibold focus:outline-none">Login</button>
          <button id="signup-btn" class="text-gray-600 border-b-2 border-transparent pb-2 font-semibold focus:outline-none">Sign Up</button>
        </div>

        <!-- Login Form -->
        <form id="login-form" method="POST" action="../php/login.php" class="space-y-4">
          <h1 class="text-3xl font-bold text-center mb-4 text-[#5E3792]">Welcome Back</h1>
          <input type="hidden" name="csrf_token" value="<?php echo Utils::generateCSRFToken(); ?>">
          <input type="text" name="username" placeholder="Username" class="w-full px-4 py-2 border rounded-lg" required>
          <input type="password" name="password" placeholder="Password" class="w-full px-4 py-2 border rounded-lg" required>
          <button type="submit" class="w-full bg-[#5E3792] text-white py-2 rounded-lg hover:bg-purple-800">
            Login
          </button>
          <?php if (isset($_GET['error'])): ?>
            <p class="text-red-500 text-center"><?php echo htmlspecialchars($_GET['error']); ?></p>
          <?php endif; ?>
        </form>

        <!-- Signup Form (Hidden by default) -->
        <form id="signup-form" method="POST" action="../php/register.php" class="hidden space-y-4">
          <h1 class="text-3xl font-bold text-center mb-4 text-[#5E3792]">Create Account</h1>
          <input type="hidden" name="csrf_token" value="<?php echo Utils::generateCSRFToken(); ?>">
          <input type="text" name="full_name" placeholder="Full Name" class="w-full px-4 py-2 border rounded-lg" required>
          <input type="text" name="username" placeholder="Username" class="w-full px-4 py-2 border rounded-lg" required>
          <input type="password" name="password" placeholder="Password" class="w-full px-4 py-2 border rounded-lg" required>
          <input type="text" name="student_id" placeholder="Student ID (XXX-XX-XX)" class="w-full px-4 py-2 border rounded-lg" required>
          <input type="number" name="graduation_year" placeholder="Graduation Year" class="w-full px-4 py-2 border rounded-lg" required>
          <button type="submit" class="w-full bg-[#5E3792] text-white py-2 rounded-lg hover:bg-purple-800">
            Sign Up
          </button>
          <?php if (isset($_GET['signup_error'])): ?>
            <p class="text-red-500 text-center"><?php echo htmlspecialchars($_GET['signup_error']); ?></p>
          <?php endif; ?>
        </form>
      </div>
    </div>
  </div>

  <script>
    const loginBtn = document.getElementById('login-btn');
    const signupBtn = document.getElementById('signup-btn');
    const loginForm = document.getElementById('login-form');
    const signupForm = document.getElementById('signup-form');

    loginBtn.addEventListener('click', () => {
      loginForm.classList.remove('hidden');
      signupForm.classList.add('hidden');
      loginBtn.classList.add('text-[#5E3792]', 'border-[#5E3792]');
      loginBtn.classList.remove('text-gray-600', 'border-transparent');
      signupBtn.classList.add('text-gray-600', 'border-transparent');
      signupBtn.classList.remove('text-[#5E3792]', 'border-[#5E3792]');
    });

    signupBtn.addEventListener('click', () => {
      signupForm.classList.remove('hidden');
      loginForm.classList.add('hidden');
      signupBtn.classList.add('text-[#5E3792]', 'border-[#5E3792]');
      signupBtn.classList.remove('text-gray-600', 'border-transparent');
      loginBtn.classList.add('text-gray-600', 'border-transparent');
      loginBtn.classList.remove('text-[#5E3792]', 'border-[#5E3792]');
    });

    // Form validation
    document.querySelectorAll('form').forEach(form => {
      form.addEventListener('submit', function(e) {
        const password = this.querySelector('input[name="password"]');
        if (password && password.value.length < <?php echo PASSWORD_MIN_LENGTH; ?>) {
          e.preventDefault();
          alert('Password must be at least <?php echo PASSWORD_MIN_LENGTH; ?> characters long');
          return;
        }

        const studentId = this.querySelector('input[name="student_id"]');
        if (studentId && !/^\d{3}-\d{2}-\d{2}$/.test(studentId.value)) {
          e.preventDefault();
          alert('Student ID must be in format XXX-XX-XX');
          return;
        }

        const gradYear = this.querySelector('input[name="graduation_year"]');
        if (gradYear) {
          const year = parseInt(gradYear.value);
          const currentYear = new Date().getFullYear();
          if (year < 2000 || year > currentYear + 6) {
            e.preventDefault();
            alert('Please enter a valid graduation year');
            return;
          }
        }
      });
    });
  </script>
</body>
</html>
