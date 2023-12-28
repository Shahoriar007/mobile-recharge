@extends('layouts/contentLayoutMaster')

@section('title', 'Blog View')

@section('content')

<div class="card">
  <div class="card-header">

  </div>
  <div class="card-body">
    <div class="card-text">
        <div class="card g-3 mt-5">
            <div class="card-body row g-3">
              <div class="col-lg-8">
                <div class="d-flex justify-content-between align-items-center flex-wrap mb-2 gap-1">
                  <div class="me-1">
                    <h1 class="mb-1">{{ $data->title }}</h1>
                    <p class="mb-1">{{ $data->author->name }} ||  <span class="fw-medium"> {{  \Carbon\Carbon::parse($data->meta_publish_date)->format('d M Y') }} || Read Time:  {{ $data->read_time }} </span></p>

                  </div>

                </div>
                </div>
                <div class="card academy-content shadow-none border">

                  <div class="card-body">

                    <img src="{{ asset($data->feature_picture) }}" alt="images" style="width: 100%">
                    <br><br>
                    {!! $data->description !!}

                  </div>
                </div>
              </div>

            </div>
          </div>
    </div>
  </div>
</div>


@endsection
