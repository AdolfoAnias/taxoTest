<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class Email extends Model implements Auditable
{
    use HasFactory, AuditableTrait;

    protected $fillable = [
        'subject',
        'recipient',
        'body',
        'state',
        'user_id',
    ];
    
    public function user() {
        return $this->belongsTo('App\Models\User');
    }
    
}
