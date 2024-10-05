<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class GeneralSetting extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'site_title',
        'site_email',
        'site_phone',
        'site_meta_keywords',
        'site_meta_description',
        'site_logo',
        'site_favicon',
    ];

    public function getAuditInclude(): array
    {
        return [
            'site_title',
            'site_email',
            'site_phone',
            'site_meta_keywords',
            'site_meta_description',
            'site_logo',
            'site_favicon',
        ];
    }
    public function getAuditExclude(): array
    {
        return [
            // Các thuộc tính không cần audit, nếu có
        ];
    }
}
