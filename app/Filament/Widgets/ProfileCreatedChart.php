<?php

namespace App\Filament\Widgets;

use Carbon\Carbon;
use App\Models\Profile;
use Filament\Widgets\ChartWidget;

class ProfileCreatedChart extends ChartWidget
{
    protected ?string $heading = 'Profile Created Chart';
    protected static ?int $sort = 3;


    protected function getData(): array
    {
        // Get the current year
        $year = now()->year;

        // Initialize array for 12 months with zero counts
        $months = collect(range(1, 12))->mapWithKeys(fn($month) => [
            Carbon::create($year, $month)->format('M') => 0,
        ])->toArray();

        // Query counts of profiles grouped by month for the current year
        $profilesPerMonth = Profile::query()
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', $year)
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();

        // Fill the months array with actual counts
        foreach ($profilesPerMonth as $monthNumber => $count) {
            $monthName = Carbon::create($year, $monthNumber)->format('M');
            $months[$monthName] = $count;
        }

        return [
            'labels' => array_keys($months),
            'datasets' => [
                [
                    'label' => 'Profiles Created',
                    'data' => array_values($months),
                    'backgroundColor' => 'rgba(54, 162, 235, 0.5)',  // blueish
                    'borderColor' => 'rgba(54, 162, 235, 1)',
                    'borderWidth' => 1,
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
