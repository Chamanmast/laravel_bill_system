<?php

namespace App\Filament\Resources\Suppliers\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Section as ComponentsSection;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class SuppliersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('shop_name')
                    ->label('Shop Name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('phone')
                    ->label('Phone')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('gst_no')
                    ->label('GST No')
                    ->limit(20)
                    ->toggleable(),

                // 💰 BALANCE COLUMN
                TextColumn::make('balance_details')
                    ->label('Balance')
                    ->getStateUsing(function ($record) {

                        $formatted = MONEY.' '.number_format($record->balance);

                        if ($record->balance <= 0) {
                            return '<span class="text-success font-semibold">'.$formatted.'</span>';
                        }

                        return '
                            <span class="px-2 py-1 rounded bg-info text-dark font-semibold inline-block">
                                '.$formatted.'
                            </span>
                        ';
                    })
                    ->html()
                    ->wrap(),

                ToggleColumn::make('status')
                    ->label('Status')
                    ->offColor('success')
                    ->onColor('danger'),

                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Updated')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])

            ->filters([])

            ->recordActions([

                ViewAction::make(),
                EditAction::make(),

                // ✅ FULL PAY (Filament v4 Correct Modal Form)
                Action::make('fullPay')
                    ->label('Full Pay')
                    ->icon('heroicon-o-banknotes')
                    ->color('info')
                    ->visible(fn ($record) => $record->balance > 0)
                    ->modalHeading('Pay Full Amount')
                    ->modalWidth('5xl')

                    // 📌 v4 uses →form([...])
                    ->form([
                        ComponentsSection::make('Payment Details')
                            ->schema([
                                TextInput::make('balance')
                                    ->label('Remaining Balance')
                                    ->default(fn ($record) => number_format($record->balance, 2))
                                    ->readOnly(),

                                Select::make('payment_mode')
                                    ->label('Payment Mode')
                                    ->options(MODE)
                                    ->native(false)
                                    ->required(),

                                TextInput::make('transaction_id')
                                    ->label('Transaction ID (Optional)')
                                    ->placeholder('Enter Transaction ID'),
                            ])
                            ->columns(3),
                    ])

                    ->modalSubmitActionLabel(function ($record) {
                        return 'Pay Full Amount (₹'.number_format($record->balance, 2).')';
                    })

                    // 💾 ACTION HANDLER
                    ->action(function ($data, $record) {

                        // (1) Validate payment mode
                        if (! isset($data['payment_mode'])) {
                            Notification::make()
                                ->title('Payment mode is required')
                                ->danger()
                                ->send();

                            return;
                        }

                        // (2) Ensure supplier has pending balance
                        $balance = $record->balance;

                        if ($balance <= 0) {
                            Notification::make()
                                ->title('No pending balance to pay!')
                                ->warning()
                                ->send();

                            return;
                        }

                        // (3) Create SupplierBilling entry -- FULL PAY
                        $billing = $record->billings()->create([
                            'supplier_id' => $record->id,
                            'bill_amount' => 0,                  // like your controller
                            'paid' => $balance,           // full settlement
                            'payment_mode' => $data['payment_mode'], // user-selected payment mode
                            'transaction_id' => 'FULLPAY-'.time(),   // auto generate
                        ]);

                        // (4) Optional: You DON'T update supplier.balance manually
                        // because your model’s accessor/mutator handles it through billing creation

                        Notification::make()
                            ->title('Supplier fully paid successfully!')
                            ->success()
                            ->send();
                    }),

            ])

            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
