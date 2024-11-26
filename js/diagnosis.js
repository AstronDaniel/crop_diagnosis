// Move functions to global scope
function saveDiagnosis(diagnosisId) {
    window.location.href = `../handlers/download_report.php?id=${diagnosisId}`;
}

function printDiagnosis() {
    const content = $('.results-section').html();
    const printWindow = window.open('', '_blank');
    printWindow.document.write(`
        <html>
            <head>
                <title>Diagnosis Report</title>
                <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
                <style>
                    body { padding: 20px; }
                    @media print {
                        .no-print { display: none; }
                    }
                </style>
            </head>
            <body>
                <div class="container">
                    ${content}
                </div>
                <script>
                    window.onload = function() {
                        window.print();
                        window.onafterprint = function() {
                            window.close();
                        }
                    }
                </script>
            </body>
        </html>
    `);
    printWindow.document.close();
}

$(document).ready(function() {
    // State management
    let currentStep = 1;
    let formData = {};

    // Replace the static initialization with dynamic data loading
    loadFormData();

    function loadFormData() {
        $.ajax({
            url: '../handlers/fetch_form_data.php',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    populateFormSelects(response.data);
                    setupFormComponents();
                } else {
                    console.error('Server error:', response.error);
                    if (response.details) {
                        console.error('Error details:', response.details);
                    }
                    alert('Error loading form data: ' + response.error);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('AJAX error:', textStatus, errorThrown);
                console.log('Response:', jqXHR.responseText);
                alert('Failed to connect to server. Please check your connection and try again.');
            }
        });
    }

    function populateFormSelects(data) {
        // Populate crop select
        const $cropSelect = $('select[name="crop_type"]');
        $cropSelect.empty().append('<option value="">Select a crop</option>');
        data.crops.forEach(crop => {
            $cropSelect.append(`<option value="${crop.id}">${crop.name}</option>`);
        });

        // Populate growth stage select
        const $growthSelect = $('select[name="growth_stage"]');
        $growthSelect.empty().append('<option value="">Select growth stage</option>');
        data.growthStages.forEach(stage => {
            $growthSelect.append(`<option value="${stage.id}">${stage.name}</option>`);
        });

        // Populate symptoms select
        const $symptomsSelect = $('.symptoms-select');
        $symptomsSelect.empty();
        data.symptoms.forEach(symptom => {
            $symptomsSelect.append(`<option value="${symptom.id}">${symptom.name}</option>`);
        });
    }

    function setupFormComponents() {
        // Initialize Select2
        $('.symptoms-select').select2({
            placeholder: "Select symptoms",
            allowClear: true,
            theme: 'bootstrap',
            minimumSelectionLength: 1,
            maximumSelectionLength: 5
        });

        // Setup other components
        setupStepNavigation();
        setupFormValidation();
        setupSymptomRecommendations();
        setupFormSubmission();
    }

    // Remove file upload setup function
    // Remove setupFileUpload() and all related functions

    function calculateConfidence(data) {
        // Simplified confidence calculation
        const hasMultipleSymptoms = data.symptoms.length > 1;
        const hasDetails = data.additionalDetails.length > 20;

        let confidence = 60; // Base confidence
        if (hasMultipleSymptoms) confidence += 20;
        if (hasDetails) confidence += 15;

        return Math.min(confidence, 95); // Cap at 95%
    }

    // Step navigation
    setupStepNavigation();

    // Form validation
    setupFormValidation();

    // Dynamic symptom recommendations
    setupSymptomRecommendations();

    // Form submission
    setupFormSubmission();

    // Helper Functions
    function setupStepNavigation() {
        // Show initial step, hide others
        $('.step-2').hide();
        $('.step-1').show();
        $('.btn-prev').hide();
        $('.diagnosis').hide();

        // Next step button handling
        $('.btn-next').click(function() {
            if (validateCurrentStep()) {
                // Reinitialize Select2 before showing step 2
                $('.symptoms-select').select2({
                    placeholder: "Select symptoms",
                    allowClear: true,
                    theme: 'bootstrap',
                    minimumSelectionLength: 1,
                    maximumSelectionLength: 5,
                    width: '100%'
                });
                
                $('.step-1').fadeOut(300, function() {
                    $('.step-2').fadeIn(300);
                    $('.symptom-card').fadeIn(300);
                    $('.btn-prev').fadeIn(300);
                    $('.diagnosis').fadeIn(300);
                    updateProgressIndicator(2);
                });
            }
        });

        // Previous step button handling
        $('.btn-prev').click(function() {
            $('.step-2').fadeOut(300, function() {
                $('.step-1').fadeIn(300);
                $('.btn-prev').hide();
                $('.diagnosis').hide();
                updateProgressIndicator(1);
            });
        });
    }

    function updateProgressIndicator(step) {
        $('.progress-step').removeClass('active');
        $(`.progress-step:nth-child(${step})`).addClass('active');
        
        // Update progress line
        const progress = ((step - 1) / 2) * 100;
        $('.progress-line').css('width', `${progress}%`);
    }

    function setupFormValidation() {
        // Real-time validation
        $('select, input, textarea').on('change blur', function() {
            validateField($(this));
        });

        $('.symptoms-select').on('change', function() {
            if ($(this).val()?.length < 1) {
                $(this).next('.select2-container').addClass('is-invalid');
            } else {
                $(this).next('.select2-container').removeClass('is-invalid');
            }
        });
    }

    function validateField($field) {
        const value = $field.val();
        const isRequired = $field.prop('required');

        if (isRequired && !value) {
            $field.addClass('is-invalid');
            return false;
        }

        $field.removeClass('is-invalid');
        return true;
    }

    function validateCurrentStep() {
        const $currentFields = $(`.step-${currentStep}`).find('[required]');
        let valid = true;

        $currentFields.each(function() {
            if (!validateField($(this))) {
                valid = false;
            }
        });

        return valid;
    }

    function setupSymptomRecommendations() {
        // Dynamic symptom suggestions based on crop type
        $('select[name="crop_type"]').on('change', function() {
            const cropType = $(this).val();
            updateSymptomSuggestions(cropType);
        });
    }

    // Modify updateSymptomSuggestions to work with database IDs
    function updateSymptomSuggestions(cropId) {
        $.ajax({
            url: '../handlers/get_crop_symptoms.php',
            method: 'GET',
            data: { crop_id: cropId },
            success: function(response) {
                if (response.success) {
                    highlightRecommendedSymptoms(response.data.symptoms);
                }
            }
        });
    }

    function highlightRecommendedSymptoms(recommendedSymptoms) {
        $('.symptoms-select option').each(function() {
            $(this).attr('data-recommended', 
                recommendedSymptoms.includes(parseInt($(this).val())) ? 'true' : 'false'
            );
        });

        // Refresh Select2
        $('.symptoms-select').select2('destroy').select2({
            placeholder: "Select symptoms",
            allowClear: true,
            templateResult: formatSymptomWithRecommendation
        });
    }

    function formatSymptomWithRecommendation(symptom) {
        if (!symptom.id) return symptom.text;
        const $option = $(symptom.element);
        const isRecommended = $option.attr('data-recommended') === 'true';

        return $(`
    <span class="d-flex align-items-center">
        ${isRecommended ? '<i class="bi bi-star-fill text-warning me-2"></i>' : ''}
        ${symptom.text}
        ${isRecommended ? '<small class="ms-2 text-muted">(Recommended)</small>' : ''}
    </span>
`);
    }

    function setupFormSubmission() {
        $('#diagnosticForm').on('submit', function(e) {
            e.preventDefault();

            if (!validateCurrentStep()) {
                return;
            }

            const $submitBtn = $(this).find('button[type="submit"]');
            const originalText = $submitBtn.text();
            $submitBtn.prop('disabled', true)
                .html('<span class="spinner-border spinner-border-sm me-2"></span>Processing...');

            // Collect form data
            const formData = new FormData(this);

            // Send AJAX request
            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        generateAndShowResults(response);
                    } else {
                        console.error('Server error:', response.error);
                        if (response.debug) {
                            console.error('Debug info:', response.debug);
                        }
                        alert('Error: ' + response.error);
                    }
                },
                error: function(jqXHR) {
                    console.error('AJAX error:', jqXHR.responseText);
                    alert('Error: Could not process diagnosis. Check console for details.');
                },
                complete: function() {
                    $submitBtn.prop('disabled', false).text(originalText);
                }
            });
        });
    }

    function generateAndShowResults(data) {
        console.log('Response data:', data); // Debug log
        
        const diagnosisData = {
            diagnosis_id: data.diagnosis_id, // Add this line
            disease: data.disease || { 
                name: 'Unknown Condition',
                confidence: 0,
                matched_symptoms: []
            },
            severity: data.severity || 'Moderate',
            confidence: data.confidence || 0,
            recommendations: data.recommendations || [],
            matched_symptoms: data.matched_symptoms || []
        };

        // Log the processed data
        console.log('Processed diagnosis data:', diagnosisData);

        updateResultsSection(diagnosisData);
        $('.results-section').fadeIn(500);
        
        $('html, body').animate({
            scrollTop: $('.results-section').offset().top - 50
        }, 1000);
    }

    function analyzeCropCondition(data) {
        // Ensure data.symptoms exists before calculating
        const severityScore = Array.isArray(data.symptoms) ? calculateSeverityScore(data.symptoms) : 0;
        const confidence = data.confidence || calculateConfidence(data);

        return {
            disease: data.disease || determineLikelyDisease(data),
            severity: severityScore,
            confidence: confidence,
            recommendations: generateRecommendations(data)
        };
    }

    function calculateSeverityScore(symptoms) {
        if (!Array.isArray(symptoms)) {
            return 0;
        }

        const severityMap = {
            'yellowing': 2,
            'spots': 3,
            'wilting': 4,
            'stunted': 3,
            'lesions': 4,
            'mold': 5
        };

        return symptoms.reduce((score, symptom) => {
            // Handle both string symptoms and symptom objects
            const symptomName = typeof symptom === 'object' ? symptom.name : symptom;
            return score + (severityMap[symptomName.toLowerCase()] || 0);
        }, 0);
    }

    function determineLikelyDisease(data) {
        if (!Array.isArray(data.symptoms) || data.symptoms.length === 0) {
            return { disease: 'Unknown', confidence: 0 };
        }

        const symptomPatterns = {
            'Bacterial Spot': ['brown spots', 'rotting fruits', 'white powdery growth'],
            'Black Rot': ['brown spots', 'visible mold', 'white powdery growth'],
            'Downy Mildew': ['wilting', 'lesions', 'rotting fruits'],
            'Root Rot': ['wilting', 'stunted growth', 'discolored roots', 'water-soaked lesions'],
            'Leaf Blight': ['yellowing of leaves', 'brown spots', 'lesions'],
            'Powdery Mildew': ['white powdery growth', 'yellowing of leaves', 'wilting']
        };

        let matchScores = [];
        const reportedSymptoms = data.symptoms.map(s => 
            typeof s === 'object' ? s.name.toLowerCase() : s.toLowerCase()
        );

        Object.entries(symptomPatterns).forEach(([disease, patterns]) => {
            const matchingSymptoms = patterns.filter(pattern => 
                reportedSymptoms.some(symptom => symptom.includes(pattern))
            );
            
            const matchPercentage = (matchingSymptoms.length / patterns.length) * 100;
            
            if (matchPercentage > 0) {
                matchScores.push({
                    disease: disease,
                    confidence: Math.round(matchPercentage),
                    matchedSymptoms: matchingSymptoms
                });
            }
        });

        // Sort by confidence descending
        matchScores.sort((a, b) => b.confidence - a.confidence);

        if (matchScores.length === 0) {
            return [{
                disease: 'Unknown Condition',
                confidence: 0,
                matchedSymptoms: []
            }];
        }

        // Return all diseases with the highest confidence if there are ties
        const highestConfidence = matchScores[0].confidence;
        return matchScores.filter(score => score.confidence === highestConfidence);
    }

    function generateRecommendations(data) {
        return data.recommendations || [];
    }

    function updateResultsSection(diagnosis) {
        const $results = $('.results-section');
        const disease = diagnosis.disease;
        
        // Log the diagnosis data for debugging
        console.log('Diagnosis data:', diagnosis);

        let resultsHTML = `
            <h3 class="mb-4">Diagnosis Results</h3>
            <div class="result-card card p-4">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h4 class="text-primary mb-2">${disease.name}</h4>
                        <div class="d-flex gap-3">
                            <span class="badge bg-primary">Confidence: ${disease.confidence}%</span>
                            <span class="badge bg-${diagnosis.severity === 'High' ? 'danger' : 'warning'}">
                                Severity: ${diagnosis.severity}
                            </span>
                        </div>
                        ${disease.matched_symptoms.length > 0 ? `
                            <div class="mt-2">
                                <small class="text-muted">Matched Symptoms: ${disease.matched_symptoms.join(', ')}</small>
                            </div>
                        ` : ''}
                    </div>
                </div>

                <div class="recommendations mt-4">
                    <h5 class="mb-3">Recommended Actions:</h5>
                    <ul class="list-group">
                        ${diagnosis.recommendations.map(rec => `
                            <li class="list-group-item">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>${rec}
                            </li>
                        `).join('')}
                    </ul>
                </div>
                <div class="mt-4">
                    <button type="button" class="btn btn-outline-primary me-2" onclick="saveDiagnosis(${diagnosis.diagnosis_id})">
                        <i class="bi bi-download me-1"></i>Save Report
                    </button>
                    <button type="button" class="btn btn-outline-secondary" onclick="printDiagnosis()">
                        <i class="bi bi-printer me-1"></i>Print Report
                    </button>
                </div>
            </div>
        `;

        $results.html(resultsHTML);
        $results.removeClass('d-none');
    }
});
