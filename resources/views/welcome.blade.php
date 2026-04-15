<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Climental — Mental Health & Climate Action Platform</title>
    <link rel="icon" href="{{ asset('images/climental-logo.png') }}" type="image/png">

    <!-- Google Fonts: Inter & Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Outfit:wght@500;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --climental-green: #10b981;
            --climental-blue: #0891b2;
            --climental-dark: #0f172a;
            --climental-darker: #020617;
            --climental-slate: #1e293b;
            --climental-light: #f8fafc;
            --climate-gradient: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #020617 100%);
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--climate-gradient);
            color: var(--climental-light);
            overflow-x: hidden;
            min-height: 100vh;
        }

        h1, h2, h3, .font-heading {
            font-family: 'Outfit', sans-serif;
        }

        .navbar {
            padding: 1.5rem 0;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .hero-section {
            min-height: 90vh;
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.9) 0%, rgba(30, 41, 59, 0.8) 50%, rgba(2, 6, 23, 0.9) 100%), url('/gzu-innovation-hub-day.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            display: flex;
            align-items: center;
            color: var(--climental-light);
            text-align: center;
            position: relative;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 20% 50%, rgba(16, 185, 129, 0.1) 0%, transparent 50%),
                        radial-gradient(circle at 80% 80%, rgba(8, 145, 178, 0.1) 0%, transparent 50%);
            pointer-events: none;
        }

        .hero-title {
            font-size: 4rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            text-shadow: 0 4px 20px rgba(16, 185, 129, 0.3);
            background: linear-gradient(135deg, var(--climental-green), var(--climental-blue));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-subtitle {
            font-size: 1.5rem;
            margin-bottom: 2.5rem;
            opacity: 0.9;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
            color: rgba(248, 250, 252, 0.8);
            text-shadow: 0 2px 10px rgba(0,0,0,0.5);
        }

        .btn-climental {
            padding: 0.8rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-green {
            background: linear-gradient(135deg, var(--climental-green), #059669);
            color: white;
            border: 1px solid rgba(16, 185, 129, 0.3);
            box-shadow: 0 4px 20px rgba(16, 185, 129, 0.2);
        }

        .btn-green:hover {
            background: linear-gradient(135deg, #059669, var(--climental-green));
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(16, 185, 129, 0.4);
            color: white;
        }

        .btn-glass {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: var(--climental-light);
        }

        .btn-glass:hover {
            background: rgba(255, 255, 255, 0.1);
            color: var(--climental-light);
            border-color: rgba(255, 255, 255, 0.3);
        }

        .feature-card {
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 2.5rem;
            height: 100%;
            transition: transform 0.3s, box-shadow 0.3s, border-color 0.3s;
            background: rgba(30, 41, 59, 0.5);
            backdrop-filter: blur(20px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 60px rgba(16, 185, 129, 0.2);
            border-color: rgba(16, 185, 129, 0.3);
        }

        .icon-box {
            width: 70px;
            height: 70px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin-bottom: 1.5rem;
        }

        .icon-green { background: linear-gradient(135deg, rgba(16, 185, 129, 0.2), rgba(16, 185, 129, 0.1)); color: var(--climental-green); border: 1px solid rgba(16, 185, 129, 0.3); }
        .icon-blue { background: linear-gradient(135deg, rgba(8, 145, 178, 0.2), rgba(8, 145, 178, 0.1)); color: var(--climental-blue); border: 1px solid rgba(8, 145, 178, 0.3); }
        .icon-orange { background: linear-gradient(135deg, rgba(245, 158, 11, 0.2), rgba(245, 158, 11, 0.1)); color: #f59e0b; border: 1px solid rgba(245, 158, 11, 0.3); }

        .trust-section {
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.8), rgba(30, 41, 59, 0.6));
            padding: 100px 0;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        footer {
            padding: 60px 0;
            background: var(--climental-darker);
            color: rgba(255, 255, 255, 0.6);
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Floating Animation Classes */
        .floating-element {
            position: absolute;
            pointer-events: none;
            opacity: 0.6;
            animation: float 6s ease-in-out infinite;
        }

        .floating-slow {
            animation-duration: 8s;
        }

        .floating-fast {
            animation-duration: 4s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            25% { transform: translateY(-20px) rotate(5deg); }
            50% { transform: translateY(-10px) rotate(-3deg); }
            75% { transform: translateY(-15px) rotate(2deg); }
        }

        .climate-particle {
            position: absolute;
            width: 4px;
            height: 4px;
            background: var(--climental-green);
            border-radius: 50%;
            opacity: 0.3;
            pointer-events: none;
        }

        .climate-particle.blue {
            background: var(--climental-blue);
        }

        .mouse-responsive {
            transition: transform 0.3s ease-out;
        }

        .glow-effect {
            box-shadow: 0 0 20px rgba(16, 185, 129, 0.3);
        }

        .parallax-layer {
            position: absolute;
            width: 100%;
            height: 100%;
            pointer-events: none;
        }

        @media (max-width: 768px) {
            .hero-title { font-size: 2.5rem; }
            .hero-subtitle { font-size: 1.1rem; }
        }
    </style>
</head>
<body>

    <!-- Transparent Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top shadow-sm">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="/">
                <img src="{{ asset('images/climental-logo.png') }}" alt="Climental" height="45" class="me-2">
                {{-- <span class="fw-bold fs-3" style="color: var(--climental-green);">CLIMENTAL</span> --}}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    @if (Route::has('login'))
                        @auth
                            <li class="nav-item">
                                <a href="{{ url('/dashboard') }}" class="btn btn-climental btn-green ms-lg-3">Dashboard</a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a href="{{ route('login') }}" class="nav-link text-dark fw-semibold px-4">Log in</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a href="{{ route('register') }}" class="btn btn-climental btn-green ms-lg-3">Get Started</a>
                                </li>
                            @endif
                        @endauth
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section" id="heroSection">
        <!-- Floating Climate Elements -->
        <div class="parallax-layer">
            <div class="floating-element floating-slow" style="top: 10%; left: 5%; font-size: 2rem; color: var(--climental-green);">
                <i class="bi bi-tree-fill"></i>
            </div>
            <div class="floating-element floating-fast" style="top: 20%; right: 10%; font-size: 1.5rem; color: var(--climental-blue);">
                <i class="bi bi-water"></i>
            </div>
            <div class="floating-element floating-slow" style="top: 60%; left: 8%; font-size: 1.8rem; color: var(--climental-green);">
                <i class="bi bi-flower1"></i>
            </div>
            <div class="floating-element floating-fast" style="top: 70%; right: 15%; font-size: 1.3rem; color: var(--climental-blue);">
                <i class="bi bi-wind"></i>
            </div>
            <div class="floating-element" style="top: 40%; left: 90%; font-size: 1.6rem; color: var(--climental-green);">
                <i class="bi bi-leaf"></i>
            </div>
        </div>

        <!-- Climate Particles Container -->
        <div id="particlesContainer" class="parallax-layer"></div>

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <h1 class="hero-title animate__animated animate__fadeInUp mouse-responsive" id="heroTitle">Climental</h1>
                    <p class="hero-subtitle animate__animated animate__fadeInUp animate__delay-1s mouse-responsive" id="heroSubtitle">
                        Young people taking care of thier mental wellbeing while engaging in eco friendly activities to create a sustainable and healthy campus community.
                    </p>
                    <div class="d-flex justify-content-center gap-3 animate__animated animate__fadeInUp animate__delay-2s mouse-responsive" id="heroButtons">
                        <a href="{{ route('register') }}" class="btn btn-climental btn-green btn-lg glow-effect">Join Climental</a>
                        <a href="#discover" class="btn btn-climental btn-glass btn-lg px-4">Learn More</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="discover" class="py-5 my-5">
        <div class="container">
            <div class="text-center mb-5 pb-3">
                <h2 class="fw-bold fs-1 text-light mouse-responsive">Integrated Support for Climate-Conscious Students</h2>
                <p class="text-light opacity-75 fs-5 mouse-responsive">A unified platform for your mental wellbeing and environmental activism.</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card feature-card mouse-responsive">
                        <div class="icon-box icon-green">
                            <i class="bi bi-heart-pulse-fill"></i>
                        </div>
                        <h4 class="fw-bold text-light">Mental Wellness</h4>
                        <p class="text-light opacity-75">Daily mood tracking, professional resource directories, and peer support groups tailored for your university journey.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card mouse-responsive">
                        <div class="icon-box icon-blue">
                            <i class="bi bi-tree-fill"></i>
                        </div>
                        <h4 class="fw-bold text-light">Climate Engagement</h4>
                        <p class="text-light opacity-75">Participate in local recycling campaigns, join environmental clubs, and track your sustainable living progress.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card mouse-responsive">
                        <div class="icon-box icon-orange">
                            <i class="bi bi-geo-alt-fill"></i>
                        </div>
                        <h4 class="fw-bold text-light">Smart Mapping</h4>
                        <p class="text-light opacity-75">Instantly find nearby mental health clinics, eco-friendly hubs, and inclusive campus resources in real-time.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Trust / Gamification Section -->
    <section class="trust-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <h2 class="fw-bold fs-1 mb-4 text-light">Earn Rewards While Making an Impact</h2>
                    <p class="text-light opacity-75 fs-5 mb-4">
                        Engage with the community, check in daily, and attend local events to earn points, badges, and the title of an <strong>Eco-Champion</strong>. Your actions matter.
                    </p>
                    <ul class="list-unstyled">
                        <li class="mb-3 text-light"><i class="bi bi-check-circle-fill" style="color: var(--climental-green);" me-2"></i> Daily streaks that build healthy habits</li>
                        <li class="mb-3 text-light"><i class="bi bi-check-circle-fill" style="color: var(--climental-green);" me-2"></i> Join local clubs to unlock exclusive badges</li>
                        <li class="mb-3 text-light"><i class="bi bi-check-circle-fill" style="color: var(--climental-green);" me-2"></i> Compete on the global university leaderboard</li>
                    </ul>
                </div>
                <div class="col-lg-6 text-center">
                    <div class="card shadow-lg border-0 p-5 rounded-4" style="background: rgba(30, 41, 59, 0.5); backdrop-filter: blur(20px); border: 1px solid rgba(255, 255, 255, 0.1);">
                        <i class="bi bi-trophy" style="font-size: 5rem; color: var(--climental-green);"></i>
                        <h3 class="mt-4 fw-bold text-light">14,200+</h3>
                        <p class="text-light opacity-75 fw-semibold">Actions taken by global students this month</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container text-center">
            <img src="{{ asset('images/climental-logo.png') }}" alt="Climental" height="50" class="mb-3">
            <h5 class="fw-bold text-white mb-3">CLIMENTAL</h5>
            <p class="mb-4 small">Advancing University Well-being through Collective Action.</p>
            <div class="d-flex justify-content-center gap-3 mb-4">
                <a href="#" class="text-white opacity-75 fs-4"><i class="bi bi-facebook"></i></a>
                <a href="#" class="text-white opacity-75 fs-4"><i class="bi bi-instagram"></i></a>
                <a href="#" class="text-white opacity-75 fs-4"><i class="bi bi-twitter-x"></i></a>
            </div>
            <hr class="opacity-25 my-4">
            <p class="mb-0 small">&copy; 2026 Climental Platform. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Mouse Movement Interaction
        document.addEventListener('mousemove', (e) => {
            const mouseX = e.clientX;
            const mouseY = e.clientY;
            const centerX = window.innerWidth / 2;
            const centerY = window.innerHeight / 2;

            const moveX = (mouseX - centerX) / centerX;
            const moveY = (mouseY - centerY) / centerY;

            // Apply parallax effect to floating elements
            const floatingElements = document.querySelectorAll('.floating-element');
            floatingElements.forEach((element, index) => {
                const speed = (index + 1) * 0.5;
                const x = moveX * speed * 10;
                const y = moveY * speed * 10;
                element.style.transform = `translate(${x}px, ${y}px)`;
            });

            // Apply subtle movement to hero elements
            const heroTitle = document.getElementById('heroTitle');
            const heroSubtitle = document.getElementById('heroSubtitle');
            const heroButtons = document.getElementById('heroButtons');

            if (heroTitle) {
                heroTitle.style.transform = `translate(${moveX * 5}px, ${moveY * 5}px)`;
            }
            if (heroSubtitle) {
                heroSubtitle.style.transform = `translate(${moveX * 3}px, ${moveY * 3}px)`;
            }
            if (heroButtons) {
                heroButtons.style.transform = `translate(${moveX * 2}px, ${moveY * 2}px)`;
            }
        });

        // Generate Climate Particles
        function createParticle() {
            const container = document.getElementById('particlesContainer');
            if (!container) return;

            const particle = document.createElement('div');
            particle.className = 'climate-particle';

            // Randomly choose color
            if (Math.random() > 0.5) {
                particle.classList.add('blue');
            }

            // Random starting position
            particle.style.left = Math.random() * window.innerWidth + 'px';
            particle.style.top = Math.random() * window.innerHeight + 'px';

            // Random size
            const size = Math.random() * 4 + 2;
            particle.style.width = size + 'px';
            particle.style.height = size + 'px';

            container.appendChild(particle);

            // Animate particle
            animateParticle(particle);
        }

        function animateParticle(particle) {
            const duration = Math.random() * 10000 + 5000; // 5-15 seconds
            const startTime = Date.now();
            const startX = parseFloat(particle.style.left);
            const startY = parseFloat(particle.style.top);

            function update() {
                const elapsed = Date.now() - startTime;
                const progress = elapsed / duration;

                if (progress >= 1) {
                    particle.remove();
                    return;
                }

                // Floating movement
                const x = startX + Math.sin(progress * Math.PI * 2) * 50;
                const y = startY - progress * 200; // Float upward

                particle.style.left = x + 'px';
                particle.style.top = y + 'px';
                particle.style.opacity = 0.3 * (1 - progress);

                requestAnimationFrame(update);
            }

            requestAnimationFrame(update);
        }

        // Create particles periodically
        setInterval(createParticle, 500);

        // Initial particles
        for (let i = 0; i < 10; i++) {
            setTimeout(createParticle, i * 100);
        }

        // Enhanced hover effects for feature cards
        document.querySelectorAll('.feature-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-15px) scale(1.02)';
            });

            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });

        // Smooth scroll for navigation
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
</body>
</html>
