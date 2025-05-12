<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class EmployeesPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-users'; // أيقونة

    protected static string $view = 'filament.pages.employees-page';

    protected static ?string $navigationLabel = 'الموظفين';

    protected static ?string $title = 'إدارة الموظفين';

    protected static ?int $navigationSort = 10; // ترتيب الظهور
}

