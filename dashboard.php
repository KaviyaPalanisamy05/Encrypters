<?php
session_start();
?>
<!-- for displaying the username after login and signup  -->

<!doctype html>
<html lang="en">

<!-- header starts  -->
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Encrypters</title>

  <!-- bootstrap link -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

  <!-- styles start -->
  <style>
    body,
    html {
      height: 100%;
      margin: 0;
      background: black;
      overflow-x: hidden;
    }

    canvas#particleCanvas {
      position: fixed;
      top: 0;
      left: 0;
      z-index: 0;
      width: 100%;
      height: 100%;
      display: block;
    }

    body>*:not(canvas) {
      position: relative;
      z-index: 1;
    }

    .card {
      background-color: #1c1c1c;
      color: #fff;
      border: none;
      border-radius: 15px;
      box-shadow: 0 6px 18px rgba(0, 0, 0, 0.6);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      margin: 10px;
      width: 22%;
    }

    .card:hover {
      transform: translateY(-8px);
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.8);
    }

    .card-title {
      color: #0d6efd;
      font-weight: bold;
    }

    .card-text {
      font-size: 0.95rem;
      color: #ccc;
    }

    .card .btn-primary {
      background-color: #0d6efd;
      border: none;
      border-radius: 25px;
      padding: 8px 20px;
      transition: background-color 0.3s ease;
    }

    .card .btn-primary:hover {
      background-color: #0056b3;
    }

    .card-img-top {
      width: 100%;
      height: 200px;
      object-fit: cover;
      border-top-left-radius: 15px;
      border-top-right-radius: 15px;
    }

    .navbar-nav .nav-link {
      position: relative;
      transition: color 0.2s ease-in-out;
    }

    .navbar-nav .nav-link::after {
      content: '';
      position: absolute;
      width: 0;
      height: 2px;
      background-color: #fff;
      bottom: -4px;
      left: 0;
      transition: width 0.3s ease;
    }

    .navbar-nav .nav-link:hover::after {
      width: 100%;
    }

    .dropdown-menu .dropdown-item:hover {
      background-color: #f7f7f7;
    }

    .search-bar {
      max-width: 600px;
      margin: 30px auto;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      border-radius: 30px;
      overflow: hidden;
      transition: box-shadow 0.3s ease-in-out;
    }

    .search-bar:hover {
      box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
    }

    .search-bar input {
      border: none;
      border-radius: 30px 0 0 30px;
      padding: 15px 20px;
    }

    .search-bar button {
      border-radius: 0 30px 30px 0;
      padding: 15px 25px;
    }

    .navbar-center {
      position: absolute;
      left: 50%;
      transform: translateX(-50%);
    }

    .card-columns {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
    }

    .custom-auth-btn {
      border-radius: 30px;
      padding: 10px 30px;
      font-weight: 600;
      transition: all 0.3s ease-in-out;
    }

    .custom-auth-btn:hover {
      transform: scale(1.05);
      box-shadow: 0 0 10px rgba(255, 255, 255, 0.3);
    }
  </style>
  <!-- styles end  -->

</head>
<!-- end of header  -->

