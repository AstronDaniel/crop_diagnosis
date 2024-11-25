$(document).ready(function() {
    // State management
    let currentStep = 1;
    let uploadedFiles = [];
    let formData = {};

    // Initialize Select2 with custom styling
    $('.symptoms-select').select2({
        placeholder: "Select symptoms",
        allowClear: true,
        theme: 'bootstrap',
        minimumSelectionLength: 1,
        maximumSelectionLength: 5,
        templateResult: formatSymptom,
        templateSelection: formatSymptom
    });

    // Custom formatting for symptoms
    function formatSymptom(symptom) {
        if (!symptom.id) return symptom.text;
        return $(`<span><i class="bi bi-check-circle me-2"></i>${symptom.text}</span>`);
    }

    // Step navigation
    setupStepNavigation();

    // Form validation
    setupFormValidation();

    // File upload handling
    setupFileUpload();

    // Dynamic symptom recommendations
    setupSymptomRecommendations();

    // Form submission
    setupFormSubmission();

    // Helper Functions
    function setupStepNavigation() {
        // Show only current step
        $('.step-1, .step-2, .symptom-card').hide();
        $(`.step-${currentStep}`).show();

        // Update progress indicator
        updateProgressIndicator();

        // Next step button handling
        $('.btn-next').click(function() {
            if (validateCurrentStep()) {
                currentStep++;
                updateProgressIndicator();
                $(`.step-${currentStep-1}`).fadeOut(300, function() {
                    $(`.step-${currentStep}`).fadeIn(300);
                });
            }
        });

        // Previous step button handling
        $('.btn-prev').click(function() {
            currentStep--;
            updateProgressIndicator();
            $(`.step-${currentStep+1}`).fadeOut(300, function() {
                $(`.step-${currentStep}`).fadeIn(300);
            });
        });
    }

    function updateProgressIndicator() {
        $('.progress-step').removeClass('active');
        $(`.progress-step:nth-child(${currentStep})`).addClass('active');
        
       
        if (currentStep == 1) {
            $(".btn-prev").fadeOut(1000);
            $(".diagnosis").fadeOut(1000);

        } else if (currentStep == 3) {
            $(".btn-next").fadeOut(1000);
             $(".diagnosis").fadeIn(1000);
        }else {
            $(".btn-prev").fadeIn(1000);
            $(".btn-next").fadeIn(1000);
            $(".diagnosis").fadeOut(1000);
        }
        // Update progress line
        const progress = ((currentStep - 1) / 2) * 100;
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

    function setupFileUpload() {
        const $dropZone = $('.custom-file-upload');
        const $fileInput = $dropZone.find('input[type="file"]');

        // Drag and drop handling
        $dropZone.on('dragover dragenter', function(e) {
            e.preventDefault();
            e.stopPropagation();
            $(this).addClass('border-primary');
        });

        $dropZone.on('dragleave dragend drop', function(e) {
            e.preventDefault();
            e.stopPropagation();
            $(this).removeClass('border-primary');
        });

        $dropZone.on('drop', function(e) {
            const files = e.originalEvent.dataTransfer.files;
            handleFiles(files);
        });

        $fileInput.on('change', function(e) {
            handleFiles(this.files);
        });

        function handleFiles(files) {
            uploadedFiles = Array.from(files);
            updateFilePreview();
        }

        function updateFilePreview() {
            const fileNames = uploadedFiles.map(file => file.name).join(', ');
            $dropZone.find('p').text(
                uploadedFiles.length > 0 ?
                `Selected files: ${fileNames}` :
                'Drag and drop your images here or click to upload'
            );
        }
    }

    function setupSymptomRecommendations() {
        // Dynamic symptom suggestions based on crop type
        $('select[name="crop_type"]').on('change', function() {
            const cropType = $(this).val();
            updateSymptomSuggestions(cropType);
        });
    }

    function updateSymptomSuggestions(cropType) {
        // Crop-specific symptom mapping
        const symptomMap = {
            'rice': ['yellowing', 'spots', 'wilting'],
            'wheat': ['spots', 'stunted', 'lesions'],
            'corn': ['wilting', 'lesions', 'mold'],
            'potato': ['spots', 'wilting', 'mold'],
            'tomato': ['yellowing', 'spots', 'wilting', 'mold']
        };

        // Highlight recommended symptoms
        const recommendedSymptoms = symptomMap[cropType] || [];
        $('.symptoms-select option').each(function() {
            if (recommendedSymptoms.includes($(this).val())) {
                $(this).attr('data-recommended', 'true');
            } else {
                $(this).removeAttr('data-recommended');
            }
        });

        // Refresh Select2 to show recommendations
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
                success: function(response) {
                    const data = JSON.parse(response);
                    if (data.success) {
                        generateAndShowResults({
                            cropType: formData.get('crop_type'),
                            growthStage: formData.get('growth_stage'),
                            symptoms: formData.getAll('symptoms[]'),
                            additionalDetails: formData.get('additional_details')
                        });
                    } else {
                        alert('Error: ' + data.error);
                    }
                },
                error: function() {
                    alert('Error: Could not process diagnosis');
                },
                complete: function() {
                    $submitBtn.prop('disabled', false).text(originalText);
                }
            });
        });
    }

    function generateAndShowResults(data) {
        // Generate diagnosis based on input data
        const diagnosis = analyzeCropCondition(data);

        // Update results section with generated content
        updateResultsSection(diagnosis);

        // Show results
        $('.results-section').fadeIn(500);

        // Scroll to results
        $('html, body').animate({
            scrollTop: $('.results-section').offset().top - 50
        }, 1000);
    }

    function analyzeCropCondition(data) {
        // Simple analysis logic (in real app, this would be more sophisticated)
        const severityScore = calculateSeverityScore(data.symptoms);
        const confidence = calculateConfidence(data);

        return {
            disease: determineLikelyDisease(data),
            severity: severityScore,
            confidence: confidence,
            recommendations: generateRecommendations(data)
        };
    }

    function calculateSeverityScore(symptoms) {
        const severityMap = {
            'yellowing': 2,
            'spots': 3,
            'wilting': 4,
            'stunted': 3,
            'lesions': 4,
            'mold': 5
        };

        return symptoms.reduce((score, symptom) => score + (severityMap[symptom] || 0), 0);
    }

    function calculateConfidence(data) {
        // Basic confidence calculation
        const hasMultipleSymptoms = data.symptoms.length > 1;
        const hasDetails = data.additionalDetails.length > 20;
        const hasImages = data.files.length > 0;

        let confidence = 60; // Base confidence
        if (hasMultipleSymptoms) confidence += 15;
        if (hasDetails) confidence += 10;
        if (hasImages) confidence += 15;

        return Math.min(confidence, 95); // Cap at 95%
    }

    function determineLikelyDisease(data) {
        // Simplified disease determination logic
        const symptomPatterns = {
            'Leaf Blight': ['yellowing', 'spots', 'wilting'],
            'Powdery Mildew': ['spots', 'mold'],
            'Root Rot': ['wilting', 'stunted'],
            'Bacterial Spot': ['spots', 'lesions']
        };

        let bestMatch = {
            disease: 'Unknown',
            matchScore: 0
        };

        Object.entries(symptomPatterns).forEach(([disease, patterns]) => {
            const matchCount = patterns.filter(pattern =>
                data.symptoms.includes(pattern)
            ).length;

            if (matchCount > bestMatch.matchScore) {
                bestMatch = {
                    disease: disease,
                    matchScore: matchCount
                };
            }
        });

        return bestMatch.disease;
    }

    function generateRecommendations(data) {
        // Basic recommendation generation
        const commonRecommendations = [
            "Monitor the affected areas closely",
            "Ensure proper irrigation",
            "Maintain good air circulation"
        ];

        const diseaseSpecificRecs = {
            'Leaf Blight': [
                "Apply copper-based fungicide",
                "Remove infected leaves",
                "Avoid overhead watering"
            ],
            'Powdery Mildew': [
                "Apply sulfur-based fungicide",
                "Increase plant spacing",
                "Reduce humidity around plants"
            ]
        };

        return [
            ...commonRecommendations,
            ...(diseaseSpecificRecs[determineLikelyDisease(data)] || [])
        ];
    }

    function updateResultsSection(diagnosis) {
        const $results = $('.results-section');

        $results.html(`
    <h3 class="mb-4">Diagnosis Results</h3>
    <div class="result-card card p-4">
        <div class="d-flex justify-content-between align-items-start mb-4">
            <div>
                <h4 class="text-primary mb-2">Diagnosed Disease: ${diagnosis.disease}</h4>
                <div class="d-flex gap-3">
                    <span class="badge bg-primary">Confidence: ${diagnosis.confidence}%</span>
                    <span class="badge bg-${diagnosis.severity > 10 ? 'danger' : 'warning'}">
                        Severity: ${diagnosis.severity > 10 ? 'High' : 'Moderate'}
                    </span>
                </div>
            </div>
            <div>
                <button class="btn btn-outline-primary btn-sm me-2" onclick="saveDiagnosis()">
                    <i class="bi bi-download me-1"></i>Save Report
                </button>
                <button class="btn btn-outline-secondary btn-sm" onclick="window.print()">
                    <i class="bi bi-printer me-1"></i>Print
                </button>
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

        <div class="additional-info mt-4">
            <h5 class="mb-3">Additional Information:</h5>
            <p>This diagnosis is based on the reported symptoms and conditions. For best results, 
            consider consulting with a local agricultural expert and regularly monitor the effectiveness 
            of the implemented treatments.</p>
        </div>
    </div>
`);

        $results.removeClass('d-none');
    }
});
