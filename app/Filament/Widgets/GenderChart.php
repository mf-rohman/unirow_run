<?php

namespace App\Filament\Widgets;

use App\Models\Participant;
use Filament\Widgets\ChartWidget;

class GenderChart extends ChartWidget
{
    protected static ?string $heading = 'Distribusi Gender';
    protected static ?int $sort = 2; // Urutan tampilan

    protected function getData(): array
    {
        // Hitung jumlah Laki-laki dan Perempuan
        $pria = Participant::where('jenis_kl', 'Laki-laki')->count();
        $wanita = Participant::where('jenis_kl', 'Perempuan')->count();

        return [
            'datasets' => [
                [
                    'label' => 'Gender Peserta',
                    'data' => [$pria, $wanita],
                    'backgroundColor' => [
                        '#3b82f6', // Biru (Laki-laki)
                        '#ec4899', // Pink (Perempuan)
                    ],
                ],
            ],
            'labels' => ['Laki-laki', 'Perempuan'],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut'; // Bentuk Donat
    }

    protected function getOptions(): array
    {
        return [
            'responsive' => true,
            // KUNCI UTAMA: Matikan rasio aspek default
            'maintainAspectRatio' => false, 
            // Tentukan rasio manual (semakin besar angka, semakin pendek grafiknya). 
            // Coba 1.5 atau 1.6 agar agak melebar dan tidak terlalu tinggi.
            'aspectRatio' => 1.5, 
            'plugins' => [
                'legend' => [
                    // Pindahkan legend ke bawah biar sejajar dengan axis X bar chart
                    'position' => 'bottom', 
                    'labels' => [
                        'padding' => 20,
                        'color' => '#9ca3af', // Warna teks abu-abu (support dark mode)
                    ],
                ],
            ],
            // Opsional: Mengatur ketebalan donat
            'cutout' => '60%', 
        ];
    }
}