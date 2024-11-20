<?php

namespace App;

use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Application extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $table = 'applications';

    public function user() {
        return $this->belongsTo('App\User', 'userID');
    }
    
    public function type() {
        return $this->belongsTo('App\Type', 'TypeID');
    }
    
    public function currency() {
        return $this->belongsTo('App\Currency', 'CurrencyID');
    }

    public function applicationTracking() {
        return $this->hasMany('App\ApplicationTracking', 'ApplicationID', 'id');
    }

    public function theNextApp() {
        return $this->belongsTo('App\Role', 'nextApp');
    }

    public function thePreviousApp() {
        return $this->belongsTo('App\User', 'previousApp');
    }

    public function transformAudit(array $data): array
    {
        if (Arr::has($data, 'new_values.userID')) {
            if($this->getOriginal('userID')!= NULL){
                $data['old_values']['userID'] = User::find($this->getOriginal('userID'))->name;
            }

            $data['new_values']['userID'] = User::find($this->getAttribute('userID'))->name;
        }

        if (Arr::has($data, 'new_values.TypeID')) {
            if($this->getOriginal('TypeID')!= NULL){
                $data['old_values']['TypeID'] = Type::find($this->getOriginal('TypeID'))->typeName;
            }

            $data['new_values']['TypeID'] = Type::find($this->getAttribute('TypeID'))->typeName;
        }

        if (Arr::has($data, 'new_values.CurrencyID')) {
            if($this->getOriginal('CurrencyID')!= NULL){
                $data['old_values']['CurrencyID'] = Currency::find($this->getOriginal('CurrencyID'))->currencyName;
            }

            $data['new_values']['CurrencyID'] = Currency::find($this->getAttribute('CurrencyID'))->currencyName;
        }

        if (Arr::has($data, 'new_values.previousApp')) {
            if($this->getOriginal('previousApp')!= NULL){
                $data['old_values']['previousApp'] = User::find($this->getOriginal('previousApp'))->name;
            }

            $data['new_values']['previousApp'] = User::find($this->getAttribute('previousApp'))->name;
        }

        if (Arr::has($data, 'new_values.nextApp')) {
            if($this->getOriginal('nextApp')!= NULL){
                $data['old_values']['nextApp'] = Role::find($this->getOriginal('nextApp'))->RoleName;
            }
            if($this->getAttribute('nextApp') != NULL){
                $data['new_values']['nextApp'] = Role::find($this->getAttribute('nextApp'))->RoleName;
            }
        }

        return $data;
    }
}
