<?php

namespace App\Models;

use App\Traits\MultiTenantModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Income extends Model
{
    use SoftDeletes, MultiTenantModelTrait;

    protected $table = 'incomes';

    protected $fillable = [
        'amount',
        'entry_date',
        'description',
        'created_by_id',
        'income_category_id',
    ];

    protected $casts = [
        'entry_date' => 'date:' . config('panel.date_format'), // Modern casting with custom format
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the income category that owns the income.
     */
    public function incomeCategory(): BelongsTo
    {
        return $this->belongsTo(IncomeCategory::class, 'income_category_id');
    }

    /**
     * Get the user who created the income.
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }
}