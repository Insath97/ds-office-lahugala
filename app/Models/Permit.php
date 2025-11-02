<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permit extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'gn_division_id',
        'code',
        'permit_holder_copy',
        'office_holder_copy',
        'ledger',
        'address',
        'type_of_land',
        'extend',
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
        'grant_issued',
        'grant_no',
        'land_registry_no',
        'date_of_issued',
        'description',
    ];

    protected $casts = [
        'permit_holder_copy' => 'boolean',
        'office_holder_copy' => 'boolean',
        'ledger' => 'boolean',
        'surveyed' => 'boolean',
        'nomination' => 'boolean',
        'grant_issued' => 'boolean',
        'nominated_date' => 'date',
        'date_of_issued' => 'date',
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
