<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use DataTables;
use Illuminate\Support\Facades\Mail;
use App\Mail\MySendMail;
use Session;
use Validator;
use Redirect;
use App\Adapters\APIAdapters\WebAPI;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    protected $api;
    
    public function __construct(WebAPI $api)
    {
        $this->api = $api;
    }    

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
                        return '<a href="#edit-'.$row->id.'" class="btn btn-xs btn-primary edit"><i class="glyphicon glyphicon-edit"></i> Edit</a>' . ' ' . '<a onclick="deleteModal('.$row->id.')" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
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

    public function getUsersFromAPI(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->api->getUsers();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->make(true);
        }       

        return view('users.usersFromApi');      
    }

    public function createNewUser()
    {
        $countries = Country::all();
        return view('users.newUser', compact('countries'));      
    }

    public function getStates(Request $request){
        $states = State::where('country_id',$request->id)->get();

         return response()->json(
             [
                 'lista' => $states,
                 'success' => true
             ]
         );
    }    

    public function getCities(Request $request){
        $city = City::where('state_id',$request->id)->get();

         return response()->json(
             [
                 'lista' => $city,
                 'success' => true
             ]
         );
    }    
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'password' => 'required|min:6|confirmed',
            'email' => 'required|unique:users|max:255',
            'name' => 'required|max:100',
            'identifer' => 'required',
            'birth_date' => 'required',
            'card_id' => 'required|max:11',
        ]);        

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'identifer' => $request->identifer,
            'mobile' => $request->mobile,
            'birth_date' => $request->birth_date,
            'card_id' => $request->card_id,
            'city_id' => $request->city_id,
            'role_id' => $request->role_id,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('users');
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
        $validated = $request->validate([
            'password' => 'required|min:6|confirmed',
            'email' => 'required|unique:users|max:255',
            'name' => 'required|max:100',
            'identifer' => 'required',
            'birth_date' => 'required',
            'card_id' => 'required|max:11',
        ]);        
        
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
    public function destroy(Request $request)
    {
        $model = User::where('id','=', $request->id)->delete();
        
        return Redirect::back();        
    }
}
