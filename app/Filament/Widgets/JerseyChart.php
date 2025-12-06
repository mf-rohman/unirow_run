<?php

namespace App\Filament\Widgets;

use App\Models\Participant;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class JerseyChart extends ChartWidget
{
    protected static ?string $heading = 'Rekap Ukuran Jersey';
    protected static ?int $sort = 3;
    protected int | string | array $columnSpan = 1; // Agar grafik memanjang penuh

    protected function getData(): array
    {
        // Query Grouping Ukuran Jersey
        $data = Participant::select('jersey_size', DB::raw('count(*) as total'))
            ->groupBy('jersey_size')
            ->pluck('total', 'jersey_size')
            ->toArray();

        // Urutkan ukuran biar rapi (S, M, L, dst)
        $sizes = ['XS', 'S', 'M', 'L', 'XL', '2XL'];
        $chartData = [];
        
        foreach ($sizes as $size) {
            $chartData[] = $data[$size] ?? 0; // Jika tidak ada yang pesan, isi 0
        }

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Pesanan',
                    'data' => $chartData,
                    'backgroundColor' => '#f59e0b', // Warna Amber/Kuning
                    'borderColor' => '#d97706',
                    'borderWidth' => 1,
                ],
            ],
            'labels' => $sizes,
        ];
    }

    protected function getType(): string
    {
        return 'bar'; // Grafik Batang
    }

    protected function getOptions(): array
    {
        return [
            'responsive' => true,
            // KUNCI UTAMA: Matikan rasio aspek default
            'maintainAspectRatio' => false,
            // PENTING: Nilai ini HARUS SAMA dengan yang di GenderChart.php
            'aspectRatio' => 1.5, 
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'stepSize' => 1, // Agar angka di sumbu Y bulat (tidak ada 0.5 baju)
                        'color' => '#9ca3af', // Support dark mode
                    ],
                    'grid' => [
                        'color' => '#374151', // Support dark mode
                    ]
                ],
                'x' => [
                    'ticks' => [
                        'color' => '#9ca3af', // Support dark mode
                    ],
                    'grid' => [
                        'display' => false, // Hilangkan grid vertikal biar lebih bersih
                    ]
                ],
            ],
            'plugins' => [
                'legend' => [
                    'display' => false, // Bar chart tidak butuh legend jika warnanya sama semua
                ],
            ],
        ];
    }
}