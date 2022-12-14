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
use App\Contracts\IUserRepository;
use Carbon\Carbon;

class UserController extends Controller
{
    protected $api;
    protected $userRepo;
    
    public function __construct(WebAPI $api, IUserRepository $userRepo)
    {
        $this->api = $api;
        $this->userRepo = $userRepo;
    }    

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::select('*');
            $this->getDatatable($data);
        }       

        $countries = Country::all();        
        return view('users.index', compact('countries'));
    }

    public function getDatatable($data)
    {
        return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('age', function($row){                         
                    $edad = Carbon::createFromDate($row->birth_date)->age; 
                    return $edad; 
                })                                                                                
                ->addColumn('country', function($row){                         
                    return $row->city->state->country->name;
                })                                                            
                ->addColumn('state', function($row){                         
                    return $row->city->state->name;
                })                                        
                ->addColumn('city', function($row){                         
                    return $row->city->name;
                })                    
                ->addColumn('action', function($row){                         
                    return '<a href="#edit-'.$row->id.'" class="btn btn-xs btn-primary edit"><i class="glyphicon glyphicon-edit"></i> Edit</a>' . ' ' . '<a onclick="deleteModal('.$row->id.')" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
                })
                ->rawColumns(['action','country','state','country','age'])
                ->make(true);
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
        return response()->json(['lista' => $states,'success' => true]);
    }    

    public function getCities(Request $request){
        $city = City::where('state_id',$request->id)->get();
        return response()->json(['lista' => $city,'success' => true]);
    }    

    public function validateData(Request $request)
    {
        $rules = [
            'password' => 'required|min:8|confirmed|regex:/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{3,}$/',            
            'email' => 'required|unique:users|max:255',
            'name' => 'required|max:100',
            'identifer' => 'required',
            'birth_date' => 'required',
            'card_id' => 'required|max:11',
        ];
        
        $messages = ['password.regex' => 'El password debe ser mi??nimo de 8 caracteres, contener al menos un nu??mero, una letra mayu??scula y un cara??cter especial.',];        
        
        return $this->validate($request, $rules, $messages);        
    }    
    
    public function store(Request $request)
    {        
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'identifer' => $request->identifer,
            'mobile' => $request->mobile,
            'birth_date' => $request->birth_date,
            'card_id' => $request->card_id,
            'city_id' => $request->city_id,
            'role_id' => $request->role_id,
            'password' => Hash::make($request->password),
        ];
        
        $this->userRepo->create($data);
        
        return redirect()->route('users');
    }

    public function update(Request $request)
    {
        if($request->has('password')){
            $validated = $request->validate([
                'password' => 'required|min:8|confirmed',
                'name' => 'required|max:100',
                'identifer' => 'required',
                'birth_date' => 'required',
            ]);           
        }else{
            $validated = $request->validate([
                'name' => 'required|max:100',
                'identifer' => 'required',
                'birth_date' => 'required',
            ]);                       
        }
                
        $user = User::findOrFail($request->get('id'));

        if($request->has('password')){
            $user->update([
                'name' => $request->name,
                'identifer' => $request->identifer,
                'mobile' => $request->mobile,
                'birth_date' => $request->birth_date,
                'role_id' => $request->role_id,
                'password' => Hash::make($request->password),
            ]);                         
        }else{
            $user->update([
                'name' => $request->name,
                'identifer' => $request->identifer,
                'mobile' => $request->mobile,
                'birth_date' => $request->birth_date,
                'role_id' => $request->role_id,
            ]);                                     
        }    

        return Redirect::back();        
    }

    public function destroy(Request $request, $id)
    {
        if(request()->ajax()){
            $model = User::where('id','=', $id)->delete();
            return response()->json(['success' => true]);
        }
    }
}
