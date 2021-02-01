@extends('layouts.appAlumni')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if(isset($errors) && $errors->any())
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                        {{$error}}
                        @endforeach
                    </div>
                    @endif
                    @if(session()->has('failures'))
                    <table class="table table-danger">
                        <tr>
                            <th>Row</th>
                            <th>Attribute</th>
                            <th>Error</th>
                            <th>Value</th>
                        </tr>
                        @foreach (session()->get('failures') as $validation)
                        <tr>
                            <td>{{$validation->row()}}</td>
                            <td>{{$validation->attribute()}}</td>
                            <td>
                                <ul>
                                @foreach($validation->errors() as $e)
                                <li>{{$e}}</li>
                                @endforeach
                                </ul>
                            </td>
                            <td>{{$error->values()[$validation->attribute()]}}</td>
                        </tr>
                        @endforeach
                    </table>
                    @endif
                    <form action="/alumni/import" method="post" enctype="multipart/form-data">
                          @csrf 
                          <div class="form-group">
                            <input type="file" name="file" />
                            
                            <button type="submit" class="btn btn-primary">Import</button>
                          </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@if(\Session::has('success'))
<script>
Swal.fire({
  icon: 'success',
  title: 'Your password has been updated!',
  showConfirmButton: false,
  timer: 1500
})
</script>
@endif
@endsection
