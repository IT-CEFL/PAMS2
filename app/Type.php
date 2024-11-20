<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Type extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $table = 'types';
    
    public function application() {
        return $this->hasMany('App\Application');
    }
}
