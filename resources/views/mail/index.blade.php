@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Emails</h1>
        <table id='mailsDatatable' class="table table-bordered data-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Asunto</th>
                    <th>Destinatario</th>
                    <th>Body</th>
                    <th>State</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

    <script type="text/javascript">       
      $(function () {
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('moduleMails') }}",
            columns: [
                {data: 'id', name: 'id'},
                {data: 'asunto', name: 'asunto'},
                {data: 'destinatario', name: 'destinatario'},
                {data: 'body', name: 'body'},
                {data: 'state', name: 'state'},
            ]
        });
      });

    </script>
@endsection

