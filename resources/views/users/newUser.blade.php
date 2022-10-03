@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Register New User') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('store.user') }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}*</label>

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
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Email') }}*</label>

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
                                    <input id="birth_date" type="date" onchange="getAge(event);" class="form-control @error('birth_date') is-invalid @enderror" name="birth_date" value="{{ old('birth_date') }}" autocomplete="birth date" autofocus>

                                    @error('birth_date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>    
                            
                            <div class="form-group row">
                                <label for="address" class="col-md-4 col-form-label text-md-right">Country*</label>
                                <div class="col-md-6">
                                    <select class="form-control" style="height: 35px; overflow: auto" id="selectCountry" name="selectCountry" required>
                                        <option value=""></option>
                                        @foreach($countries as $data) 
                                            <option value="{{ $data->id }}">{{ $data->name}}</option>
                                        @endforeach
                                    </select>        
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="address" class="col-md-4 col-form-label text-md-right">State*</label>
                                <div class="col-md-6">
                                    <select class="form-control" style="height: 35px; overflow: auto" id="selectState" name="selectState" required>
                                    </select>        
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="address" class="col-md-4 col-form-label text-md-right">City*</label>
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
                                        {{ __('Register') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script>
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
                    document.getElementById('btnSubmit').disabled=false;
                }
            }

        </script>

    </div>
@endsection