<!-- body starts  -->
<body>

  <!-- particles background -->
  <canvas id="particleCanvas"></canvas>

  <!-- navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark position-relative">
    <div class="container-fluid">
      <a class="navbar-brand d-flex align-items-center" href="#">
        <img src="img/logo.jpg" alt="Logo" width="30" height="30" class="me-2">
        <strong>ENCRYPTERS</strong>
      </a>
      <div class="navbar-center d-none d-lg-block">
        <ul class="navbar-nav flex-row gap-3">
          <li class="nav-item"><a class="nav-link active fw-semibold" href="dashboard.php">Home</a></li>
          <li class="nav-item"><a class="nav-link fw-semibold" href="dashboard.php">Services</a></li>
        </ul>
      </div>
      <div class="ms-auto">
        <div class="dropdown">
          <?php
          $username = isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'User';
          ?>
          <button class="btn btn-outline-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <?php echo $username; ?>
          </button>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="logout.php">Logout</a></li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li><a class="dropdown-item" href="#">Help Centre</a></li>
          </ul>
        </div>
      </div>
    </div>
  </nav>

  <?php if (!isset($_SESSION['username'])): ?>
    <!-- signup / login buttons (only if not logged in) -->
    <div class="container text-center mt-4">
      <a href="signup.html" class="btn btn-outline-primary btn-lg me-3 custom-auth-btn">
        <i class="bi bi-person-plus"></i> Sign Up
      </a>
      <a href="login.html" class="btn btn-outline-success btn-lg custom-auth-btn">
        <i class="bi bi-box-arrow-in-right"></i> Log In
      </a>
    </div>
  <?php endif; ?>


  <!-- search course -->
  <div class="container">
    <form class="search-bar d-flex bg-white rounded-pill">
      <input class="form-control flex-grow-1" type="search" placeholder="Search for cyber security courses..." aria-label="Search">
      <button class="btn btn-danger" type="submit">Search</button>
    </form>
  </div>



  <!-- start of card -->
  <div class="container mt-4">
    <div class="card-columns">
      <div class="card">
        <img src="img/c1.avif" class="card-img-top" alt="...">
        <div class="card-body">
          <h5 class="card-title">Network Security Fundamentals</h5>
          <p class="card-text">Gain foundational/advanced skills to secure and monitor computer networks and your system.</p>
          <a href="#" class="btn btn-primary">Enroll now</a>
        </div>
      </div>
      <div class="card">
        <img src="img/c2.jpg" class="card-img-top" alt="...">
        <div class="card-body">
          <h5 class="card-title">Ethical Hacking & Penetration Testing</h5>
          <p class="card-text">Learn to ethically hack systems and identify security weaknesses, vulnerability and protect them.</p>
          <a href="#" class="btn btn-primary">Enroll now</a>
        </div>
      </div>
      <div class="card">
        <img src="img/c3.jpg" class="card-img-top" alt="...">
        <div class="card-body">
          <h5 class="card-title">Web Application Security</h5>
          <p class="card-text">Discover how to secure websites from common vulnerabilities like XSS and SQLi.</p>
          <a href="#" class="btn btn-primary">Enroll now</a>
        </div>
      </div>
      <div class="card">
        <img src="img/c4.jpg" class="card-img-top" alt="...">
        <div class="card-body">
          <h5 class="card-title">Cryptography & Data Protection</h5>
          <p class="card-text">Understand encryption techniques to protect sensitive data of the system and the organisation.</p>
          <a href="#" class="btn btn-primary">Enroll now</a>
        </div>
      </div>
    </div>
    <div class="card-columns">
      <div class="card">
        <img src="img/c5.jpg" class="card-img-top" alt="...">
        <div class="card-body">
          <h5 class="card-title">Incident Response & Forensics</h5>
          <p class="card-text">Learn to investigate breaches and respond to cyber incidents effectively.</p>
          <a href="#" class="btn btn-primary">Enroll now</a>
        </div>
      </div>
      <div class="card">
        <img src="img/c6.webp" class="card-img-top" alt="...">
        <div class="card-body">
          <h5 class="card-title">Malware Analysis & Reverse Engineering</h5>
          <p class="card-text">Analyze malicious code and uncover how malware operates and protect them.</p>
          <a href="#" class="btn btn-primary">Enroll now</a>
        </div>
      </div>
      <div class="card">
        <img src="img/c7.jpg" class="card-img-top" alt="...">
        <div class="card-body">
          <h5 class="card-title">Cloud Security Essentials</h5>
          <p class="card-text">Secure cloud platforms and manage data privacy in virtual environments.</p>
          <a href="#" class="btn btn-primary">Enroll now</a>
        </div>
      </div>
      <div class="card">
        <img src="img/c8.jpg" class="card-img-top" alt="...">
        <div class="card-body">
          <h5 class="card-title">Security Operations & SIEM</h5>
          <p class="card-text">Monitor threats and manage security events using SIEM tools on real time monitoring.</p>
          <a href="#" class="btn btn-primary">Enroll now</a>
        </div>
      </div>
    </div><br>
    <center>
      <h3><strong style="color:white" ;>Continue exploring courses</strong></h3><br>
      <button type="button" class="btn btn-secondary">Show More >></button>
    </center>
  </div>
  <!-- end of cards -->

  <!-- footer -->
  <footer class="bg-dark text-white text-center text-lg-start mt-5 pt-4 pb-3">
    <div class="container">
      <div class="row">
        <div class="col-md-4">
          <h5 class="text-uppercase">About Encrypters</h5>
          <p>Secure and easy-to-use encryption services to protect your privacy online.</p>
        </div>
        <div class="col-md-4">
          <h5 class="text-uppercase">Quick Links</h5>
          <ul class="list-unstyled">
            <li>Home</li>
            <li>Privacy Policy</li>
            <li>Terms of Service</li>
            <li>Contact Us</li>
          </ul>
        </div>
        <div class="col-md-4">
          <h5 class="text-uppercase">Follow Us</h5>
          <ul class="list-unstyled">
            <li><i class="bi bi-facebook"></i>&nbsp;<i class="bi bi-twitter"></i>&nbsp;<i class="bi bi-instagram"></i>&nbsp;<i class="bi bi-linkedin"></i></li>
            <li>Feel free to contact us!</li>
            <li>Cybersecurity is not just a technology issue—it's a trust issue.</li>
          </ul>
        </div>
      </div>
      <div class="text-center mt-4">
        <p class="mb-0">&copy; 2025 Encrypters. All Rights Reserved.</p>
      </div>
    </div>
  </footer>

  <!-- particles script -->
  <script>
    const canvas = document.getElementById('particleCanvas');
    const ctx = canvas.getContext('2d');
    let particlesArray = [];
    const particleCount = 100;

    function resizeCanvas() {
      canvas.width = window.innerWidth;
      canvas.height = window.innerHeight;
    }

    window.addEventListener('resize', resizeCanvas);
    resizeCanvas();

    class Particle {
      constructor() {
        this.x = Math.random() * canvas.width;
        this.y = Math.random() * canvas.height;
        this.size = Math.random() * 3 + 1;
        this.speedX = Math.random() * 1 - 0.5;
        this.speedY = Math.random() * 1 - 0.5;
        this.color = 'rgba(0, 123, 255, 0.7)';
      }

      update() {
        this.x += this.speedX;
        this.y += this.speedY;
        if (this.x < 0 || this.x > canvas.width) this.speedX *= -1;
        if (this.y < 0 || this.y > canvas.height) this.speedY *= -1;
      }

      draw() {
        ctx.beginPath();
        ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
        ctx.fillStyle = this.color;
        ctx.fill();
      }
    }

    function init() {
      particlesArray = [];
      for (let i = 0; i < particleCount; i++) {
        particlesArray.push(new Particle());
      }
    }

    function animate() {
      ctx.clearRect(0, 0, canvas.width, canvas.height);
      particlesArray.forEach(p => {
        p.update();
        p.draw();
      });
      requestAnimationFrame(animate);
    }

    init();
    animate();
  </script>

  <!-- bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>