@extends('layouts/contentLayoutMaster')

@section('title', 'Offer List')

@section('vendor-style')
    <!-- vendor css files -->
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
@endsection

@section('content')

@if(Session::has('success'))
    <div id="success-alert" class="alert alert-success" style="padding: 15px;">
        {{ Session::get('success') }}
    </div>
@endif

    <div class="row" id="table-hover-row">
        <div class="col-12 card">
            <div class="card-body">
                <form class="form form-horizontal" action="{{ route('update-or-create-offer') }}" method="POST">
                    @csrf

                    <input type="hidden" name="id" id="record_id" value="">

                    <div class="row">

                        <div class="col-12">
                            <div class="mb-1 row">
                                <div class="col-sm-3">
                                    <label class="col-form-label" for="description">Description<span style="color: red"> * </span></label>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" id="description" class="form-control" name="description"
                                        placeholder="description" value="{{ old('description') }}" />
                                    @error('description')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>


                        <div class="col-12">
                            <div class="mb-1 row">
                                <div class="col-sm-3">
                                    <label class="col-form-label" for="provider">Provider<span style="color: red"> * </span></label>
                                </div>
                                <div class="col-sm-9">
                                    <select id="provider_id" class="form-control" name="provider_id" >
                                        <option value="" disabled selected>Select provider</option>
                                        @foreach($providers as $provider)
                                        <option value="{{ $provider->id }}">{{ $provider->name }}</option>
                                        @endforeach

                                    </select>
                                    @error('provider')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                        </div>


                        <div class="col-12">
                            <div class="mb-1 row">
                                <div class="col-sm-3">
                                    <label class="col-form-label" for="type">type<span style="color: red"> * </span></label>
                                </div>
                                <div class="col-sm-9">
                                    <select id="type" class="form-control" name="type" >
                                        <option value="" disabled selected>Select type</option>
                                        <option value="minute">Minute</option>
                                        <option value="internet">Internet</option>
                                    </select>
                                    @error('type')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                        </div>
                        <div class="col-12">
                            <div class="mb-1 row">
                                <div class="col-sm-3">
                                    <label class="col-form-label" for="price">Price<span style="color: red"> * </span></label>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" id="price" class="form-control" name="price"
                                        placeholder="price" value="{{ old('price') }}" />
                                    @error('price')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="mb-1 row">
                                <div class="col-sm-3">
                                    <label class="col-form-label" for="cashback">Cashback<span style="color: red"> * </span></label>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" id="cashback" class="form-control" name="cashback"
                                        placeholder="cashback"  required/>
                                    @error('cashback')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>


                        <div class="col-sm-9 offset-sm-3">
                            @if (session('error'))
                                <div class="text-danger">
                                    {{ session('error') }}
                                </div>
                            @endif
                            <button type="submit" class="btn btn-primary me-1">Submit</button>
                            <button type="reset" class="btn btn-outline-secondary">Reset</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
        <div class="col-12">
            <div class="card">


                <div class="table-responsive">
                    <table class="table table-hover" id="offersTable">
                        <thead>
                            <tr>
                                <th>Description</th>
                                <th> provider</th>
                                <th>type</th>
                                <th>price</th>
                                <th>cashback</th>
                                <th>Actions</th>

                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($offers as $offer)
                            <tr data-id="{{ $offer->id }}">
                                <td>{{ $offer->description }}</td>
                                <td>{{ $offer->provider->name}}</td>

                                <td>{{ $offer->type }}</td>
                                <td>{{ $offer->price }}</td>

                                <td>{{ $offer->cashback }}</td>
                                <td>
                                    <form id="deleteForm" method="POST" action="{{ route('delete-offer') }}" class="d-inline">
                                        @method('DELETE')
                                        @csrf
                                        <input type="text" name="offer_id" id="delete-offer-id" hidden>
                                        <button type="button" class="btn-link" style="border: none; background: none; padding: 0; margin: 0;"
                                           onclick="confirmDelete({{ $offer->id }})">
                                           <i data-feather="trash-2" class="me-50"></i>
                                        </button>
                                     </form>                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mx-1 d-flex justify-content-end">
                        <nav aria-label="Page navigation">
                            <ul class="pagination mt-2">
                                <li class="page-item prev"><a class="page-link"
                                        style="pointer-events: {{ $offers->currentPage() == 1 ? 'none' : '' }}"
                                        href="{{ $offers->url($offers->currentPage() - 1) }}"></a>
                                </li>
                                @for ($i = 1; $i <= $offers->lastPage(); $i++)
                                    <li class="page-item {{ $i == $offers->currentPage() ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $offers->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endfor
                                <li class="page-item next" disabled><a class="page-link"
                                        style="pointer-events: {{ $offers->currentPage() == $offers->lastPage() ? 'none' : '' }}"
                                        href="{{ $offers->url($offers->currentPage() + 1) }}"></a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- Hoverable rows end -->

@endsection

@section('vendor-script')
    <!-- vendor js files -->
    <script src="{{ asset(mix('vendors/js/pagination/jquery.bootpag.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pagination/jquery.twbsPagination.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
@endsection
@section('page-script')
    {{-- Page js files --}}
    <script src="{{ asset(mix('js/scripts/pagination/components-pagination.js')) }}"></script>
    <script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>


    <script src="https://price.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function(){
            setTimeout(function(){
                $("#success-alert").alert('close');
            }, 3000);
        });
    </script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const descriptionInput = document.getElementById('description');
        const providerInput = document.getElementById('provider_id');
        const recordIdInput = document.getElementById('record_id');
        const dataTable = document.getElementById('offersTable');

        function searchRecord() {
            const description = descriptionInput.value.toLowerCase();
            const provider = providerInput.options[providerInput.selectedIndex].text.toLowerCase();
            let recordId = '';

            Array.from(dataTable.querySelectorAll('tbody tr')).forEach(row => {
                const rowDescription = row.cells[0].textContent.toLowerCase();
                const rowProvider = row.cells[1].textContent.toLowerCase(); // Assuming the provider is in the second column
                console.log(rowDescription,rowProvider);
                console.log(description,provider);

                if (rowDescription === description && rowProvider === provider) {
                    recordId = row.getAttribute('data-id');
                }
            });

            recordIdInput.value = recordId;


        }

        descriptionInput.addEventListener('input', searchRecord);
        providerInput.addEventListener('change', searchRecord);
    });
</script>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        function confirmDelete(offerId) {

            console.log(offerId);
            document.getElementById('delete-offer-id').value = offerId;
        Swal.fire({
            title: 'Are you sure?',
            text: 'You won\'t be able to revert this!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                submitForm();
            }
        });
    }

    function submitForm() {
        document.getElementById('deleteForm').submit();
    }
    </script>



@endsection
