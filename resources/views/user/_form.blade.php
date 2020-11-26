@php
  $show = Route::currentRouteName() === 'show';
  $edit = Route::currentRouteName() === 'edit';
@endphp
{!! Form::open(['url' => $edit ? 'update/'.$model->id : '/', 'method' => $edit ? 'PUT' : 'POST']) !!}
  <div class="form-group">
    {!! Form::label('name', 'Full Name') !!}
    {!! Form::text('name', $model->name ?? null, ['class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''), $show ? 'readonly' : 'required']) !!}
    @error('name')
      <small class="form-text text-danger">{{ $message }}</small>
    @enderror
  </div>
  <div class="form-group">
    {!! Form::label('email', 'Email Address') !!}
    {!! Form::email('email', $model->email ?? null, ['class' => 'form-control' . ($errors->has('email') ? ' is-invalid' : ''), $show ? 'readonly' : 'required']) !!}
    @error('email')
      <small class="form-text text-danger">{{ $message }}</small>
    @enderror
    @if (session('error'))
      <small class="form-text text-danger">{{ session('error') }}</small>
    @endif
    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
  </div>
  <div class="form-group">
    {!! Form::label('phone', 'Phone Number') !!}
    {!! Form::number('phone', $model->phone ?? null, ['class' => 'form-control' . ($errors->has('phone') ? ' is-invalid' : ''), $show ? 'readonly' : 'required']) !!}
    @error('phone')
      <small class="form-text text-danger">{{ $message }}</small>
    @enderror
  </div>
  @if (!$show)
    {!! Form::button('<i class="fa fa-check" aria-hidden="true"></i> Save', ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
  @endif
  <a href="{{ url('/') }}" class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i> Back</a>
{!! Form::close() !!}