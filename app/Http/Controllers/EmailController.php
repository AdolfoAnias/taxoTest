<?php

namespace App\Http\Controllers;

use App\Models\Email;
use App\Models\ImportExcel;
use Illuminate\Http\Request;
use DataTables;
use App\Imports\EmailsImport;

class EmailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('mail.index');
        
//        if ($request->ajax()) {
//            $data = Email::select('*');
//            return Datatables::of($data)
//                    ->addIndexColumn()
//                    ->addColumn('action', function($row){                         
//                        return '<a href="#edit-'.$row->id.'" class="btn btn-xs btn-primary edit"><i class="glyphicon glyphicon-edit"></i> Resp</a>' . ' ' . '<a onclick="deleteModal('.$row->id.')" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
//                    })
//                    ->rawColumns(['action'])
//                    ->make(true);
 //       }       

       // return view('mail.index');      
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Email  $email
     * @return \Illuminate\Http\Response
     */
    public function show(Email $email)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Email  $email
     * @return \Illuminate\Http\Response
     */
    public function edit(Email $email)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Email  $email
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Email $email)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Email  $email
     * @return \Illuminate\Http\Response
     */
    public function destroy(Email $email)
    {
        //
    }
    
    public function importExcel(Request $request)
    {
        dd($request);
        (new EmailsImport)->import(request()->file('photo'));        
        
        $leadsImported = ImportExcel::all();
        
        if (count($leadsImported) > 0){
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
        
        return redirect()->route('moduleMails');
    }
    
}
