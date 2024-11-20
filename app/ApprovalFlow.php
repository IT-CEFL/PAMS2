<?php

namespace App;

use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ApprovalFlow extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    // public function dept() {
    //     return $this->belongsTo('App\Department', 'deptID');
    // }
    public function role() {
        return $this->belongsTo('App\Role', 'roleID');
    }
    public function approver() {
        return $this->belongsTo('App\Role', 'Approver');
    }
    public function priceRange() {
        return $this->belongsTo('App\PriceRange', 'range');
    }
    
    public function transformAudit(array $data): array
    {    
        if (Arr::has($data, 'new_values.roleID')) {
            if($this->getOriginal('roleID')!= NULL){
                $data['old_values']['roleID'] = Role::find($this->getOriginal('roleID'))->RoleName;
            }

            $data['new_values']['roleID'] = Role::find($this->getAttribute('roleID'))->RoleName;
        }

        if (Arr::has($data, 'new_values.Approver')) {
            if($this->getOriginal('Approver')!= NULL){
                $data['old_values']['Approver'] = Role::find($this->getOriginal('Approver'))->RoleName;
            }

            $data['new_values']['Approver'] = Role::find($this->getAttribute('Approver'))->RoleName;
        }

        if (Arr::has($data, 'new_values.range')) {
            if($this->getOriginal('range')!= NULL){
                $data['old_values']['range'] = PriceRange::find($this->getOriginal('range'))->amount;
            }
            if ($data['new_values']['range'] != NULL) {
                $data['new_values']['range'] = PriceRange::find($this->getAttribute('range'))->amount;
            }
        }
        return $data;
    }
}
