<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Items extends Model
{
    protected $fillable = [
        'name',
        'code',
        'description', 
        'price',
        'quantity',
        'store_id',
        'category_id',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'quantity' => 'integer',
    ];

    public function store()
    {
        return $this->belongsTo(Stores::class, 'store_id');
    }

    public function category()
    {
        return $this->belongsTo(Categories::class, 'category_id');
    }

    public function stockMovements()
    {
        return $this->hasMany(StockMovements::class, 'item_id');
    }

    /**
     * Check if item is low on stock
     * Uses the quantity field which is already maintained by stock movements
     * 
     * @param int $threshold Optional custom threshold, defaults to 10
     * @return bool
     */
    public function isLowStock($threshold = 10)
    {
        return $this->quantity <= $threshold;
    }

    /**
     * Get low stock threshold for this item
     * Can be customized per item in the future
     * 
     * @return int
     */
    public function getLowStockThreshold()
    {
        // Future enhancement: could add threshold column to items table
        return 10;
    }
}
