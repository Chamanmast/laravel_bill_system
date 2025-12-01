<?php

namespace App\Filament\Resources\Purities;

use App\Filament\Resources\Purities\Pages\CreatePuritie;
use App\Filament\Resources\Purities\Pages\EditPuritie;
use App\Filament\Resources\Purities\Pages\ListPurities;
use App\Filament\Resources\Purities\Pages\ViewPuritie;
use App\Filament\Resources\Purities\Schemas\PuritieForm;
use App\Filament\Resources\Purities\Schemas\PuritieInfolist;
use App\Filament\Resources\Purities\Tables\PuritiesTable;
use App\Models\Puritie;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PuritieResource extends Resource
{
    protected static ?string $model = Puritie::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
    protected static string | UnitEnum | null $navigationGroup = 'Stock Management';
    protected static ?string $recordTitleAttribute = 'Purities';
    protected static ?int $navigationSort = 5;
    //protected static ?string $pluralModelLabel  = 'Management Purities';

    public static function form(Schema $schema): Schema
    {
        return PuritieForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return PuritieInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PuritiesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }
     public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
    public static function getPages(): array
    {
        return [
            'index' => ListPurities::route('/'),
            'create' => CreatePuritie::route('/create'),
            'view' => ViewPuritie::route('/{record}'),
            'edit' => EditPuritie::route('/{record}/edit'),
        ];
    }
}
