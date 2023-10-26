@extends('layouts.admin')

@section('title')
  Edit
@endsection

@section('content')
  <div class="section-content section-dashboard-home" data-aos="fade-up">
    <div class="container-fluid">
      <div class="dashboard-heading">
        <h2 class="dashboard-title">Edit</h2>
        <p class="dashboard-subtitle">Edit transaction</p>
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
                <form action="{{ route('transaction.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  @method('PUT')
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Transaction Status</label>
                        <select name="transaction_status" class="form-control">
                          <option
                            value="PENDING
                            "{{ $item->transaction_status == 'PENDING' ? 'selected' : '' }}>
                            Pending
                          </option>
                          <option
                            value="SHIPPING
                            "{{ $item->transaction_status == 'SHIPPING' ? 'selected' : '' }}>
                            Shipping
                          </option>
                          <option
                            value="SUCCESS
                            "{{ $item->transaction_status == 'SUCCESS' ? 'selected' : '' }}>
                            Success
                          </option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Price</label>
                        <input type="number" name="total_price" class="form-control"
                          value="{{ old('total_price', $item->total_price) }}" required>
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

@push('addon-script')
  <script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
  <script>
    ClassicEditor
      .create(document.querySelector('#editor'))
      .catch(error => {
        console.error(error);
      });
  </script>
@endpush
