<?php

namespace App\Models;

use App\Traits\MultiTenantModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ExpenseCategory extends Model
{
    use SoftDeletes, MultiTenantModelTrait;

    protected $table = 'expense_categories';

    protected $fillable = [
        'name',
        'created_by_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the expenses that belong to this category.
     */
    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class, 'expense_category_id');
    }

    /**
     * Get the user who created this category.
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }
}