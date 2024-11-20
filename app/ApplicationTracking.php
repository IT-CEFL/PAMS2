<?php

namespace App;

use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Model;

class ApplicationTracking extends Model
{
    
    public function approver() {
        return $this->belongsTo('App\User', 'ApproverID');
    }

    public function application() {
        return $this->belongsTo('App\Application', 'ApplicationID');
    }

    public function transformAudit(array $data): array
    {
        if (Arr::has($data, 'new_values.ApplicationID')) {
            if($this->getOriginal('ApplicationID')!= NULL){
                $data['old_values']['ApplicationID'] = Application::find($this->getOriginal('ApplicationID'))->applicationNumber;
            }

            $data['new_values']['ApplicationID'] = Application::find($this->getAttribute('ApplicationID'))->applicationNumber;
        }

        if (Arr::has($data, 'new_values.ApproverID')) {
            if($this->getOriginal('ApproverID')!= NULL){
                $data['old_values']['ApproverID'] = User::find($this->getOriginal('ApproverID'))->name;
            }

            $data['new_values']['ApproverID'] = User::find($this->getAttribute('ApproverID'))->name;
        }
        
        return $data;
    }
}
