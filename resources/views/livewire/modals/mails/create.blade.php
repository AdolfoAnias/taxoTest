<!-- Modal -->

<div class="modal fade" id="createMail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true" wire:ignore.self data-backdrop="static" data-keyboard="false">
   
<div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body">
          <form id="RegisterValidation" wire:submit.prevent="store" novalidate="novalidate">
          <div class="card">
            <div class="card-header card-header-rose text-center" >
                <h4 class="card-title">{{__('admin.newMail')}}</h4>
            </div>
            <div class="card-body ">
                <div class="col-sm-12">
                  <div class="row">
                    <label class="col-sm-3 col-form-label">{{__('admin.subject')}}</label>    
                    <div class="col-md-9">
                        <div class="form-group" style="padding-bottom: 0px;">
                        <input wire:model="subject" type="text" class="form-control" id="title" required="true" aria-required="true" aria-invalid="true" autocomplete="off"/>
                        @error('subject')
                             <label class="error" >{{$message}}</label>
                        @enderror                                                
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-sm-12">
                  <div class="row">
                    <label class="col-sm-3 col-form-label">{{__('admin.recipient')}}</label>    
                    <div class="col-md-9">
                        <div class="form-group" style="padding-bottom: 0px;">
                        <input wire:model="recipient" type="text" class="form-control" id="title" required="true" aria-required="true" aria-invalid="true" autocomplete="off"/>
                        @error('recipient')
                             <label class="error" >{{$message}}</label>
                        @enderror                                                
                      </div>
                    </div>
                  </div>
                </div>               
               
                <div class="col-sm-12">
                  <div class="row">
                    <label class="col-sm-3 col-form-label">{{__('admin.description')}}</label>  
                    <div class="col-md-9">
                      <div class="form-group" style="padding-bottom: 0px;">
                        <input wire:model="description" type="text" class="form-control" id="description" required="true" aria-required="true" aria-invalid="true" autocomplete="off" />
                        @error('description')
                             <label class="error" >{{$message}}</label>
                        @enderror                        
                      </div>
                    </div>
                  </div>
                </div>               
               
                
            </div>
          </div>
        
        </div>
        <div class="modal-footer">
            <div class="form-check mr-auto">                
            </div>
            <button type="submit" class="btn btn-rose">{{__('admin.send')}}<div class="ripple-container"></div></button>
            <button type="button" class="btn btn-danger btn-link" data-dismiss="modal">{{__('admin.cancel')}}<div class="ripple-container"><div class="ripple-decorator ripple-on ripple-out" style="left: 34.0938px; top: 22px; background-color: rgb(244, 67, 54); transform: scale(8.44923);"></div><div class="ripple-decorator ripple-on ripple-out" style="left: 34.0938px; top: 22px; background-color: rgb(244, 67, 54); transform: scale(8.44923);"></div></div></button>            
        </div>
        </form>  
      </div>
    </div>
   
</div>




