@extends('layouts/contentLayoutMaster')

@section('title', 'Terminal List')

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
                <form class="form form-horizontal" action="{{ route('update-or-create-terminal') }}" method="POST">
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
                                    <label class="col-form-label" for="user">User(API)<span style="color: red"> * </span></label>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" id="user" class="form-control" name="user"
                                        placeholder="user"  />
                                    @error('user')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="mb-1 row">
                                <div class="col-sm-3">
                                    <label class="col-form-label" for="password">Password(API)<span style="color: red"> * </span></label>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" id="password" class="form-control" name="password"
                                        placeholder="password"  />
                                    @error('password')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-1 row">
                                <div class="col-sm-3">
                                    <label class="col-form-label" for="amount">Amount<span style="color: red"> * </span></label>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" id="amount" class="form-control" name="amount"
                                        placeholder="amount" value="{{ old('amount') }}" />
                                    @error('amount')
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
                                        <option value="default">Default</option>
                                        <option value="partial">Partial</option>
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
                                        <option value="" disabled selected>Select Status</option>
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
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
                    <table class="table table-hover" id="productsTable">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Code</th>
                                <th>amount</th>
                                <th>User</th>
                                <th>password</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th>Actions</th>

                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($terminals as $terminal)
                            <tr data-id="{{ $terminal->id }}">
                                <td>{{ $terminal->name }}</td>
                                <td>{{ $terminal->code }}</td>
                                <td>{{ $terminal->amount }}</td>
                                <td>{{ $terminal->user }}</td>
                                <td>{{ $terminal->password }}</td>
                                <td>{{ $terminal->category }}</td>
                                <td>{{ $terminal->status }}</td>
                                <td>
                                    <form id="deleteForm" method="POST" action="{{ route('delete-terminal') }}" class="d-inline">
                                        @method('DELETE')
                                        @csrf
                                        <input type="text" name="terminal_id" id="delete-terminal-id" hidden>
                                        <button type="button" class="btn-link" style="border: none; background: none; padding: 0; margin: 0;"
                                           onclick="confirmDelete({{ $terminal->id }})">
                                           <i data-feather="trash-2" class="me-50"></i>
                                        </button>
                                     </form>                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{-- <div class="mx-1 d-flex justify-content-end">
                        <nav aria-label="Page navigation">
                            <ul class="pagination mt-2">
                                <li class="page-item prev"><a class="page-link"
                                        style="pointer-events: {{ $products->currentPage() == 1 ? 'none' : '' }}"
                                        href="{{ $products->url($products->currentPage() - 1) }}"></a>
                                </li>
                                @for ($i = 1; $i <= $products->lastPage(); $i++)
                                    <li class="page-item {{ $i == $products->currentPage() ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $products->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endfor
                                <li class="page-item next" disabled><a class="page-link"
                                        style="pointer-events: {{ $products->currentPage() == $products->lastPage() ? 'none' : '' }}"
                                        href="{{ $products->url($products->currentPage() + 1) }}"></a>
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
        const dataTable = document.getElementById('productsTable');

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
        function confirmDelete(terminalId) {

            console.log(terminalId);
            document.getElementById('delete-terminal-id').value = terminalId;
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
