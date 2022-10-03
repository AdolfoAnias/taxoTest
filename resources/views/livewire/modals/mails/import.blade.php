<!-- Modal -->

<div class="modal fade" id="importMail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true" wire:ignore.self data-backdrop="static" data-keyboard="false">
   
<div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body">
            <form action="{{ route('home') }}" method="POST" id="RegisterValidation" novalidate="novalidate" enctype="multipart/form-data">
                @csrf
                <div class="card">
                  <div class="card-header card-header-rose text-center" style="margin-top:-80px;">
                      <h4 class="card-title">{{__('admin.importMail')}}</h4>
                  </div>
                  <div class="card-body">
                    <div class="mb-3">
                        <label for="exampleInputName">File:</label>
                        <input type="file" name="photo" class="form-control">
                        <div>
                            @error('photo') <span class="text-sm text-red-500 italic">{{ $message }}</span>@enderror
                        </div>
                    </div>
                  </div>
                </div>
        </div>
          <div class="modal-footer">
              <div class="form-check mr-auto">                
              </div>
              <button type="submit" class="btn btn-rose">{{__('common.save')}}<div class="ripple-container"></div></button>
              <button type="button" class="btn btn-danger btn-link" data-dismiss="modal">{{__('common.cancel')}}<div class="ripple-container"><div class="ripple-decorator ripple-on ripple-out" style="left: 34.0938px; top: 22px; background-color: rgb(244, 67, 54); transform: scale(8.44923);"></div><div class="ripple-decorator ripple-on ripple-out" style="left: 34.0938px; top: 22px; background-color: rgb(244, 67, 54); transform: scale(8.44923);"></div></div></button>            
          </div>
        </form>  
      </div>
    </div>

</div>

