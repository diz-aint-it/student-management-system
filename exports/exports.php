<?php
global $pdo;
require '../includes/config.php';
require '../includes/functions.php';
require_auth();

$type = $_GET['type'] ?? 'excel'; // excel, csv, or pdf
$entity = $_GET['entity'] ?? 'student'; // student or section

// Validate inputs
if (!in_array($type, ['excel', 'csv', 'pdf'])) die("Invalid export type");
if (!in_array($entity, ['student', 'section'])) die("Invalid entity");

$repo = new Repository($pdo, $entity);
$data = $repo->all();

// Filename with timestamp
$filename = $entity . '_export_' . date('Ymd_His');

switch ($type) {
    case 'excel':
    case 'csv':
        exportSpreadsheet($data, $filename, $type);
        break;
    case 'pdf':
        exportPDF($data, $filename);
        break;
}

function exportSpreadsheet(array $data, string $filename, string $format) {
    require '../vendor/autoload.php';
    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Headers (replace with your column names)
    $headers = array_keys($data[0] ?? []);
    $sheet->fromArray($headers, null, 'A1');

    // Data
    $sheet->fromArray($data, null, 'A2');

    // Output
    $writer = ($format === 'excel')
        ? new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet)
        : new \PhpOffice\PhpSpreadsheet\Writer\Csv($spreadsheet);

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header("Content-Disposition: attachment; filename=\"$filename.{$format}\"");
    $writer->save('php://output');
    exit;
}

function exportPDF(array $data, string $filename) {
    require '../vendor/autoload.php';
    $pdf = new \TCPDF();
    $pdf->AddPage();
    $pdf->SetFont('helvetica', '', 12);

    // Headers
    $headers = array_keys($data[0] ?? []);
    $html = '<table border="1"><tr>';
    foreach ($headers as $header) {
        $html .= '<th>' . htmlspecialchars($header) . '</th>';
    }
    $html .= '</tr>';

    // Data rows
    foreach ($data as $row) {
        $html .= '<tr>';
        foreach ($row as $cell) {
            $html .= '<td>' . htmlspecialchars($cell) . '</td>';
        }
        $html .= '</tr>';
    }
    $html .= '</table>';

    $pdf->writeHTML($html);
    header('Content-Type: application/pdf');
    header("Content-Disposition: attachment; filename=\"$filename.pdf\"");
    $pdf->Output('php://output', 'D');
    exit;
}