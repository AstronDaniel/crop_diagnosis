<style>
     :root {
            --primary-color: #2E7D32;
            --secondary-color: #81C784;
            --accent-color: #F9FBE7;
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
</style>

<nav class="navbar navbar-expand-lg custom-navbar">
        <div class="container">
            <a class="navbar-brand" href="#">Crop Doctor</a> 
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../resources/diagnosis.php">Diagnose</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../resources/dashboard.php">Dashboard</a>
                    </li>
                   
                    <li class="nav-item">
                        <a class="nav-link" href="../resources/Login.php">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>