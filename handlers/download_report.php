<?php
session_start();
require_once '../includes/db.php';
require_once('../lib/tcpdf/tcpdf.php');

if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
    header('HTTP/1.1 403 Forbidden');
    exit('Access denied');
}

$diagnosis_id = intval($_GET['id']);
$user_id = $_SESSION['user_id'];

// Verify ownership
$stmt = $conn->prepare("
    SELECT d.*, dis.name as disease_name, c.name as crop_name, 
           GROUP_CONCAT(s.name) as symptoms
    FROM diagnoses d
    JOIN diseases dis ON d.disease_id = dis.id
    JOIN crops c ON d.crop_id = c.id
    LEFT JOIN diagnosis_symptoms ds ON d.id = ds.diagnosis_id
    LEFT JOIN symptoms s ON ds.symptom_id = s.id
    WHERE d.id = ? AND d.user_id = ?
    GROUP BY d.id
");

$stmt->bind_param("ii", $diagnosis_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();
$diagnosis = $result->fetch_assoc();

if (!$diagnosis) {
    header('HTTP/1.1 404 Not Found');
    exit('Diagnosis not found');
}

// Generate PDF filename
$filename = "diagnosis_report_{$diagnosis_id}.pdf";
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="' . $filename . '"');

// Get recommendations
$stmt = $conn->prepare("
    SELECT recommendation, type
    FROM recommendations 
    WHERE disease_id = ?
    ORDER BY priority, type
");
$stmt->bind_param("i", $diagnosis['disease_id']);
$stmt->execute();
$recommendations = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Create PDF
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8');

// Set document information
$pdf->SetCreator('Crop Doctor');
$pdf->SetAuthor('Crop Doctor System');
$pdf->SetTitle('Diagnosis Report');

// Remove header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// Add a page
$pdf->AddPage();

// Set font
$pdf->SetFont('helvetica', 'B', 20);

// Title
$pdf->Cell(0, 20, 'Crop Disease Diagnosis Report', 0, 1, 'C');

// Basic Information
$pdf->SetFont('helvetica', 'B', 14);
$pdf->Cell(0, 10, 'Basic Information', 0, 1, 'L');
$pdf->SetFont('helvetica', '', 12);
$pdf->Cell(50, 8, 'Date:', 0, 0);
$pdf->Cell(0, 8, date('F j, Y', strtotime($diagnosis['created_at'])), 0, 1);
$pdf->Cell(50, 8, 'Crop Type:', 0, 0);
$pdf->Cell(0, 8, $diagnosis['crop_name'], 0, 1);

// Diagnosis Results
$pdf->Ln(5);
$pdf->SetFont('helvetica', 'B', 14);
$pdf->Cell(0, 10, 'Diagnosis Results', 0, 1, 'L');
$pdf->SetFont('helvetica', '', 12);
$pdf->Cell(50, 8, 'Disease:', 0, 0);
$pdf->Cell(0, 8, $diagnosis['disease_name'], 0, 1);
$pdf->Cell(50, 8, 'Confidence:', 0, 0);
$pdf->Cell(0, 8, $diagnosis['confidence'] . '%', 0, 1);

// Symptoms
$pdf->Ln(5);
$pdf->SetFont('helvetica', 'B', 14);
$pdf->Cell(0, 10, 'Observed Symptoms', 0, 1, 'L');
$pdf->SetFont('helvetica', '', 12);
$symptoms = explode(',', $diagnosis['symptoms']);
foreach ($symptoms as $symptom) {
    $pdf->Cell(10, 8, '•', 0, 0);
    $pdf->Cell(0, 8, trim($symptom), 0, 1);
}

// Recommendations
$pdf->Ln(5);
$pdf->SetFont('helvetica', 'B', 14);
$pdf->Cell(0, 10, 'Recommended Actions', 0, 1, 'L');
$pdf->SetFont('helvetica', '', 12);

foreach ($recommendations as $rec) {
    $pdf->Cell(10, 8, '•', 0, 0);
    $pdf->MultiCell(0, 8, $rec['recommendation'], 0, 'L');
}

// Additional Details
if (!empty($diagnosis['additional_details'])) {
    $pdf->Ln(5);
    $pdf->SetFont('helvetica', 'B', 14);
    $pdf->Cell(0, 10, 'Additional Notes', 0, 1, 'L');
    $pdf->SetFont('helvetica', '', 12);
    $pdf->MultiCell(0, 8, $diagnosis['additional_details'], 0, 'L');
}

// Footer note
$pdf->Ln(10);
$pdf->SetFont('helvetica', 'I', 10);
$pdf->MultiCell(0, 5, 'Note: This report is generated automatically by the Crop Doctor System. Please consult with an agricultural expert for confirmation and detailed treatment plans.', 0, 'L');

// Output PDF
$pdf->Output($filename, 'D');