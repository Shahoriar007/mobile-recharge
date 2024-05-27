@extends('layouts/contentLayoutMaster')

@section('title', 'Provider List')

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
                <form class="form form-horizontal" action="{{ route('update-or-create-provider') }}" method="POST">
                    @csrf

                    <input type="hidden" name="id" id="record_id" value="">

                    <div class="row">
                        <div class="col-12">
                            <div class="mb-1 row">
                                <div class="col-sm-3">
                                    <label class="col-form-label" for="name">Name<span style="color: red"> * </span></label>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" id="name" class="form-control" name="name"
                                        placeholder="Name"  required/>
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-1 row">
                                <div class="col-sm-3">
                                    <label class="col-form-label" for="code">Code<span style="color: red"> * </span></label>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" id="code" class="form-control" name="code"
                                        placeholder="Code" value="{{ old('code') }}" />
                                    @error('code')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-1 row">
                                <div class="col-sm-3">
                                    <label class="col-form-label" for="length">Length<span style="color: red"> * </span></label>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" id="length" class="form-control" name="length"
                                        placeholder="length" value="{{ old('length') }}" />
                                    @error('length')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="mb-1 row">
                                <div class="col-sm-3">
                                    <label class="col-form-label" for="category">Category<span style="color: red"> * </span></label>
                                </div>
                                <div class="col-sm-9">
                                    <select id="category" class="form-control" name="category" >
                                        <option value="" disabled selected>Select category</option>
                                        <option value="recharge">Recharge</option>
                                        <option value="drive">Drive</option>
                                        <option value="bill">Bill</option>
                                        <option value="withdraw">Withdraw</option>
                                    </select>
                                    @error('category')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                        </div>


                        <div class="col-12">
                            <div class="mb-1 row">
                                <div class="col-sm-3">
                                    <label class="col-form-label" for="status">Status<span style="color: red"> * </span></label>
                                </div>
                                <div class="col-sm-9">
                                    <select id="status" class="form-control" name="status" >
                                        <option value="" disabled selected>Select category</option>
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                        <option value="net_problem">Net Problem</option>
                                        <option value="stock_out">Stock Out</option>
                                    </select>
                                    @error('status')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                        </div>



                        <div class="col-12">
                            <div class="mb-1 row">
                                <div class="col-sm-3">
                                    <label class="col-form-label" for="prefix">prefix<span style="color: red"> * </span></label>
                                </div>
                                <div class="col-sm-9">
                                    <div class="input-group input-group-merge form-prefix-toggle">
                                        <input class="form-control form-control-merge" id="prefix"
                                            type="prefix" name="prefix" placeholder="Prefix"
                                            aria-describedby="prefix" tabindex="2" />
                                        <span class="input-group-text cursor-pointer"><i
                                                data-feather="eye"></i></span>
                                    </div>
                                    @error('prefix')
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
                                <th>Name</th>
                                <th>Code</th>
                                <th>Length</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th>Prefix</th>
                                <th>Actions</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($providers as $provider)
                            <tr data-id="{{ $provider->id }}">
                                <td>{{ $provider->name }}</td>
                                <td>{{ $provider->code }}</td>
                                <td>{{ $provider->length }}</td>
                                <td>{{ $provider->category }}</td>
                                <td>{{ $provider->status }}</td>
                                <td>{{ $provider->prefix }}</td>
                                <td>
                                    <!-- Add action buttons here if needed -->
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mx-1 d-flex justify-content-end">
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


    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function(){
            setTimeout(function(){
                $("#success-alert").alert('close');
            }, 3000);
        });
    </script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const nameInput = document.getElementById('name');
        const recordIdInput = document.getElementById('record_id');
        const dataTable = document.getElementById('providersTable');

        nameInput.addEventListener('input', function () {
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
        function confirmDelete(userId) {

            console.log(userId);
            document.getElementById('delete-user-id').value = userId;
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
