<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Seller extends Model
{
    use SoftDeletes;
    protected $fillable = ['user_id', 'contact_person', 'company_name', 'website'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
