<?php

namespace App\Filament\Pages;

use App\Models\Customer;
use App\Models\Item;
use App\Models\Type;
use BackedEnum;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\DB;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Actions;
use Filament\Actions\Action;
use UnitEnum;

class BillingSystem extends Page implements HasForms
{
    use InteractsWithForms;

    protected  string $view = 'filament.pages.billing-system';

    protected static ?string $navigationLabel = 'Generate Bill';

    protected static string|UnitEnum|null $navigationGroup = 'Sales';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    /** FORM STATE */
    public ?int $customer_id = null;

    public ?int $category_id = null;

    public ?int $type_id = null;

    public ?int $product_id = null;

    public float $quantity = 1;

    public float $discount = 0;

    public float $tax = 0;

    /** CART */
    public array $cart = [];

    protected function getFormSchema(): array
    {
        return [
            Section::make('Customer')
                ->schema([
                    Forms\Components\Select::make('customer_id')
                        ->label('Customer')
                        ->options(Customer::pluck('name', 'id'))
                        ->searchable()
                        ->required()
                        ->reactive(),
                ]),

            Section::make('Billing System')
                ->visible(fn() => filled($this->customer_id))
                ->schema([
                    Forms\Components\Select::make('category_id')
                        ->label('Category')
                        ->options(Type::active()->where('parent_id', NULL)->pluck('name', 'id'))
                        ->reactive()
                        ->searchable()
                        ->afterStateUpdated(fn() => $this->reset(['type_id', 'product_id'])),

                    Select::make('type_id')
                        ->label('Type')
                        ->options(
                            fn() => $this->category_id
                            ? Type::active()->where('parent_id', $this->category_id)->pluck('name', 'id')
                            : []
                        )

                        ->reactive()
                        ->searchable()
                        ->afterStateUpdated(fn() => $this->reset('product_id')),

                    Select::make('product_id')
                        ->label('Product')
                        ->options(
                            fn() => $this->type_id
                            ? Item::where('type_id', $this->type_id)->pluck('name', 'id')
                            : []
                        )
                        ->searchable(),

                    TextInput::make('quantity')
                        ->numeric()
                        ->default(1)
                        ->minValue(0.01),

                    Actions::make([
                        Action::make('add')
                            ->label('Add Product')
                            ->action(fn() => $this->addProduct()),
                    ]),
                ])
                ->columns(2)
                    ->columnSpanFull(),

        ];
    }

    public function removeItem(int $index): void
{
    if (! isset($this->cart[$index])) {
        return;
    }

    unset($this->cart[$index]);

    // Re-index array so Livewire updates correctly
    $this->cart = array_values($this->cart);

    Notification::make()
        ->title('Item removed')
        ->success()
        ->send();
}
    public function addProduct(): void
    {
        $product = Item::find($this->product_id);

        if (!$product) {
            Notification::make()->danger()->title('Select product')->send();

            return;
        }

        if ($this->quantity > $product->stock_qty) {
            Notification::make()->danger()
                ->title('Insufficient stock')
                ->send();

            return;
        }

        $price = ($product->rate_per_gram * $product->net_weight) + $product->making_charge;
        $total = $price * $this->quantity * (1 + ($product->gst_percent / 100));

        $this->cart[] = [
            'id' => $product->id,
            'sku' => $product->sku,
            'name' => $product->name,
            'qty' => $this->quantity,
            'price' => $price,
            'gst' => $product->gst_percent,
            'total' => $total,
        ];
    }

    public function getGrandTotalProperty(): float
    {
        $subtotal = collect($this->cart)->sum('total');
        $discounted = $subtotal * (1 - ($this->discount / 100));

        return round($discounted + ($discounted * $this->tax / 100), 2);
    }

    public function submit(): void
    {
        DB::transaction(function () {
            foreach ($this->cart as $row) {
                $product = Item::lockForUpdate()->find($row['id']);

                if ($row['qty'] > $product->stock_qty) {
                    throw new \Exception('Stock changed');
                }

                $product->decrement('stock_qty', $row['qty']);
            }
        });

        Notification::make()->success()->title('Bill generated')->send();
        $this->reset();
    }
}
