<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait ReordersItems
{
    abstract protected function reorderModel(): string;

    public function reorder(Request $request)
    {
        $model = $this->reorderModel();
        $table = (new $model)->getTable();

        $validated = $request->validate([
            'order' => 'required|array',
            'order.*' => 'integer|exists:' . $table . ',id',
        ]);

        foreach ($validated['order'] as $index => $id) {
            $model::where('id', $id)->update(['sort_order' => $index]);
        }

        return response()->json(['success' => true]);
    }
}
