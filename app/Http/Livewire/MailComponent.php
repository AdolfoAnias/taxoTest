<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Email;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Illuminate\Support\Facades\Mail;
use App\Mail\MySendMail;

class MailComponent extends Component
{
    use WithPagination;
    
    public $perPage = 10;
    public $search = '';    
    public $search_field = '';    
    public $onSearch = False;    
    
    public $page = 1;      
  
    public $mail_id, $subject, $recipient, $body, $state, $modelId, $selectedItem;
    public $excel;
   
    public $created_at, $updated_at;

    public $modal = false;
    public $updateMode = false; 

    protected $paginationTheme = 'bootstrap';

    protected $listeners = [
        'getModelId',
        'postDestroy' => 'refreshDatatable',
        'mail-remove'=> 'delete',
    ];
    
    protected $rules =[
        'subject'=>'required|filled',        
        'recipient'=>'required|filled',        
        'body'=>'required|filled',        
    ];

   public function openRemoveModal($id) {
        $this->mail_id = $id;
        $this->dispatchBrowserEvent('mailRemove', ['title' => __('admin.remove_title'), 'message' => __('admin.remove_mail_message'), 'btn_accept' => __('admin.setting_accept_button')]);
   }
   
    public function refreshDatatable() {
        $this->dispatchBrowserEvent('refreshDatatable', ['componentName' => '#datatables']);
    }   

    public function selectAction($itemId, $action){       
        $this->selectedItem = $itemId;

        if ($action == 'create') {
            $this->resetInputFields();
            $this->dispatchBrowserEvent('openMailCreateModal');
        } 
        
        if ($action == 'delete') {
            $this->dispatchBrowserEvent('openMailDeleteModal');
        } 
        
        if ($action == 'edit') {
            $this->resetInputFields();
            $a = $this->getModelId($this->selectedItem);   
            $this->updateLeadOK = false;
            $this->dispatchBrowserEvent('openMailEditModal');
        }

        if ($action == 'import') {
            $this->resetInputFields();
            $this->dispatchBrowserEvent('openImportModal', ['message' => '']);
        }               
    }   
    
    public function render(Request $request)
    {
        $authUser = Auth::user();
        if( $authUser->hasRole('Admin')){
            $data = Email::all();
        }else{
            $data = Email::where('user_id',$authUser->id)->get();
        }
        
        $currentPage = Paginator::resolveCurrentPage();
        $col = collect($data);
        $perPage = 20;
        $currentPageItems = $col->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $items = new Paginator($currentPageItems, count($col), $perPage);
        $items->setPath(url('mail'));
        $items->appends($request->all());        

        return view('livewire.mail-component',[
            'mails' => $items,
        ]);       
    }
    
    public function getModelId($modelId){
        $this->modelId = $modelId;
        
        $model = Email::findOrFail($this->modelId);     

        $this->subject = $model->subject;
        $this->recipient = $model->recipient;
        $this->body = $model->body;        
        $this->state = $model->state;        
    }

    public function resetInputFields(){
        $this->subject = '';
        $this->recipient = '';
        $this->body = '';
        $this->state = '';
        
        $this->resetErrorBag();        
    }
    
    public function store(){
        $this->validate();  
        
        $authUser = Auth::user();
        $mail = Email::create([
            'subject' => $this->subject,
            'recipient' => $this->recipient,
            'body' => $this->body,
            'user_id' => $authUser->id,
            'state' => 'Not Sent',
        ]);                       

        $user = [
            'name' => $authUser->name,
            'email' => $authUser->email,
        ];

        Mail::to($this->recipient)->send(new MySendMail($user));
        
        $this->resetInputFields();
        $this->dispatchBrowserEvent('closeMailCreateModal', ['type' => 'success'  , 'message' => 'Mail Sent Succesufully!']);
    }     

    public function edit(){                             
        $data = [
            'state' => 'Sent',
        ];                 
        
        $this->resetInputFields();
        $this->dispatchBrowserEvent('closeMailEditModal', ['type' => 'success'  , 'message' => 'Mail Updated Succesufully !']);
    }
    
    public function importLeadsExcel(Request $request){ 
        dd($this->excel);
        (new MailsImport)->import(request()->file('photo'));
            
        $this->resetInputFields();
        $this->dispatchBrowserEvent('closeImportMailModal', ['message' => 'Mail Imported Succesufully!']);
    }    
    
    public function delete() {
        if($this->mail_id != '' || $this->mail_id != null){
            Email::find($this->mail_id)->delete();

            $this->resetInputFields();
            $this->dispatchBrowserEvent('closeMailDeleteModal', ['type' => 'success'  , 'message' => 'Mail Deleted Succesufully!']);
        }
    }
    
}
