<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Cviebrock\EloquentSluggable\Sluggable;

class ParentCategory extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use Sluggable;
    protected $fillable = [
        'name',
        'slug',
        'ordering',
    ];
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
    public function getAuditInclude(): array
    {
        return [
            'name',
            'slug'
        ];
    }
    public function getAuditExclude(): array
    {
        return [
            'ordering'
        ];
    }
}
