<?php
require __DIR__ .('/../../fpdf.php');

function generateCVPDF($cv) {
    $pdf = new FPDF();
    $pdf->AddPage();

    // Set font
    $pdf->SetFont('Arial', 'B', 16);

    // Title
    $pdf->Cell(0, 10, $cv['title'], 0, 1, 'C');

    // Personal Information
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, 'Name: ' . $cv['first_name'] . ' ' . $cv['last_name'], 0, 1);
    $pdf->Cell(0, 10, 'Email: ' . $cv['email'], 0, 1);
    $pdf->Cell(0, 10, 'Phone: ' . $cv['phone'], 0, 1);

    // Description
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(0, 10, 'Description', 0, 1);
    $pdf->SetFont('Arial', '', 12);
    $pdf->MultiCell(0, 10, $cv['description']);

    // Education
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(0, 10, 'Education', 0, 1);
    $pdf->SetFont('Arial', '', 12);
    $education = json_decode($cv['education'], true);
    foreach ($education as $edu) {
        $pdf->Cell(0, 10, $edu['institution'] . ' - ' . $edu['degree'], 0, 1);
        $pdf->Cell(0, 10, $edu['year'], 0, 1);
    }

    // Experience
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(0, 10, 'Experience', 0, 1);
    $pdf->SetFont('Arial', '', 12);
    $career = json_decode($cv['career'], true);
    foreach ($career as $job) {
        $pdf->Cell(0, 10, $job['company'] . ' - ' . $job['position'], 0, 1);
        $pdf->Cell(0, 10, $job['start_date'] . ' to ' . $job['end_date'], 0, 1);
        $pdf->MultiCell(0, 10, $job['description']);
    }

    // Skills
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(0, 10, 'Skills', 0, 1);
    $pdf->SetFont('Arial', '', 12);
    $skills = json_decode($cv['skills'], true);
    foreach ($skills as $skill) {
        $pdf->Cell(0, 10, '- ' . $skill, 0, 1);
    }

    return $pdf->Output('S');
}