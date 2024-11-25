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
                </div>

                <!-- Step 2: Symptom Selection -->
                <div class="symptom-card mt-4 step-2">
                    <h3 class="mb-4">Select Symptoms</h3>
                    <div class="row g-3">
                        <div class="col-12 visual">
                            <label class="form-label">Visual Symptoms</label>
                            <select class="form-select symptoms-select" name="symptoms[]" multiple="multiple">
                                <option value="yellowing">Yellowing of leaves</option>
                                <option value="spots">Brown/Black spots</option>
                                <option value="wilting">Wilting</option>
                                <option value="stunted">Stunted growth</option>
                                <option value="lesions">Lesions</option>
                                <option value="mold">Visible mold</option>
                            </select>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Additional Details</label>
                            <textarea class="form-control" name="additional_details" rows="3"
                                placeholder="Describe any other symptoms or observations..."></textarea>
                        </div>

                        <div class="col-12">
                           
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary btn-lg px-5 diagnosis" style="background-color: var(--primary-color); border-color: var(--primary-color);">Get Diagnosis</button>
                </div>
                <div class="btns">
                    <div class="text-center mt-4">
                        <button type="button" class="btn-prev btn btn-outline-primary btn-sm px-5">Previous</button>
                    </div>
                    <div class="text-center mt-4">
                        <button type="button" class="btn-next btn btn-outline-success btn-sm px-5">Next</button>
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
                    <button class="btn btn-outline-primary me-2">Save Diagnosis</button>
                    <button class="btn btn-outline-secondary">Print Report</button>
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