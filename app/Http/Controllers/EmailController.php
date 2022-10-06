<?php

namespace App\Http\Controllers;

use App\Models\Email;
use App\Models\ImportExcel;
use Illuminate\Http\Request;
use DataTables;
use App\Imports\EmailsImport;

class EmailController extends Controller
{
    public function index(Request $request)
    {
        return view('mail.index');
    }
   
    public function importExcel(Request $request)
    {
        (new EmailsImport)->import(request()->file('photo'));        
        
        $leadsImported = ImportExcel::all();
        
        if (count($leadsImported) > 0){
            $this->store($leadsImported);
        }       
        
        return redirect()->route('moduleMails');
    }

    public function store($leadsImported)
    {
        foreach ($leadsImported as $data){
            $values['subject'] = $data->subject;
            $values['recipient'] = $data->recipient;
            $values['body'] = $data->body;
            $values['state'] = $data->state;                
            $values['user_id'] = $data->user_id;                

            $mail = Email::create($values);

            ImportExcel::where('id',$data->id)->delete();
        }        
    }
    
}
