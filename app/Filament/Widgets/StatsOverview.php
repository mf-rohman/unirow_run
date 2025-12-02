<?php

namespace App\Filament\Widgets;

use App\Models\Participant;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    // Agar widget ini update otomatis setiap 5 detik (Realtime)
    protected static ?string $pollingInterval = '5s';

    protected function getStats(): array
    {
        return [
            // 1. Total Pendaftar
            Stat::make('Total Pendaftar', Participant::count())
                ->description('Semua data masuk')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('primary')
                ->chart([7, 2, 10, 3, 15, 4, 17]), // Hiasan grafik kecil

            // 2. Sudah Verifikasi (Uang Masuk)
            Stat::make('Peserta Terverifikasi', Participant::where('is_verified', true)->count())
                ->description('Pembayaran Lunas')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('success'), // Hijau

            // 3. Belum Bayar (Potensi)
            Stat::make('Belum Verifikasi', Participant::where('is_verified', false)->count())
                ->description('Menunggu Konfirmasi')
                ->descriptionIcon('heroicon-m-clock')
                ->color('danger'), // Merah
        ];
    }
}