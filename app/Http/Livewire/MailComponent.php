<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Email;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;

class MailComponent extends Component
{
    use WithPagination;
    
    public $perPage = 10;
    public $search = '';    
    public $search_field = '';    
    public $onSearch = False;    
    
    public $page = 1;      
  
    public $mail_id, $subject, $recipient, $body, $status, $modelId, $selectedItem;
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
        'asunto'=>'required|filled',        
        'destinatario'=>'required|filled',        
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
