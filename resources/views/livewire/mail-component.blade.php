<div>
    @if (session()->has('message'))
        <div class="alert alert-success">
          {{ session('message') }}
        </div>
    @endif
    
    <div class="card">        
        <div class="card-header card-header-rose card-header-icon">
            @can('create_mail')  
                <button wire:click="selectAction('0', 'create')" class="btn btn-danger btn-round" data-toggle="modal" data-target="#addRegion" data-backdrop="false" style="text-transform: uppercase">
                    <i class="material-icons" >add</i> {{__('admin.addMail')}}
                    <div class="ripple-container"></div>
                </button>
            @endcan
            @can('import_excel_mail')  
                <button wire:click="selectAction('0', 'import')" style="float: right;" class="btn btn-danger btn-round" style="text-transform: uppercase">
                    <i class="material-icons">file_download</i> Import
                    <div class="ripple-container"></div>
                </button>
            @endcan
            @can('export_excel_mail')  
                <button style="float: right;cursor: not-allowed" class="btn btn-danger btn-round" style="text-transform: uppercase" disabled>
                    <i class="material-icons">file_download</i> Export
                    <div class="ripple-container"></div>
                </button>
            @endcan
        </div>
        
        <div class="card-body">
           <div class="table-responsive">
            <table class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width: 100%;">
              <thead>
                <tr>
                  <th class="text-center">{{__('admin.subject')}}</th>
                  <th class="text-center">{{__('admin.recipient')}}</th>
                  <th class="text-center">{{__('admin.body')}}</th>
                  <th class="text-center">{{__('admin.status')}}</th>
                  <th class="text-center">{{__('admin.options')}}</th>
                </tr>
              </thead>
              <tbody>
                @foreach($mails as $data)  
                    <tr>
                      <td class="text-center">{{$data->subject}}</td>
                      <td class="text-center">{{$data->recipient}}</td>
                      <td class="text-center">{{$data->body }}</td>
                      <td class="text-center">{{$data->state }}</td>
                      <td class="td-actions text-center">
                        @can('delete_mail')  
                            <button wire:click="openRemoveModal({{$data->id}})" type="button" rel="tooltip" class="btn btn-danger btn-round" title="">
                              <i class="material-icons">close</i>
                            </button>             
                        @endcan
                      </td>
                    </tr>
                @endforeach                                                      
              </tbody>
            </table>
            {{ $mails->links() }}                     
          </div>

        </div>
    </div>
    <!--includes-->
    @include('livewire.modals.mails.create') 
    <!--endincludes-->
    
  <script>
        window.addEventListener('openMailCreateModal', event => { 
            $('#createMail').modal('show');
        });
        window.addEventListener('closeMailCreateModal', event => { 
            $('#createMail').modal('hide');
            location.reload();
            notification('top','center',event.detail.message);
        });
        window.addEventListener('openMailDeleteModal', event => {
            $("#deleteMail").modal('show');
        });
        window.addEventListener('closeMailDeleteModal', event => {
            location.reload();
            notification('top','center',event.detail.message);
        });

        window.addEventListener('mailRemove', event => {
            swal({
                title: event.detail.title,
                text: event.detail.message,
                type: 'warning',
                showCancelButton: true,
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                confirmButtonText: event.detail.btn_accept,
                buttonsStyling: false
              }).then(function(willDelete) {

                  if (willDelete.value) {
                     window.livewire.emit('mail-remove', {});
                  } 
                  location.reload();
              });
        });

        function notification(from, align, message) {
            $.notify({
              icon: "add_alert",
              message: message

            }, {
              type: 'success',
              timer: 500,
              placement: {
                from: from,
                align: align
              }
            });
        }

  </script>
    
</div>

