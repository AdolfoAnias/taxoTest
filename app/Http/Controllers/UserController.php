<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use DataTables;
use Illuminate\Support\Facades\Mail;
use App\Mail\MySendMail;
use Session;
use Redirect;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::select('*');
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){                         
                        return '<a href="#edit-'.$row->id.'" class="btn btn-xs btn-primary edit"><i class="glyphicon glyphicon-edit"></i> Edit</a>' . ' ' . '<a href="#delete-'.$row->id.'" onclick="deleteModal('.$row->id.')" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }       

        return view('users.index');
    }

    public function mail()
    {
        $authUser = auth()->user();
        
        $user = [
            'name' => $authUser->name,
            'email' => $authUser->email,
        ];

        Mail::to('test@gmail.com')->send(new MySendMail($user));

        Session::flash('message', "Email has been sent");
        return Redirect::back();        
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = User::findOrFail($request->get('id'));
        $user->update(
        [
            'name' => $request->name,
            'identifer' => $request->identifier,
            'mobile' => $request->mobile,
            'birth_date' => $request->birth_date,
            
        ]);                         

        return Redirect::back();        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
