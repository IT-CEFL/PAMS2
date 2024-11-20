<?php

namespace App;

use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Access extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    public function role()
    {
        return $this->belongsTo('App\Role');
    }
    
    public function module()
    {
        return $this->belongsTo('App\Module');
    }

    public function transformAudit(array $data): array
    {
        if (Arr::has($data, 'new_values.roleID')) {
            if($this->getOriginal('roleID')!= NULL){
                $data['old_values']['roleID'] = Role::find($this->getOriginal('roleID'))->RoleName;
            }

            $data['new_values']['roleID'] = Role::find($this->getAttribute('roleID'))->RoleName;
        }

        if (Arr::has($data, 'new_values.moduleID')) {
            if($this->getOriginal('moduleID')!= NULL){
                $data['old_values']['moduleID'] = Role::find($this->getOriginal('moduleID'))->moduleName;
            }

            $data['new_values']['moduleID'] = Role::find($this->getAttribute('moduleID'))->moduleName;
        }

        return $data;
    }
}
