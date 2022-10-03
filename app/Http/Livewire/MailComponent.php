<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Email;
use Auth;
use Illuminate\Http\Request;

class MailComponent extends Component
{
    use WithPagination;
    
    public $perPage = 10;
    public $search = '';    
    public $search_field = '';    
    public $onSearch = False;    
    
    public $page = 1;    
    
    public $fields = ["ID","affiliate_id","payment_way_id","nameProduct","operator_id","status_reason_id","courier_id","full_name",
        "phone","parsed_phone","valid_phone","ip","country_ip","country_id","currency_id","price","units","changed_status",
        "confirmed_date","confirmedby_id","rejected_date","spam_date","call_counter","last_call_date","zip_code","address",
        "building","apto","callback_date","comment","priority","doubles","payout","processed_times"];            
   
    public $mail_id, $name, $description, $full_name, $phone, $parsed_phone, $comment, $price, $units, $payout, $address, $building, $apto, $email, $default, $status, $modelId, $selectedItem;
    public $excel;
   
    public $created_at, $updated_at;

    public $modal = false;
    public $updateMode = false; 

    protected $paginationTheme = 'bootstrap';

    protected $listeners = [
        'getModelId',
        'filterByTag' => 'getLeadByStatus',
        'postDestroy' => 'refreshDatatable',
        'arrayLeadChangeStatus' => 'changeStatus',
        'hallChanged' => 'change',
        'lead-remove'=> 'delete',
    ];
    
    protected $rules =[
        'full_name'=>'required|filled',        
        'parsed_phone'=>'required|filled',        
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

        if ($action == 'importMail') {
            $this->resetInputFields();
            $this->dispatchBrowserEvent('openImportMailModal', ['message' => '']);
        }          
       
    }   
    
    public function render(Request $request)
    {
        $data = Email::all();
        
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

        $this->asunto = $model->asunto;
        $this->destinatario = $model->destinatario;
        $this->body = $model->body;        
    }

    public function resetInputFields(){
        $this->asunto = '';
        $this->destinatario = '';
        $this->body = '';
        
        $this->resetErrorBag();        
    }
    
    public function store(){
        $this->validate();               
       
        $data = [
            'asunto' => $this->asunto,
            'destinatario' => $this->destinatario,
            'body' => $this->body,
            'user_id' => $this->user_id,
        ];                
        
        
        $this->resetInputFields();
        $this->dispatchBrowserEvent('closeMailCreateModal', ['type' => 'success'  , 'message' => 'Mail Sent Succesufully!']);
    }     

    public function edit(){                             
        $data = [
            'asunto' => $this->asunto,
            'destinatario' => $this->destinatario,
            'body' => $this->body,
            'user_id' => $this->user_id,
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


            $this->resetInputFields();
            $this->dispatchBrowserEvent('closeMailDeleteModal', ['type' => 'success'  , 'message' => 'Mail Deleted Succesufully!']);
        }
    }
    
}
