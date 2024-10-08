<?php

namespace App\Models;

use OwenIt\Auditing\Models\Audit as AuditingAudit;
use App\Models\User;

class Audit extends AuditingAudit
{
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
