<?php

namespace App\Filament\Widgets;

use App\Models\Consultation;
use App\Models\Exam;
use App\Models\Hospitalization;
use App\Models\Patient;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class MedicalStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Patients', Patient::count()),
            Stat::make(
                'Consultations aujourd’hui',
                Consultation::whereDate('consulted_at', today())->count()
            ),
            Stat::make(
                'Examens en attente',
                Exam::where('status', 'requested')->count()
            ),
            Stat::make(
                'Hospitalisations actives',
                Hospitalization::where('status', 'admitted')->count()
            ),
        ];
    }
}
