<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grant extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'gn_division_id',
        'code',
        'land_registry_no',
        'date_of_issued',
        'original_in_grantee',
        'office_copy',
        'land_registry_copy',
        'address',
        'type_of_land',
        'extend',
        'extent_value',
        'surveyed',
        'surveyed_plan_no',
        'boundary_north',
        'boundary_east',
        'boundary_south',
        'boundary_west',
        'nomination',
        'name_of_nominees',
        'relationship',
        'nominated_date',
        'transferred',
        'transferee_name',
        'transferred_extend_area',
        'related_permit_no',
        'permit_issued_date',
        'description',
    ];

    protected $casts = [
        'original_in_grantee' => 'boolean',
        'office_copy' => 'boolean',
        'land_registry_copy' => 'boolean',
        'surveyed' => 'boolean',
        'nomination' => 'boolean',
        'transferred' => 'boolean',
        'date_of_issued' => 'date',
        'nominated_date' => 'date',
        'permit_issued_date' => 'date',
        'extent_value' => 'decimal:2',
        'transferred_extend_area' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function gnDivision()
    {
        return $this->belongsTo(GNDivision::class, 'gn_division_id');
    }
}
