<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crop Disease Diagnostic Tool</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">

   
    <style>
        :root {
            --primary-color: #2E7D32;
            --secondary-color: #81C784;
            --accent-color: #F9FBE7;
        }
        
        .hero-section {
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('./images/header.jpg');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 100px 0;
        }
        
        .feature-card {
            border: none;
            border-radius: 15px;
            transition: transform 0.3s ease;
            background: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .feature-card:hover {
            transform: translateY(-5px);
        }
        
        .feature-icon {
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }
        
        .custom-navbar {
            background-color: var(--primary-color);
        }
        
        .custom-navbar .navbar-brand,
        .custom-navbar .nav-link {
            color: white;
        }
        
        .custom-navbar .nav-link:hover {
            color: var(--accent-color);
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background-color: #1B5E20;
            border-color: #1B5E20;
        }
        
        footer {
            background-color: #1B5E20;
            color: white;
        }
    </style> 
</head>
<body>
    <!-- Navigation -->
    <?php 
    include_once './includes/header.php'
    ?>

    <!-- Hero Section -->
    <section class="hero-section text-center">
        <div class="container">
            <h1 class="display-4 mb-4">Identify & Treat Crop Diseases</h1>
            <p class="lead mb-4">Get instant diagnosis and expert recommendations for your crop health concerns</p>
            <div class="d-flex justify-content-center gap-3">
                <button class="btn btn-primary btn-lg Start_diagnosis">Start Diagnosis</button>
                <button class="btn btn-outline-light btn-lg learn_more">Learn More</button>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-5">How It Works</h2>
            <div class="row g-4">
                <!-- Feature 1 -->
                <div class="col-md-4">
                    <div class="feature-card card h-100 p-4">
                        <div class="card-body text-center">
                            <div class="feature-icon">📋</div>
                            <h3 class="card-title">Select Symptoms</h3>
                            <p class="card-text">Choose from our comprehensive list of symptoms or describe them in your own words.</p>
                        </div>
                    </div>
                </div>
                <!-- Feature 2 -->
                <div class="col-md-4">
                    <div class="feature-card card h-100 p-4">
                        <div class="card-body text-center">
                            <div class="feature-icon">🔍</div>
                            <h3 class="card-title">Get Diagnosis</h3>
                            <p class="card-text">Our system analyzes the symptoms and provides potential disease matches.</p>
                        </div>
                    </div>
                </div>
                <!-- Feature 3 -->
                <div class="col-md-4">
                    <div class="feature-card card h-100 p-4">
                        <div class="card-body text-center">
                            <div class="feature-icon">💡</div>
                            <h3 class="card-title">Treatment Guide</h3>
                            <p class="card-text">Receive detailed treatment recommendations and preventive measures.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="py-5">
        <div class="container text-center">
            <h2 class="mb-4">Ready to protect your crops?</h2>
            <p class="lead mb-4">Join thousands of farmers who trust our diagnostic tool</p>
            <button class="btn btn-primary btn-lg login-btn " id="loginBtn">Create Free Account</button>
        </div>
    </section>

    <!-- Footer -->
    <?php include_once "includes/footer.php"; ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <script>
document.querySelector(".Start_diagnosis").addEventListener('click',()=>{
window.location.href="../resources/diagnosis.php";
});

document.querySelector("#loginBtn").addEventListener('click',()=>{
window.location.href="../resources/Login.php";
});
    </script>
   
</body>
</html>