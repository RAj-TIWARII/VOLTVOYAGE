<?php 
session_start(); 
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>VOLTVOYAGE | Explore the Cosmos</title>
    <link rel="icon" type="image/png" href="Images/VOYAGELOGO.png">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome CSS for fas icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <style>
        /* Smooth scrolling */
        html {
            scroll-behavior: smooth;
        }

        /* Body style */
        body {
            background: #dbeeff;
            font-family: 'Helvetica Neue', Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        /* Transparent, sticky navbar */
        .navbar {
            background: none !important;
            transition: opacity 0.4s ease;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
        }

        .navbar.fade-out {
            opacity: 0;
        }

        /* Branding text effect */
        .text-shyblue {
            background: linear-gradient(to right, #4e9af1, #6fb3f7);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Nav link hover effects & tooltip */
        .nav-link {
            position: relative;
            transition: background-color 0.3s ease;
            padding: 0.5rem 1rem;
        }

        .nav-link:hover {
            background-color: rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }

        /* Tooltip styling for nav links */
        .nav-link[data-tooltip]:hover::after {
            content: attr(data-tooltip);
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translate(-50%, 5px);
            background-color: rgba(0, 0, 0, 0.8);
            color: #fff;
            padding: 3px 8px;
            border-radius: 4px;
            white-space: nowrap;
            opacity: 0;
            animation: fadeIn 0.3s forwards;
            pointer-events: none;
            font-size: 0.75rem;
            margin-top: 4px;
        }

        @keyframes fadeIn {
            to {
                opacity: 1;
                transform: translate(-50%, 0);
            }
        }

        /* Hero section */
        .hero {
            height: 80vh;
            background: url("my_hero_bg.png") no-repeat center center / cover;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            padding: 0 2rem;
            color: #333;
        }

        .hero-content {
            position: relative;
            z-index: 1;
            color: #000;
        }

        /* Section headings */
        .section-heading {
            font-size: 2.2rem;
            font-weight: bold;
            margin-bottom: 1.2rem;
        }

        /* Buttons */
        .btn-custom {
            border-radius: 20px;
            border: none;
        }

        /* Search Modal */
        .modal-search .modal-content {
            background: #fff;
            border: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            color: #000;
            margin-top: 10%;
        }

        .modal-search .modal-header {
            display: none;
        }

        .modal-search .modal-body {
            background: #fff;
            padding: 1rem;
        }

        .modal-search .form-control {
            border-radius: 20px;
            border: 1px solid #4e9af1;
            padding: 10px;
            background: #fff;
            color: #000;
        }

        .suggestion-list {
            margin-top: 0.5rem;
            list-style-type: none;
            padding-left: 0;
        }

        .suggestion-item {
            background: #4e9af1;
            padding: 8px 12px;
            border-radius: 5px;
            margin: 3px 0;
            cursor: pointer;
            color: #fff;
        }

        .suggestion-item:hover {
            background: #6fb3f7;
        }

        /* Footer */
        footer {
            background: #1a1a1a;
            color: #fff;
            text-align: center;
            padding: 2rem 0;
        }

        /* Card hover effects */
        .card {
            transition: transform 0.3s;
            border: none;
            border-radius: 1rem;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        /* Hide nav items on mobile */
        @media (max-width: 768px) {
            .navbar-nav {
                display: none;
            }
            .navbar .navbar-toggler {
                display: none;
            }
            .navbar .nav-item {
                display: none;
            }

            /* Show only search and user icon on mobile */
            .d-flex.align-items-center {
                display: flex;
            }
        }
    </style>
</head>

<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-md">
        <div class="container">
            <!-- Brand on left -->
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="Images/VOYAGELOGO.png" alt="VOLTVOYAGE" height="40" class="me-2">
                <span class="text-shyblue">VOLTVOYAGE</span>
            </a>
            <!-- Toggler for mobile view -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
              data-bs-target="#navbarContent" aria-controls="navbarContent"
              aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Navbar items -->
            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item px-2">
                        <a class="nav-link" style="color: #72abff;" href="#hero" data-tooltip="Home">Home</a>
                    </li>
                    <li class="nav-item px-2">
                        <a class="nav-link" style="color: #72abff;" href="#about" data-tooltip="About">About</a>
                    </li>
                    <li class="nav-item px-2">
                        <a class="nav-link" style="color: #72abff;" href="#missions"
                            data-tooltip="Missions">Missions</a>
                    </li>
                    <li class="nav-item px-2">
                        <a class="nav-link" style="color: #72abff;" href="#contact" data-tooltip="Contact">Contact</a>
                    </li>
                </ul>
            </div>
            <!-- Right side icons (Search & Profile) -->
            <div class="d-flex align-items-center">
                <button class="btn btn-link text-white me-3" id="openSearchModal">
                    <i class="fas fa-search fa-lg" style="color: #72abff;"></i>
                </button>
                <button class="btn btn-outline-light btn-custom" style="color: #4174c0;">
                    <i class="fas fa-user" style="color: #72abff;"></i> &nbsp; 
                    <?php 
                    if (isset($_SESSION['username'])) { 
                        echo htmlspecialchars($_SESSION['username']); 
                    } else { 
                        echo "Account"; 
                    } 
                    ?>
                </button>

                <!-- Profile Card Dropdown -->
                <div id="profileCard" style="display: none; position: absolute; top: 60px; right: 10px; z-index: 9999; background: #e6f1ff; color: #000; border-radius: 15px; padding: 15px 20px; box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15); min-width: 220px; transition: all 0.3s ease;">
                    <div style="font-weight: bold; font-size: 18px; color: #4174c0; margin-bottom: 10px;">
                        <i class="fas fa-user-circle me-2"></i>
                        <?php echo htmlspecialchars($_SESSION['username'] ?? 'Guest'); ?>
                    </div>
                    <hr style="border-color: #b5d5ff;">
                    <a href="profile.php" style="display: block; text-align: center; padding: 8px 15px; background-color: #72abff; color: white; border-radius: 10px; text-decoration: none; font-weight: 500;">
                        Go to Profile
                    </a>
                </div>
            </div>
        </div>
    </nav>



    <!-- HERO SECTION -->
    <section id="hero" class="hero">
        <div class="hero-content">
            <h1 class="display-4 text-shyblue">
                <img src="Images/VOYAGELOGO.png" width="150px" alt=""> VOLTVOYAGE
            </h1>
            <p class="lead">Embark on an interstellar journey where tradition meets innovation.</p>
            <a href="#about" class="btn btn-primary btn-custom mt-3">Discover Our Journey</a>
        </div>
    </section>

    <!-- WHAT IS VOLTVOYAGE SECTION -->
    <section id="what-is-voltvoyage" class="py-5 bg-light">
        <div class="container">
            <h2 class="section-heading text-center text-shyblue">What is VOLTVOYAGE?</h2>
            <p class="lead text-center mb-4">Your cosmic companion guiding you through the wonders of space exploration!
            </p>
            

            <!-- Introductory Content -->
            <div class="row align-items-center mb-5">
                <div class="col-md-6">
                    <h3 class="text-shyblue"><i class="fas fa-rocket"></i> Our Mission</h3>
                    <p>
                        VOLTVOYAGE is more than just a name—it’s your friend in the cosmic journey, here to guide you
                        into the depths of space exploration. With a blend of timeless values and futuristic innovation,
                        we equip you with the knowledge and inspiration to explore new horizons.
                    </p>
                    <p>
                        Whether you’re a curious traveler or a dedicated researcher, our goal is to bring you closer to
                        the marvels of the universe. We believe that every star has a story, and every mission is a step
                        towards a brighter, boundless future.
                    </p>
                </div>
                <div class="col-md-6">
                    <img src="Images/rocketlaunch.gif" alt="Space Exploration" class="img-fluid rounded">
                </div>
            </div>

            <!-- Features Cards -->
            <div class="row text-center mb-5">
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <h5 class="card-title text-shyblue"><i class="fas fa-user-friends"></i> Community</h5>
                            <p class="card-text">
                                Join our ever-growing network of space enthusiasts and experts. We believe the universe
                                is best explored together.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <h5 class="card-title text-shyblue"><i class="fas fa-flask"></i> Research & Innovation</h5>
                            <p class="card-text">
                                Pioneering breakthroughs in space technology and sciences, our research initiatives are
                                at the forefront of innovation.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <h5 class="card-title text-shyblue"><i class="fas fa-bullseye"></i> Future Visions</h5>
                            <p class="card-text">
                                Dream big with us—we’re turning visionary space projects into tomorrow's reality, one
                                launch at a time.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detailed Explanation -->
            <div class="row mt-5">
                <div class="col">
                    <h3 class="text-shyblue text-center mb-3"><i class="fas fa-lightbulb"></i> Why Choose VOLTVOYAGE?
                    </h3>
                    <p>
                        VOLTVOYAGE stands at the intersection of tradition and the future. We pride ourselves on merging
                        decades of wisdom with groundbreaking innovation to create a unique, all-encompassing
                        experience. Our comprehensive approach means that you not only get to explore the latest in
                        space technology but also gain a deeper understanding of the rich history that paved the way.
                    </p>
                    <p>
                        With VOLTVOYAGE, you’re not just consuming information; you’re joining a movement—a community of
                        explorers, innovators, and dreamers. We’re here to spark your curiosity, fuel your passion, and
                        empower you with the tools to unlock the secrets of the universe.
                    </p>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-check text-shyblue me-2"></i> Empowering curious minds with profound
                            knowledge.</li>
                        <li><i class="fas fa-check text-shyblue me-2"></i> Fostering a vibrant, inclusive community of
                            explorers.</li>
                        <li><i class="fas fa-check text-shyblue me-2"></i> Leading innovative research to redefine space
                            travel.</li>
                        <li><i class="fas fa-check text-shyblue me-2"></i> Transforming futuristic visions into
                            accessible realities.</li>
                    </ul>
                    <p>
                        Whether you’re looking to dive into the mysteries of deep space, join innovative research
                        projects, or simply marvel at the universe, VOLTVOYAGE is your reliable companion. Let’s journey
                        together into a world where every star narrates a tale and every discovery lights the path to a
                        dazzling future.
                    </p>
                </div>
            </div>
        </div>
    </section>


    <!-- ABOUT SECTION -->
    <section id="about" class="py-5 bg-white">
        <div class="container">
            <div class="row mb-5">
                <div class="col">
                    <h2 class="section-heading text-center text-shyblue">About VOLTVOYAGE</h2>
                    <p class="lead text-center">
                        VOLTVOYAGE is where we unite to explore space – a visionary platform founded by Raj Tiwari,
                        supported by a passionate team of innovators.
                    </p>
                </div>
            </div>
            <div class="row align-items-center mb-5">
                <div class="col-md-6">
                    <h3 class="text-shyblue"><i class="fas fa-users"></i> Our Team & Legacy</h3>
                    <p>
                        At VOLTVOYAGE, we believe the cosmos is meant to be explored together. our
                        journey started with a dream and has grown into a movement driven by collaboration, innovation,
                        and a commitment to unearthing the wonders of space.
                    </p>
                    <p>
                        With a diverse team of experts, engineers, scientists, and enthusiasts, we are not just a
                        company – we are a family united by our passion for the stars. Every team member plays a vital
                        role in shaping our shared future among the cosmos.
                    </p>
                </div>
                <div class="col-md-6">
                    <img src="vol" alt="Our Team at VOLTVOYAGE" class="img-fluid rounded shadow">
                </div>
            </div>
            <div class="row align-items-center mb-5">
                <div class="col-md-6 order-md-2">
                    <h3 class="text-shyblue"><i class="fas fa-rocket"></i> Our Future Plans</h3>
                    <p>
                        Looking ahead, VOLTVOYAGE is not just about exploring; it’s about innovating for tomorrow. Our
                        ambitious plans include designing and launching our own satellite to capture real-time data from
                        space – a pivotal step towards smarter, more informed discoveries.
                    </p>
                    <p>
                        Imagine accessing invaluable space data and insights right from your device! Our upcoming
                        projects aim to empower research, revolutionize communications, and spark new scientific
                        breakthroughs.
                    </p>
                </div>
                <div class="col-md-6 order-md-1">
                    <img src="https://source.unsplash.com/800x600/?satellite,space" alt="Future Satellite Project" class="img-fluid rounded shadow">
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <h3 class="text-shyblue text-center mb-3"><i class="fas fa-lightbulb"></i> Stay With Us</h3>
                    <p>
                        We invite you to join us on this remarkable journey into the unknown. Whether you’re a seasoned
                        explorer, an aspiring researcher, or simply a curious mind, VOLTVOYAGE is your gateway to the
                        mysteries of the universe.
                    </p>
                    <p>
                        Stay connected to receive updates on our latest projects, groundbreaking research, and every
                        milestone we achieve together in our quest for cosmic knowledge. The future is vast, and
                        together, we can traverse its infinite possibilities.
                    </p>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-check text-shyblue me-2"></i> Uniting passionate minds for innovative space
                            research.</li>
                        <li><i class="fas fa-check text-shyblue me-2"></i> Developing cutting-edge technology to monitor
                            and explore space.</li>
                        <li><i class="fas fa-check text-shyblue me-2"></i> Building our own satellite for real-time
                            cosmic insights.</li>
                        <li><i class="fas fa-check text-shyblue me-2"></i> Collaborating with global experts to push the
                            boundaries of exploration.</li>
                    </ul>
                    <p class="text-center mt-4">
                        <a href="#contact" class="btn btn-primary btn-custom">
                            <i class="fas fa-envelope"></i> Connect With Us
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </section>


    <!-- MISSIONS SECTION -->
    <section id="missions" class="py-5 bg-light">
        <div class="container">
            <h2 class="section-heading text-center text-shyblue">Our Missions</h2>
            <p class="text-center mb-5">From lunar expeditions to orbital stations, our projects push the boundaries of
                innovation.</p>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card shadow-sm h-100">
                        <img src="Images/chandryaan3image.jpg" class="card-img-top" alt="Lunar">
                        <div class="card-body">
                            <h5 class="card-title text-shyblue">Lunar Expedition</h5>
                            <p class="card-text">Join us as we unlock the Moon's hidden treasures, forging new frontiers
                                in cosmic discovery.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm h-100">
                        <img src="Images/SattImages.gif" class="card-img-top" alt="Satellite">
                        <div class="card-body">
                            <h5 class="card-title text-shyblue">Satellite Innovations</h5>
                            <p class="card-text">Revolutionizing Earth observation and global connectivity, our
                                satellites reshape the way we see the world.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm h-100">
                        <img src="Images/deepspaceexplorationImages.gif" class="card-img-top" alt="Deep Space">
                        <div class="card-body">
                            <h5 class="card-title text-shyblue">Deep Space Research</h5>
                            <p class="card-text">Venturing beyond known horizons, we explore distant galaxies and
                                unravel the universe’s greatest secrets.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- STELLAR CONNECTION SECTION -->
    <section id="stellar-connection" class="py-5 bg-dark text-light">
        <div class="container">
            <!-- Section Header -->
            <div class="row mb-5">
                <div class="col">
                    <h2 class="section-heading text-center text-shyblue">Stellar Connection</h2>
                    <p class="lead text-center">
                        Ready to blast off with us? Whether you're curious about space, have a brilliant idea, or just
                        want to say hello, get in touch and join the voyage!
                    </p>
                </div>
            </div>
            <!-- Contact Form Section -->
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <form id="contactForm" class="needs-validation" novalidate action="contact.php" method="POST">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="contactName" class="form-label">
              <i class="fas fa-user me-2"></i>Your Name
            </label>
                                <input type="text" class="form-control" id="contactName" name="name" placeholder="Enter your name" required>
                                <div class="invalid-feedback">Please enter your name.</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="contactEmail" class="form-label">
              <i class="fas fa-envelope me-2"></i>Email Address
            </label>
                                <input type="email" class="form-control" id="contactEmail" name="email" placeholder="name@example.com" required>
                                <div class="invalid-feedback">Please enter a valid email address.</div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="contactSubject" class="form-label">
            <i class="fas fa-tag me-2"></i>Subject
          </label>
                            <input type="text" class="form-control" id="messagesubject" name="messagesubject" placeholder="Subject of your message" required>
                            <div class="invalid-feedback">Please enter a subject.</div>
                        </div>
                        <div class="mb-3">
                            <label for="contactMessage" class="form-label">
            <i class="fas fa-comment-dots me-2"></i>Your Message
          </label>
                            <textarea class="form-control" id="contactMessage" name="contactmessage" rows="6" placeholder="Type your message here..." required></textarea>
                            <div class="invalid-feedback">Please enter your message.</div>
                        </div>
                        <div class="mb-3 text-center">
                            <button type="submit" name="submit" class="btn btn-primary btn-custom">
            <i class="fas fa-paper-plane me-2"></i>Send Message
          </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Bootstrap Form Validation Script -->
            <script>
                (function () {
      'use strict'
      var forms = document.querySelectorAll('.needs-validation')
      Array.prototype.slice.call(forms)
        .forEach(function (form) {
          form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
              event.preventDefault()
              event.stopPropagation()
            }
            form.classList.add('was-validated')
          }, false)
        })
    })();
            </script>

            <!-- Social Connections -->
            <div class="row mt-4">
                <div class="col text-center">
                    <p>We love hearing from fellow space enthusiasts! Connect with us on social media:</p>
                    <a href="https://discord.gg/mkcN8R5UYQ"
                        class="text-light me-3"><i class="fab fa-discord fa-lg"></i></a>
                    <a href="https://x.com/voltvoyage_in"
                        class="text-light me-3"><i class="fab fa-twitter fa-lg"></i></a>
                    <a href="https://www.instagram.com/voltvoyage.in?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw=="
                        class="text-light me-3"><i class="fab fa-instagram fa-lg"></i></a>
                    <a href="#" class="text-light"><i class="fab fa-linkedin fa-lg"></i></a>
                </div>
            </div>
        </div>
    </section>

    <!-- Bootstrap Form Validation Script -->
    <script>
        (function () {
      'use strict'
      var forms = document.querySelectorAll('.needs-validation')
      Array.prototype.slice.call(forms)
        .forEach(function (form) {
          form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
              event.preventDefault()
              event.stopPropagation()
            }
            form.classList.add('was-validated')
          }, false)
        })
    })();
    </script>


    <!-- FOOTER -->
    <footer>
        <div class="container">
            <p>&copy; 2025 VOLTVOYAGE. All rights reserved.</p>
            <p>Inspired by space, guided by tradition, driven by innovation.</p>
        </div>
    </footer>

    <!-- SEARCH MODAL (POPUP) -->
    <div class="modal fade modal-search" id="searchModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <!-- Header is omitted as per request -->
                <div class="modal-body">
                    <input type="text" id="searchInput" class="form-control" placeholder="Type to search..." autofocus>
                    <ul id="suggestions" class="suggestion-list"></ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // NAVBAR FADE LOGIC:
    // - Fades OUT on scroll DOWN
    // - Fades IN on scroll UP
    let lastScrollTop = 0;
    const navbar = document.querySelector('.navbar');
    window.addEventListener('scroll', () => {
      let scrollTop = window.pageYOffset || document.documentElement.scrollTop;
      if (scrollTop > lastScrollTop) {
        navbar.classList.add('fade-out');
      } else {
        navbar.classList.remove('fade-out');
      }
      lastScrollTop = scrollTop;
    });

    // SEARCH MODAL
    const openSearchModalBtn = document.getElementById('openSearchModal');
    const searchModalInstance = new bootstrap.Modal(document.getElementById('searchModal'));
    const searchInput = document.getElementById('searchInput');
    const suggestionsList = document.getElementById('suggestions');

    openSearchModalBtn.addEventListener('click', () => {
      searchModalInstance.show();
      setTimeout(() => { searchInput.focus(); }, 200);
    });

    // Dummy search suggestions array
    const searchSuggestions = [
      'Lunar Expedition',
      'Satellite Innovations',
      'Deep Space Research',
      'ISRO News',
      'VOLTVOYAGE Blog',
      'Rocket Launches'
    ];

    // Function to simulate navigation to a section based on search query
    function navigateToResult(query) {
      if (['lunar expedition', 'satellite innovations', 'deep space research', 'rocket launches']
          .includes(query.toLowerCase())) {
        location.hash = '#missions';
      } else {
        location.hash = '#about';
      }
    }

    // Update suggestions on input
    searchInput.addEventListener('input', function() {
      const query = this.value.trim().toLowerCase();
      suggestionsList.innerHTML = '';
      if (!query) return;
      const filtered = searchSuggestions.filter(item => item.toLowerCase().includes(query));
      filtered.forEach(suggestion => {
        const li = document.createElement('li');
        li.classList.add('suggestion-item');
        li.textContent = suggestion;
        li.addEventListener('click', () => {
          searchInput.value = suggestion;
          suggestionsList.innerHTML = '';
          searchModalInstance.hide();
          setTimeout(() => {
            navigateToResult(suggestion);
          }, 300);
        });
        suggestionsList.appendChild(li);
      });
    });

    // Listen for Enter key press in search input
    searchInput.addEventListener('keypress', function(e) {
      if (e.key === 'Enter') {
        e.preventDefault();
        const query = this.value.trim();
        if (query) {
          searchModalInstance.hide();
          setTimeout(() => { navigateToResult(query); }, 300);
        }
      }
    });
    </script>

    <script>
        if (window.location.pathname.endsWith("main.html")) {
          window.history.replaceState(null, "", "/");
      }
    </script>

// user profile 
    <script>
    const userBtn = document.querySelector('.btn-custom');
    const profileDropdown = document.getElementById('profileCard');

    userBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        profileDropdown.style.display = profileDropdown.style.display === 'block' ? 'none' : 'block';
    });

    document.addEventListener('click', () => {
        profileDropdown.style.display = 'none';
    });
</script>

</body>

</html>
