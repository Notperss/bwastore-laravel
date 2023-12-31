@extends('layouts.admin')

@section('title')
  Edit
@endsection

@section('content')
  <div class="section-content section-dashboard-home" data-aos="fade-up">
    <div class="container-fluid">
      <div class="dashboard-heading">
        <h2 class="dashboard-title">Edit</h2>
        <p class="dashboard-subtitle">Edit User</p>
      </div>
      <div class="dashboard-content">
        <div class="row">
          <div class="col-md-12">
            @if ($errors->any())
              <div class="alert alert-danger">
                <ul>
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            @endif
            <div class="card">
              <div class="card-body">
                <form action="{{ route('user.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  @method('PUT')
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $item->name) }}"
                          required>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Email User</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $item->email) }}"
                          required>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control">
                        <small class="text-danger">Kosongkan jika tidak ingin ganti password</small>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Roles</label>
                        <select name="roles" id="roles" class="form-control">

                          <option value="ADMIN" {{ $item->roles == 'ADMIN' ? 'selected' : '' }}>Admin</option>
                          <option value="USER" {{ $item->roles == 'USER' ? 'selected' : '' }}>User</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col text-right">
                      <button class="btn btn-success px-5" type="submit">Save Now</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
