<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use App\Models\User;
use Carbon\Carbon;

class GeneralHelper
{
  
    public function generatePassWord(){           
        $password = '';
        
        return $password;        
    }   
    
    public function validateUniqueEmail(){           
        $email = true;
        
        return $email;        
    }   

    public function validateNotAdult(){           
        $email = true;
        
        return $email;        
    }   
    
}

