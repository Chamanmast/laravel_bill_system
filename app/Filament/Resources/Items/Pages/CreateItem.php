<?php

namespace App\Filament\Resources\Items\Pages;

use App\Filament\Resources\Items\ItemResource;
use Filament\Resources\Pages\CreateRecord;

class CreateItem extends CreateRecord
{
    protected static string $resource = ItemResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {

        // Save subtype as type_id
        if (! empty($data['subtype_id'])) {
            $data['type_id'] = $data['subtype_id'];
        }
        unset($data['subtype_id']);
        // Price calculation
        if (empty($data['price']) || $data['price'] == 0) {
            $data['price'] =
                ($data['rate_per_gram'] * $data['net_weight'] + $data['making_charge'])
                * (1 + $data['gst_percent'] / 100)
                * $data['stock_qty'];
        }

        return $data;
    }
}
