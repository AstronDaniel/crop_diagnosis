<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: Login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diagnose Crop Disease - Crop Doctor</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../css/diagnosis.css">
</head>

<body>
    <?php include_once "../includes/header.php"; ?>

    <!-- Main Content -->
    <div class="container py-5">
        <h1 class="text-center mb-5">Crop Disease Diagnosis</h1>

        <!-- Progress Indicator -->
        <div class="progress-indicator mb-5">
            <div class="progress-line"></div>
            <div class="progress-step active">1</div>
            <div class="progress-step">2</div>
            <div class="progress-step">3</div>
        </div>

        <!-- Diagnostic Form -->
        <div class="diagnostic-container">
            <form id="diagnosticForm" action="../handlers/process_diagnosis.php" method="POST">
                <!-- Step 1: Basic Information -->
                <div class="step-1">
                    <h3 class="mb-4">Basic Information</h3>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Crop Type</label>
                            <select class="form-select" name="crop_type" required>
                                <option value="">Select crop type</option>
                                <option value="rice">Rice</option>
                                <option value="wheat">Wheat</option>
                                <option value="corn">Corn</option>
                                <option value="potato">Potato</option>
                                <option value="tomato">Tomato</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Growth Stage</label>
                            <select class="form-select" name="growth_stage" required>
                                <option value="">Select growth stage</option>
                                <option value="seedling">Seedling</option>
                                <option value="vegetative">Vegetative</option>
                                <option value="flowering">Flowering</option>
                                <option value="fruiting">Fruiting</option>
                            </select>
                        </div>
                    </div>
                    <div class="btns mt-4">
                        <button type="button" class="btn-next btn btn-success">Next</button>
                    </div>
                </div>

                <!-- Step 2: Symptoms -->
                <div class="step-2" style="display: none;">
                    <h3 class="mb-4">Symptoms & Details</h3>
                    <div class="symptom-card">
                        <div class="mb-4">
                            <label class="form-label">Select Symptoms (1-5)</label>
                            <select class="symptoms-select form-select" name="symptoms[]" multiple="multiple" required>
                                <!-- Options will be populated dynamically -->
                            </select>
                            <div class="invalid-feedback">Please select at least one symptom</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Additional Details</label>
                            <textarea name="additional_details" class="form-control" rows="4" 
                                    placeholder="Describe any other observations or details about the condition..."></textarea>
                        </div>
                        <div class="btns mt-4">
                            <button type="button" class="btn-prev btn btn-secondary">Previous</button>
                            <button type="submit" class="btn btn-primary diagnosis">Get Diagnosis</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Results Section (initially hidden, shown after form submission) -->
        <div class="results-section mt-5 d-none">
            <h3 class="mb-4">Diagnosis Results</h3>
            <div class="result-card card p-4">
                <h4 class="text-primary mb-3">Possible Disease: Leaf Blight</h4>
                <p class="mb-3">Confidence Level: <strong>85%</strong></p>
                <p>Based on the symptoms you've described, your crop may be affected by Leaf Blight. This is a common fungal disease that affects various crops.</p>

                <h5 class="mt-4">Recommended Treatment:</h5>
                <ul>
                    <li>Apply fungicide specifically designed for leaf blight</li>
                    <li>Improve air circulation around plants</li>
                    <li>Avoid overhead watering</li>
                    <li>Remove and destroy infected plant material</li>
                </ul>

                <div class="mt-4">
                    <button type="button" class="btn btn-outline-primary me-2" onclick="saveDiagnosis(diagnosisId)">
                        <i class="bi bi-download me-1"></i>Save Report
                    </button>
                    <button type="button" class="btn btn-outline-secondary" onclick="printDiagnosis()">
                        <i class="bi bi-printer me-1"></i>Print Report
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include_once "../includes/footer.php"; ?>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script src="../js/diagnosis.js"></script>
</body>

</html>