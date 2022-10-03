@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Users List</h1>
        <a href="{{ route('newUser') }}" class="btn btn-primary"> {{__('admin.addUser')}} </a>
        <table id='userDatatable' class="table table-bordered data-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Identifier</th>
                    <th>Mobile</th>
                    <th>Card Id</th>
                    <th>Birth Date</th>
                    <th>Country</th>
                    <th>State</th>
                    <th>City</th>
                    <th width="100px">Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

    <div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="mediumBody">
                    <form method="POST" action="{{ route('edit') }}">
                        @csrf
                        <input id="id" type="hidden" name="id">

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>    

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="identifier" class="col-md-4 col-form-label text-md-right">{{ __('Identifier') }}</label>

                            <div class="col-md-6">
                                <input id="identifer" type="text" class="form-control @error('identifer') is-invalid @enderror" name="identifer" value="{{ old('identifer') }}" required autocomplete="identifier" autofocus onKeypress="if (event.keyCode < 48 || event.keyCode > 57) event.returnValue = false;">

                                @error('identifer')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>    

                        <div class="form-group row">
                            <label for="mobile" class="col-md-4 col-form-label text-md-right">{{ __('Mobile') }}</label>

                            <div class="col-md-6">
                                <input id="mobile" type="text" class="form-control @error('mobile') is-invalid @enderror" name="mobile" value="{{ old('mobile') }}" required autocomplete="mobile" autofocus onKeypress="if (event.keyCode < 48 || event.keyCode > 57) event.returnValue = false;">

                                @error('mobile')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>    

                        <div class="form-group row">
                            <label for="card_id" class="col-md-4 col-form-label text-md-right">{{ __('Card Id') }}</label>

                            <div class="col-md-6">
                                <input id="card_id" type="text" class="form-control @error('card_id') is-invalid @enderror" name="card_id" value="{{ old('card_id') }}" autocomplete="card id" autofocus>

                                @error('card_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>    

                        <div class="form-group row">
                            <label for="birth_date" class="col-md-4 col-form-label text-md-right">{{ __('Birth Date') }}</label>

                            <div class="col-md-6">
                                <input id="birth_date" type="date" class="form-control @error('birth_date') is-invalid @enderror" name="birth_date" value="{{ old('birth_date') }}" autocomplete="birth date" autofocus>

                                @error('birth_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>    

                        <div class="form-group row">
                            <label for="selectCountry" class="col-md-4 col-form-label text-md-right">Country*</label>
                            <div class="col-md-6">
                                <select class="form-control" style="height: 35px; overflow: auto" id="selectCountry" name="selectCountry" required>
                                    <option value=""></option>
                                    @foreach($countries as $data) 
                                        <option value="{{ $data->id }}" >{{ $data->name}}</option>
                                    @endforeach
                                </select>        
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="selectState" class="col-md-4 col-form-label text-md-right">State*</label>
                            <div class="col-md-6">
                                <select class="form-control" style="height: 35px; overflow: auto" id="selectState" name="selectState" required>
                                </select>        
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="city_id" class="col-md-4 col-form-label text-md-right">City*</label>
                            <div class="col-md-6">
                                <select class="form-control" style="height: 35px; overflow: auto" id="selectCity" name="city_id" required>
                                </select>        
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="role_id" class="col-md-4 col-form-label text-md-right">Rol*</label>
                            <div class="col-md-6">
                                <select class="form-control" style="height: 35px; overflow: auto" id="role_id" name="role_id" required>
                                    <option value=""></option>
                                    <option value="1">Admin</option>
                                    <option value="2">User</option>
                                </select>        
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button id="btnSubmit" type="submit" class="btn btn-primary">
                                    {{ __('Edit') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                    
            </div>
        </div>
    </div>

    <script type="text/javascript">
        document.getElementById('selectCountry').addEventListener('change',(e)=>{
            fetch('getStates',{
                method : 'POST',
                body: JSON.stringify({id : e.target.value}),
                headers:{
                    'Content-Type': 'application/json',
                    "X-CSRF-Token": '{{csrf_token()}}'
                }
            }).then(response =>{
                return response.json()
            }).then( data =>{                
                var opciones ="<option value=''>Elegir</option>";
                for (let i in data.lista) {
                   opciones+= '<option value="'+data.lista[i].id+'">'+data.lista[i].name+'</option>';
                }
                document.getElementById("selectState").innerHTML = opciones;
            }).catch(error =>console.error(error));
        })

        document.getElementById('selectState').addEventListener('change',(e)=>{
            fetch('getCity',{
                method : 'POST',
                body: JSON.stringify({id : e.target.value}),
                headers:{
                    'Content-Type': 'application/json',
                    "X-CSRF-Token": '{{csrf_token()}}'
                }
            }).then(response =>{
                return response.json()
            }).then( data =>{                
                var opciones ="<option value=''>Elegir</option>";
                for (let i in data.lista) {
                   opciones+= '<option value="'+data.lista[i].id+'">'+data.lista[i].name+'</option>';
                }
                document.getElementById("selectCity").innerHTML = opciones;
            }).catch(error =>console.error(error));
        })
        
        $('#userDatatable').on('click', '.edit', e => {
            $("#userModal").modal({backdrop: 'static', keyboard: false, show: true});
            
            let tr = $(e.target).closest('tr');
            
            // Asignar datos de modal desde TR o celdas específicas
            $('#id').val($(tr).find('td:eq(0)').text());
            $('#name').val($(tr).find('td:eq(1)').text());
            $('#email').val($(tr).find('td:eq(2)').text());
            $('#identifer').val($(tr).find('td:eq(3)').text());
            $('#mobile').val($(tr).find('td:eq(4)').text());
            $('#card_id').val($(tr).find('td:eq(5)').text());
            $('#birth_date').val($(tr).find('td:eq(6)').text());
            $('#selectCountry').val($(tr).find('td:eq(7)').text());
//            $('#age').val($(tr).find('td:eq(7)').text());
  //          $('#city').val($(tr).find('td:eq(8)').text());            
        });              

        function getAge(e) {
            var hoy = new Date();
            var cumpleanos = new Date(e.target.value);
            var edad = hoy.getFullYear() - cumpleanos.getFullYear();
            var m = hoy.getMonth() - cumpleanos.getMonth();

            if (m < 0 || (m === 0 && hoy.getDate() < cumpleanos.getDate())) {
                edad--;
            }
            
            if(edad < 18){
                alert('No puede ser menor de edad');
                document.getElementById('btnSubmit').disabled=true;
                document.getElementById("birth_date").focus();
            }else{
                alert('Mayor de edad');
                document.getElementById('btnSubmit').disabled=false;
            }
        }

        function deleteModal(id){            
            var id = $(this).data('id');
            
            swal({
                title: "Are you sure to delete this user?",
                type: 'error',
                showCancelButton: true,
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                confirmButtonText: event.detail.btn_accept,
                buttonsStyling: false
              }).then(function(willDelete) {
                  if (willDelete.value) {
                    $.ajax({
                        url:"{{ route('delete.user') }}",
                        method: "POST",
                        data: {id:id},
                        success: function(data) {
                            console.log("Yes! It works");
                        },
                        error: function(data) {
                            console.log("No! You are wrong!");
                        }
                    })                      
                  
                  } 
                  location.reload();
              });            
        };        
        
      $(function () {
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('users') }}",
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'identifer', name: 'identifer'},
                {data: 'mobile', name: 'mobile'},
                {data: 'card_id', name: 'card_id'},
                {data: 'birth_date', name: 'birth_date'},
                {data: 'country', name: 'country'},
                {data: 'state', name: 'state'},
                {data: 'city', name: 'city'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
      });

    </script>
@endsection