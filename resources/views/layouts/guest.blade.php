<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('images/climental-logo.png') }}" type="image/png">
    <title>{{ config('app.name', 'Climental') }} — Access Portal</title>

    <!-- Google Fonts: Inter & Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Outfit:wght@500;700&display=swap"
        rel="stylesheet">

    <!-- Bootstrap 5 & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --climental-green: #2ecc71;
            --climental-blue: #3498db;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #e8f8f5 0%, #ebf5fb 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .auth-card {
            max-width: 1000px;
            width: 100%;
            border: none;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 15px 45px rgba(0, 0, 0, 0.08);
            background: white;
            display: flex;
            min-height: 550px;
        }

        .auth-form-side {
            padding: 3.5rem;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .auth-image-side {
            flex: 1;
            background: linear-gradient(135deg, var(--climental-green), var(--climental-blue));
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 3rem;
            color: white;
            text-align: center;
        }

        @media (max-width: 768px) {
            .auth-image-side {
                display: none;
            }

            .auth-form-side {
                padding: 2.5rem;
            }

            .auth-card {
                max-width: 450px;
                min-height: auto;
            }
        }

        .form-control {
            border-radius: 12px;
            padding: 0.75rem 1rem;
            border: 1px solid #e9ecef;
            background-color: #fcfdfe;
        }

        .form-control:focus {
            box-shadow: 0 0 0 4px rgba(46, 204, 113, 0.1);
            border-color: var(--climental-green);
        }

        .auth-brand {
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
            font-size: 1.8rem;
            margin-bottom: 2rem;
            text-decoration: none;
            display: block;
        }

        .btn-auth {
            padding: 0.8rem 1.5rem;
            border-radius: 12px;
            font-weight: 600;
            width: 100%;
            margin-top: 1rem;
            transition: all 0.3s;
        }

        .btn-green {
            background: var(--climental-green);
            color: white;
            border: none;
        }

        .btn-green:hover {
            background: #27ae60;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(46, 204, 113, 0.2);
            color: white;
        }

        .auth-heading {
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: #2c3e50;
        }

        .auth-subheading {
            color: #8e9aaf;
            font-size: 0.95rem;
            margin-bottom: 2rem;
        }
    </style>
</head>

<body>

    <div class="auth-card">
        <!-- Form Side -->
        <div class="auth-form-side">
            <a href="/" class="auth-brand text-success mb-4 d-flex align-items-center">
                <img src="{{ asset('images/climental-logo.png') }}" alt="Climental" height="40" class="me-2">
                CLIMENTAL
            </a>

            {{ $slot }}
        </div>

        <!-- Visual Side -->
        <div class="auth-image-side">
            <div class="mb-4">
                <i class="bi bi-shield-heart fs-1 display-1"></i>
            </div>
            <h2 class="fw-bold mb-3 font-heading">Your Journey Hub</h2>
            <p class="opacity-75">Connect with eco-conscious students, track your mental wellbeing, and build a
                sustainable campus community starting today.</p>

            <div class="mt-5 pt-3">
                <div class="d-flex align-items-center mb-3">
                    <i class="bi bi-check-lg me-3"></i> <span>Personalized Daily Tips</span>
                </div>
                <div class="d-flex align-items-center mb-3">
                    <i class="bi bi-check-lg me-3"></i> <span>Youth-Friendly Services</span>
                </div>
                <div class="d-flex align-items-center mb-3">
                    <i class="bi bi-check-lg me-3"></i> <span>Volunteer Opportunities</span>
                </div>
                <div class="d-flex align-items-center">
                    <i class="bi bi-check-lg me-3"></i> <span>Leaderboard Rewards</span>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>