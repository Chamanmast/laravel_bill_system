<x-filament-panels::page>

    {{-- The primary form container for inputs --}}
    <form wire:submit="submit">
        {{ $this->form }}

        {{-- Injecting the Add Product button within the form to look integrated --}}
        {{-- The actual form definition needs to be updated in the PHP class to handle the layout,
             but we assume {{ $this->form }} renders all input fields including the 'Add Product' button/action. --}}
    </form>

    <x-filament-actions::modals />

    @if (count($cart))

        {{-- Section 1: Bill Items Table --}}
        <x-filament::section heading="Bill Items" class="mt-6">

            <div
                class="relative overflow-x-auto rounded-2xl border border-gray-300 dark:border-gray-600 bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 shadow-lg">

                <table class="min-w-full text-sm">
                    <thead
                        class="bg-gradient-to-r from-primary-500 to-primary-600 text-white uppercase text-xs tracking-wider rounded-t-2xl">
                        <tr>
                            <th class="px-6 py-4 text-left font-bold w-40">
                                <x-filament::icon icon="heroicon-o-hashtag" class="inline w-4 h-4 mr-2" />
                                SKU
                            </th>

                            <th class="px-6 py-4 text-left font-bold">
                                <x-filament::icon icon="heroicon-o-cube" class="inline w-4 h-4 mr-2" />
                                Product
                            </th>

                            <th class="px-6 py-4 text-center font-bold tabular-nums w-20">
                                <x-filament::icon icon="heroicon-o-calculator" class="inline w-4 h-4 mr-2" />
                                Qty
                            </th>

                            <th class="px-6 py-4 text-right font-bold tabular-nums w-32">
                                <x-filament::icon icon="heroicon-o-currency-dollar" class="inline w-4 h-4 mr-2" />
                                Price
                            </th>

                            <th class="px-6 py-4 text-right font-bold tabular-nums w-32">
                                <x-filament::icon icon="heroicon-o-receipt-percent" class="inline w-4 h-4 mr-2" />
                                Total
                            </th>

                            <th class="px-4 py-4 text-center font-bold w-12">
                                <span class="sr-only">Actions</span>
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                        @forelse ($cart as $index => $item)
                            <tr
                                class="transition-all duration-200 hover:bg-primary-50 dark:hover:bg-primary-900/20 focus-within:bg-primary-50 dark:focus-within:bg-primary-900/20 {{ $loop->even ? 'bg-gray-25 dark:bg-gray-850' : 'bg-white dark:bg-gray-800' }} rounded-lg mx-2 my-1 shadow-sm">

                                <td class="px-6 py-3 font-mono text-gray-900 dark:text-gray-100 font-semibold">
                                    {{ $item['sku'] }}
                                </td>

                                <td class="px-6 py-3 text-gray-800 dark:text-gray-200 font-medium">
                                    {{ $item['name'] }}
                                </td>
                                <td class="px-6 py-3 text-gray-800 dark:text-gray-200 font-medium">
                                    {{ $item['name'] }}
                                </td>

                                <td class="px-6 py-3 text-center tabular-nums font-semibold text-primary-600 dark:text-primary-400">
                                    {{ $item['qty'] }}
                                </td>

                                <td class="px-6 py-3 text-right tabular-nums text-gray-700 dark:text-gray-300">
                                    {{ defined('MONEY') ? MONEY : '₹' }}{{ number_format($item['price'], 2) }}
                                </td>

                                <td
                                    class="px-6 py-3 text-right font-bold tabular-nums text-success-600 dark:text-success-400 bg-success-50 dark:bg-success-900/20 rounded-r-lg">
                                    {{ defined('MONEY') ? MONEY : '₹' }}{{ number_format($item['total'], 2) }}
                                </td>

                                <td class="px-4 py-3 text-center">
                                    <x-filament::icon-button icon="heroicon-o-trash" color="danger" size="sm"
                                        wire:click="removeItem({{ $index }})" label="Remove item"
                                        class="hover:scale-110 transition-transform duration-150" />
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6"
                                    class="px-6 py-12 text-center text-sm text-gray-500 dark:text-gray-400">
                                    <x-filament::icon icon="heroicon-o-shopping-bag" class="mx-auto w-12 h-12 text-gray-300 dark:text-gray-600 mb-4" />
                                    <p class="font-medium">No items added to the bill yet.</p>
                                    <p class="text-xs mt-1">Select a product and quantity to get started.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </x-filament::section>


        {{-- Section 2: Totals and Actions --}}
        <x-filament::section class="mt-6">

            <div class="grid grid-cols-1 md:grid-cols-5 gap-6">

                {{-- Input 1: Discount --}}
                <div class="md:col-span-1 flex flex-col gap-2">
                    <label class="text-sm font-medium leading-6 text-gray-950 dark:text-white">Discount (%)</label>
                    <x-filament::input.wrapper>
                        <x-filament::input wire:model.live="discount" type="number" step="0.01" />
                    </x-filament::input.wrapper>
                </div>

                {{-- Input 2: GST --}}
                <div class="md:col-span-1 flex flex-col gap-2">
                    <label class="text-sm font-medium leading-6 text-gray-950 dark:text-white">GST (%)</label>
                    <x-filament::input.wrapper>
                        <x-filament::input wire:model.live="tax" type="number" step="0.01" />
                    </x-filament::input.wrapper>
                </div>

                {{-- Empty Spacer to push Total to the right --}}
                <div class="hidden md:block md:col-span-1"></div>

                {{-- Grand Total Display (Larger and more prominent) --}}
                <div
                    class="md:col-span-2 flex flex-col p-4 bg-primary-50 dark:bg-gray-900 rounded-lg border border-primary-200 dark:border-primary-700">
                    <span class="text-base font-medium text-primary-700 dark:text-primary-300">
                        Total Payable
                    </span>
                    <span class="text-3xl font-extrabold text-primary-600 dark:text-primary-400">
                        {{ defined('MONEY') ? MONEY : '$' }}{{ number_format($this->grandTotal, 2) }}
                    </span>
                </div>

            </div>

            <div class="mt-6 text-right">
                <x-filament::button wire:click="submit" color="success" size="xl" class="w-full sm:w-auto">
                    {{-- Made the button larger and full width on mobile --}}
                    Finalize & Generate Bill
                </x-filament::button>
            </div>

        </x-filament::section>
    @endif
</x-filament-panels::page>
