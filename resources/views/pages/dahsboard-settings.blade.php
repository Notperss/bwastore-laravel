@extends('layouts.dashboard')

@section('title')
  Store Settings
@endsection

@section('content')
  <div class="section-content section-dashboard-home" data-aos="fade-up">
    <div class="container-fluid">
      <div class="dashboard-heading">
        <h2 class="dashboard-title">Dashboard Settings</h2>
        <p class="dashboard-subtitle">Make Store that profitable!</p>
      </div>
      <div class="dashboard-content">
        <div class="row">
          <div class="col-12">
            <form action="{{ route('dashboard-settings-redirect', 'dashboard-settings-store') }}" method="POST"
              enctype="multipart/form-data">
              @csrf
              <div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group" data-aos="zoom-in" data-aos-delay="100">
                        <label>Nama Toko</label>
                        <input type="text" class="form-control" name="store_name" value="{{ $user->store_name }}" />
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group" data-aos="zoom-in" data-aos-delay="150">
                        <label>Category</label>
                        <select name="categories_id" id="" class="form-control">
                          <option value="" selected disabled>
                            Select Category
                          </option>
                          @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                              {{ $category->id == $user->categories_id ? 'selected' : '' }}> {{ $category->name }}
                            </option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Store Status</label>
                        <p class="text-muted">
                          Apakah saat ini toko Anda buka?
                        </p>
                        <div class="custom-control custom-radio custom-control-inline">
                          <input type="radio" class="custom-control-input" name="store_status" id="openStoreTrue"
                            value="1" {{ $user->store_status == 1 ? 'checked' : '' }} />
                          <label for="openStoreTrue" class="custom-control-label">Buka
                          </label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                          <input type="radio" class="custom-control-input" name="store_status" id="openStoreFalse"
                            value="0"
                            {{ $user->store_status == 0 || $user->store_status == null ? 'checked' : '' }} />
                          <label for="openStoreFalse" class="custom-control-label">Sementara Tutup
                          </label>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col text-right">
                      <button class="btn btn-success px-5">
                        Save Now
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
