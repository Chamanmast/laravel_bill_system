<?php
namespace App\Filament\Resources\users;

use App\Filament\Resources\users\Pages\Createusers;
use App\Filament\Resources\users\Pages\Editusers;
use App\Filament\Resources\users\Pages\Listusers;
use App\Filament\Resources\users\Pages\Viewusers;
use App\Filament\Resources\users\Schemas\usersForm;
use App\Filament\Resources\users\Schemas\usersInfolist;
use App\Filament\Resources\users\Tables\usersTable;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class UsersResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
    protected static string|UnitEnum|null $navigationGroup  = 'User Management';

    protected static ?int $navigationSort          = 4;
    protected static ?string $recordTitleAttribute = 'User';

    public static function form(Schema $schema): Schema
    {
        return usersForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return usersInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return usersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }
    public static function canViewAny(): bool
    {
        return auth()->user()?->isAdmin();
    }
    public static function getPages(): array
    {
        return [
            'index'  => Listusers::route('/'),
            'create' => Createusers::route('/create'),
            'view'   => Viewusers::route('/{record}'),
            'edit'   => Editusers::route('/{record}/edit'),
        ];
    }
}
