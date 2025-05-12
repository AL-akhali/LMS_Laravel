<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class LeaveTypesPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document';

    protected static string $view = 'filament.pages.leave-types-page';

    protected static ?string $navigationLabel = 'اداره الاجازات';

    protected static ?string $slug = 'leave-types'; // URL: /admin/leave-types

    protected static ?int $navigationSort = 10;
}
