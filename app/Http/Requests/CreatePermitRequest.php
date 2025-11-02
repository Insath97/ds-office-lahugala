<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePermitRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'client_id' => 'required|exists:clients,id',
            'gn_division_id' => 'required|exists:g_n_divisions,id',
            'code' => 'required|string|max:255|unique:permits,code',
            'permit_holder_copy' => 'boolean',
            'office_holder_copy' => 'boolean',
            'ledger' => 'boolean',
            'address' => 'required|string',
            'type_of_land' => 'required|in:agricultural,residential,commercial,industrial,forest,barren,pasture,mining,recreational,conservation',
            'extend' => 'required|in:acre,root,perches,hectare',
            'extent_value' => 'nullable|numeric|min:0',
            'surveyed' => 'boolean',
            'surveyed_plan_no' => 'nullable|string|max:255|required_if:surveyed,1',
            'boundary_north' => 'required|string|max:255',
            'boundary_east' => 'required|string|max:255',
            'boundary_south' => 'required|string|max:255',
            'boundary_west' => 'required|string|max:255',
            'nomination' => 'boolean',
            'name_of_nominees' => 'nullable|string|max:255|required_if:nomination,1',
            'relationship' => 'nullable|string|max:255|required_if:nomination,1',
            'nominated_date' => 'nullable|date|required_if:nomination,1',
            'grant_issued' => 'boolean',
            'grant_no' => 'nullable|string|max:255|required_if:grant_issued,1',
            'land_registry_no' => 'nullable|string|max:255|required_if:grant_issued,1',
            'date_of_issued' => 'nullable|date|required_if:grant_issued,1',
            'description' => 'nullable|string',
        ];
    }
}
