@extends('layouts/contentLayoutMaster')

@section('title', 'Passing to provider List')

@section('vendor-style')
    <!-- vendor css files -->
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
@endsection

@section('content')

    @if (Session::has('success'))
        <div id="success-alert" class="alert alert-success" style="padding: 15px;">
            {{ Session::get('success') }}
        </div>
    @endif

    <div class="row" id="table-hover-row">
        <div class="col-12 card">
            <div class="card-body">
                <form class="form form-horizontal" action="{{ route('update-or-create-passingProvider') }}" method="POST">
                    @csrf

                    <input type="hidden" name="id" id="record_id" value="">

                    <div class="row">
                        <div class="col-12">
                            <!-- Product ID Field -->
                            <div class="mb-1 row">
                                <div class="col-sm-3">
                                    <label class="col-form-label" for="product_id">Passing Provider ID<span style="color: red"> *
                                        </span></label>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" id="passing_provider_id" class="form-control" name="passing_provider_id"
                                    placeholder="search with passing_provider_id"  />
                                @error('passing_provider_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            </div>
                            <div class="mb-1 row">
                                <div class="col-sm-3">
                                    <label class="col-form-label" for="product_id">Product ID<span style="color: red"> *
                                        </span></label>
                                </div>
                                <div class="col-sm-9">
                                    <select id="product_id" class="form-control" name="product_id">
                                        <option value="">Select Product ID</option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('product_id')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <!-- Terminal ID Field -->
                            <div class="mb-1 row">
                                <div class="col-sm-3">
                                    <label class="col-form-label" for="terminal_id">Terminal ID<span style="color: red"> *
                                        </span></label>
                                </div>
                                <div class="col-sm-9">
                                    <select id="terminal_id" class="form-control" name="terminal_id">
                                        <option value="">Select Terminal ID</option>
                                        @foreach ($terminals as $terminal)
                                            <option value="{{ $terminal->id }}">{{ $terminal->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('terminal_id')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <!-- Provider Response ID Field -->
                            <div class="mb-1 row">
                                <div class="col-sm-3">
                                    <label class="col-form-label" for="provider_response_id">Provider Response ID<span
                                            style="color: red"> * </span></label>
                                </div>
                                <div class="col-sm-9">
                                    <select id="provider_response_id" class="form-control" name="provider_response_id">
                                        <option value="">Select Provider Response ID</option>
                                        @foreach ($providerResponses as $providerResponse)
                                            <option value="{{ $providerResponse->id }}">{{ $providerResponse->code }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('provider_response_id')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <!-- Format Field -->
                            <div class="mb-1 row">
                                <div class="col-sm-3">
                                    <label class="col-form-label" for="format">Format<span style="color: red"> *
                                        </span></label>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" id="format" class="form-control" name="format"
                                        placeholder="Format" value="{{ old('format') }}" />
                                    @error('format')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <!-- Status Field -->
                            <div class="mb-1 row">
                                <div class="col-sm-3">
                                    <label class="col-form-label" for="status">Status<span style="color: red"> *
                                        </span></label>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" id="status" class="form-control" name="status"
                                        placeholder="Status" value="{{ old('status') }}" />
                                    @error('status')
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
                    <table class="table table-hover" id="providersTable">
                        <thead>
                            <tr>
                                <th>Passing Provider Id</th>
                                <th>product</th>
                                <th>terminal</th>
                                <th>provider response</th>
                                <th>format</th>
                                <th>status</th>
                                <th>Actions</th>


                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($passingProviders as $passingProvider)
                                <tr data-id="{{ $passingProvider->id }}">
                                <td>{{ $passingProvider->id }}</td>

                                <td>{{ $passingProvider->product_id }}</td>
                                <td>{{ $passingProvider->terminal_id }}</td>
                                <td>{{ $passingProvider->provider_response_id }}</td>
                                <td>{{ $passingProvider->format }}</td>
                                <td>{{ $passingProvider->status }}</td>

                                <td>
                                    <form id="deleteForm" method="POST" action="{{ route('delete-passingProvider') }}" class="d-inline">
                                        @method('DELETE')
                                        @csrf
                                        <input type="text" name="provider_id" id="delete-providerResponse-id" hidden>
                                        <button type="button" class="btn-link" style="border: none; background: none; padding: 0; margin: 0;"
                                           onclick="confirmDelete({{ $passingProvider->id }})">
                                           <i data-feather="trash-2" class="me-50"></i>
                                        </button>
                                     </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{-- <div class="mx-1 d-flex justify-content-end">
                        <nav aria-label="Page navigation">
                            <ul class="pagination mt-2">
                                <li class="page-item prev"><a class="page-link"
                                        style="pointer-events: {{ $providers->currentPage() == 1 ? 'none' : '' }}"
                                        href="{{ $providers->url($providers->currentPage() - 1) }}"></a>
                                </li>
                                @for ($i = 1; $i <= $providers->lastPage(); $i++)
                                    <li class="page-item {{ $i == $providers->currentPage() ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $providers->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endfor
                                <li class="page-item next" disabled><a class="page-link"
                                        style="pointer-events: {{ $providers->currentPage() == $providers->lastPage() ? 'none' : '' }}"
                                        href="{{ $providers->url($providers->currentPage() + 1) }}"></a>
                                </li>
                            </ul>
                        </nav>
                    </div> --}}
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


    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function() {
            setTimeout(function() {
                $("#success-alert").alert('close');
            }, 3000);
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const nameInput = document.getElementById('passing_provider_id');
            const recordIdInput = document.getElementById('record_id');
            const dataTable = document.getElementById('providersTable');

            nameInput.addEventListener('input', function() {
                const name = this.value.toLowerCase();
                let recordId = '';

                Array.from(dataTable.querySelectorAll('tbody tr')).forEach(row => {
                    const rowDataName = row.cells[0].textContent.toLowerCase();
                    if (rowDataName === name) {
                        recordId = row.getAttribute('data-id');
                    }
                });

                recordIdInput.value = recordId;
            });
        });
    </script>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        function confirmDelete(providerId) {

            console.log(providerId);
            document.getElementById('delete-providerResponse-id').value = providerId;
            Swal.fire({
                title: 'Are you sure?',
                text: 'you wont be able to trwrive it',
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
