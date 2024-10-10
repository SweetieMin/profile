<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Cviebrock\EloquentSluggable\Sluggable;

class Category extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use Sluggable;
    protected $fillable = [
        'name',
        'slug',
        'parent',
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

    public function parent_category(){
        //return $this->hasOne(ParentCategory::class,'id','parent');
        return $this->belongsTo(ParentCategory::class,'parent','id');
    }

    public function getAuditInclude(): array
    {
        return [
            'name',
            'slug',
            'parent'
        ];
    }
    public function getAuditExclude(): array
    {
        return [
            'ordering'
        ];
    }
}
