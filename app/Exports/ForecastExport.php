<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class ForecastExport implements FromCollection, WithHeadings, WithStyles, WithTitle, ShouldAutoSize
{
    protected $forecastData;
    
    public function __construct($forecastData)
    {
        $this->forecastData = $forecastData;
    }
    
    /**
     * Return collection of data for export
     */
    public function collection()
    {
        $data = collect();
        
        // Add summary information
        $data->push([
            'SALES FORECAST REPORT',
            '',
            '',
            '',
            ''
        ]);
        
        $data->push([
            'Generated at: ' . $this->forecastData['generated_at']->format('Y-m-d H:i:s'),
            '',
            '',
            '',
            ''
        ]);
        
        $data->push([
            'Category: ' . ($this->forecastData['category'] ?: 'All Categories'),
            '',
            '',
            '',
            ''
        ]);
        
        $data->push([
            'Forecast Period: ' . $this->forecastData['weeks'] . ' weeks',
            '',
            '',
            '',
            ''
        ]);
        
        $data->push(['', '', '', '', '']); // Empty row
        
        // Historical Data Section
        $data->push([
            'HISTORICAL DATA',
            '',
            '',
            '',
            ''
        ]);
        
        $data->push([
            'Date',
            'Sales Amount',
            'Type',
            '',
            ''
        ]);
        
        // Add historical data
        $historicalDates = $this->forecastData['historical']['date'];
        $historicalSales = $this->forecastData['historical']['sales'];
        
        for ($i = 0; $i < count($historicalDates); $i++) {
            $data->push([
                $historicalDates[$i],
                number_format($historicalSales[$i], 2),
                'Historical',
                '',
                ''
            ]);
        }
        
        $data->push(['', '', '', '', '']); // Empty row
        
        // Forecast Data Section
        $data->push([
            'FORECAST DATA',
            '',
            '',
            '',
            ''
        ]);
        
        $data->push([
            'Date',
            'Predicted Sales',
            'Type',
            'Week',
            'Day of Week'
        ]);
        
        // Add forecast data
        $forecastDates = $this->forecastData['forecast']['dates'];
        $forecastSales = $this->forecastData['forecast']['sales'];
        
        for ($i = 0; $i < count($forecastDates); $i++) {
            $date = \Carbon\Carbon::parse($forecastDates[$i]);
            $weekNumber = floor($i / 7) + 1;
            
            $data->push([
                $forecastDates[$i],
                number_format($forecastSales[$i], 2),
                'Forecast',
                'Week ' . $weekNumber,
                $date->format('l')
            ]);
        }
        
        $data->push(['', '', '', '', '']); // Empty row
        
        // Summary Statistics
        $data->push([
            'SUMMARY STATISTICS',
            '',
            '',
            '',
            ''
        ]);
        
        $historicalAvg = count($historicalSales) > 0 ? array_sum($historicalSales) / count($historicalSales) : 0;
        $forecastAvg = count($forecastSales) > 0 ? array_sum($forecastSales) / count($forecastSales) : 0;
        $totalHistorical = array_sum($historicalSales);
        $totalForecast = array_sum($forecastSales);
        
        $data->push([
            'Historical Average Daily Sales',
            number_format($historicalAvg, 2),
            '',
            '',
            ''
        ]);
        
        $data->push([
            'Forecast Average Daily Sales',
            number_format($forecastAvg, 2),
            '',
            '',
            ''
        ]);
        
        $data->push([
            'Total Historical Sales',
            number_format($totalHistorical, 2),
            '',
            '',
            ''
        ]);
        
        $data->push([
            'Total Forecast Sales',
            number_format($totalForecast, 2),
            '',
            '',
            ''
        ]);
        
        // Weekly breakdown for forecast
        $data->push(['', '', '', '', '']); // Empty row
        $data->push([
            'WEEKLY FORECAST BREAKDOWN',
            '',
            '',
            '',
            ''
        ]);
        
        $data->push([
            'Week',
            'Total Sales',
            'Average Daily Sales',
            'Days',
            ''
        ]);
        
        $weeks = [];
        for ($i = 0; $i < count($forecastSales); $i++) {
            $weekNum = floor($i / 7);
            if (!isset($weeks[$weekNum])) {
                $weeks[$weekNum] = [];
            }
            $weeks[$weekNum][] = $forecastSales[$i];
        }
        
        foreach ($weeks as $weekIndex => $weekSales) {
            $weekTotal = array_sum($weekSales);
            $weekAvg = $weekTotal / count($weekSales);
            
            $data->push([
                'Week ' . ($weekIndex + 1),
                number_format($weekTotal, 2),
                number_format($weekAvg, 2),
                count($weekSales) . ' days',
                ''
            ]);
        }
        
        return $data;
    }
    
    /**
     * Define headings (not used since we're handling headers manually)
     */
    public function headings(): array
    {
        return [];
    }
    
    /**
     * Apply styles to the worksheet
     */
    public function styles(Worksheet $sheet)
    {
        // Style for main headers
        $sheet->getStyle('A1:E1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 16],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4472C4']
            ]
        ]);
        
        // Find and style section headers
        $rowCount = $sheet->getHighestRow();
        for ($row = 1; $row <= $rowCount; $row++) {
            $cellValue = $sheet->getCell('A' . $row)->getValue();
            
            if (in_array($cellValue, ['HISTORICAL DATA', 'FORECAST DATA', 'SUMMARY STATISTICS', 'WEEKLY FORECAST BREAKDOWN'])) {
                $sheet->getStyle('A' . $row . ':E' . $row)->applyFromArray([
                    'font' => ['bold' => true, 'size' => 12],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'E2EFDA']
                    ]
                ]);
            }
            
            // Style data headers
            if (in_array($cellValue, ['Date', 'Week'])) {
                $sheet->getStyle('A' . $row . ':E' . $row)->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'F2F2F2']
                    ]
                ]);
            }
        }
        
        return [];
    }
    
    /**
     * Set the worksheet title
     */
    public function title(): string
    {
        return 'Sales Forecast Report';
    }
}