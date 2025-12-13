{{  dd(app\Models\Type::active()->where('parent_id', NULL)->pluck('name', 'id')) }}
