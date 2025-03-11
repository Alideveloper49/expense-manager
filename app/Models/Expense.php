<?php

namespace App\Models;

use App\Traits\MultiTenantModelTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Expense extends Model
{
    use SoftDeletes, MultiTenantModelTrait;

    protected $table = 'expenses';

    protected $fillable = [
        'amount',
        'entry_date',
        'description',
        'created_by_id',
        'expense_category_id',
    ];

    protected $casts = [
        'entry_date' => 'date:' . config('panel.date_format'), // Modern casting with custom format
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the expense category that owns the expense.
     */
    public function expenseCategory(): BelongsTo
    {
        return $this->belongsTo(ExpenseCategory::class);
    }

    /**
     * Get the user who created the expense.
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }
}