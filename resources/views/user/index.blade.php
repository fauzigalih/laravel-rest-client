@extends('layouts.main')
@section('title', 'Home')
@section('content')
  @include('layouts.alert')
  <h1>Users</h1>
  <a href="{{ url('create') }}" role="button" class="btn btn-primary mb-2"><i class="fa fa-plus" aria-hidden="true"></i> Create User</a>
  <table class="table table-striped">
    <thead class="thead-dark">
      <tr>
        <th scope="col">#</th>
        <th scope="col">Name</th>
        <th scope="col">Email</th>
        <th scope="col">Phone</th>
        <th scope="col">Action</th>
      </tr>
    </thead>
    <tbody>
      @if (count($models) > 0)
        @foreach ($models as $model)
          <tr>
            <th scope="row">{{ $loop->iteration }}</th>
            <td>{{ $model['name'] }}</td>
            <td>{{ $model['email'] }}</td>
            <td>{{ $model['phone'] }}</td>
            <td>
              <a href="{{ url('show?id='.$model['id']) }}"><i class="fa fa-eye" aria-hidden="true"></i></a>
              <a href="{{ url('edit?id='.$model['id']) }}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
              <a href="#" data-toggle="modal" data-target="#confirm{{ $model['id'] }}"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
              <!-- Modal -->
              <div class="modal fade" id="confirm{{ $model['id'] }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Confirmation</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      Are you sure you want to delete user data?
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      {!! Form::open(['url' => 'destroy?id='.$model['id'], 'method' => 'DELETE']) !!}
                        <button type="submit" class="btn btn-danger">Delete</button>
                      {!! Form::close() !!}
                    </div>
                  </div>
                </div>
              </div>
            </td>
          </tr>
        @endforeach
      @else
        <tr>
          <td colspan="100%">Data not found.</td>
        </tr>
      @endif
    </tbody>
  </table>
@endsection