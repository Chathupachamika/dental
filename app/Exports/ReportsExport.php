<?php

namespace App\Exports;

use App\Models\Report;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ReportsExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{
    protected $startDate;
    protected $endDate;
    protected $reportType;

    public function __construct($startDate, $endDate, $reportType)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->reportType = $reportType;
    }

    public function collection()
    {
        try {
            $data = Report::getReportData($this->startDate, $this->endDate, $this->reportType);
            $rows = [];

            // Add report metadata
            $rows[] = ['Report Type', ucfirst($this->reportType) . ' Report', '', ''];
            $rows[] = ['Date Range', $this->startDate . ' to ' . $this->endDate, '', ''];
            $rows[] = ['', '', '', '']; // Empty row for spacing

            // Format the existing data sections
            foreach ($data as $key => $value) {
                if (is_array($value)) {
                    $rows[] = [strtoupper(str_replace('_', ' ', $key)), '', '', ''];
                    foreach ($value as $subKey => $subValue) {
                        $rows[] = ['', $subKey, $subValue, ''];
                    }
                    $rows[] = ['', '', '', '']; // Empty row for spacing
                } else {
                    $rows[] = [strtoupper(str_replace('_', ' ', $key)), $value, '', ''];
                }
            }

            return collect($rows);
        } catch (\Exception $e) {
            \Log::error('Excel Export Error: ' . $e->getMessage());
            throw $e;
        }
    }

    public function headings(): array
    {
        return ['Category', 'Detail', 'Value', 'Notes'];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 14]], // Report type
            2 => ['font' => ['bold' => true]], // Date range
            'A' => ['font' => ['bold' => true]], // First column
        ];
    }
}
