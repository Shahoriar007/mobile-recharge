@extends('layouts/contentLayoutMaster')

@section('title', 'Provider Response List')

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
                <form class="form form-horizontal" action="{{ route('update-or-create-providerResponse') }}" method="POST">
                    @csrf

                    <input type="hidden" name="id" id="record_id" value="">

                    <div class="row">
                        <div class="col-12">
                            <div class="mb-1 row">
                                <div class="col-sm-3">
                                    <label class="col-form-label" for="code">Code<span style="color: red"> * </span></label>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" id="code" class="form-control" name="code"
                                        placeholder="Code"  />
                                    @error('code')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="mb-1 row">
                                <div class="col-sm-3">
                                    <label class="col-form-label" for="before_balance">Before Balance<span style="color: red"> * </span></label>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text"  id="before_balance" class="form-control" name="before_balance"
                                        placeholder="Before Balance"  />
                                    @error('before_balance')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="mb-1 row">
                                <div class="col-sm-3">
                                    <label class="col-form-label" for="before_amount">Before Amount<span style="color: red"> * </span></label>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text"  id="before_amount" class="form-control" name="before_amount"
                                        placeholder="Before Amount"  />
                                    @error('before_amount')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="mb-1 row">
                                <div class="col-sm-3">
                                    <label class="col-form-label" for="after_balance">After Balance<span style="color: red"> * </span></label>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text"  id="after_balance" class="form-control" name="after_balance"
                                        placeholder="After Balance"  />
                                    @error('after_balance')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="mb-1 row">
                                <div class="col-sm-3">
                                    <label class="col-form-label" for="after_amount">After Amount<span style="color: red"> * </span></label>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text"  id="after_amount" class="form-control" name="after_amount"
                                        placeholder="After Amount"  />
                                    @error('after_amount')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="mb-1 row">
                                <div class="col-sm-3">
                                    <label class="col-form-label" for="before_trans_code">Before trans_code<span style="color: red"> * </span></label>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text"  id="before_trans_code" class="form-control" name="before_trans_code"
                                        placeholder="Before trans_code"  />
                                    @error('before_trans_code')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="mb-1 row">
                                <div class="col-sm-3">
                                    <label class="col-form-label" for="after_trans_code">After Trans Code<span style="color: red"> * </span></label>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text"  id="after_trans_code" class="form-control" name="after_trans_code"
                                        placeholder="After Trans Code"  />
                                    @error('after_trans_code')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="mb-1 row">
                                <div class="col-sm-3">
                                    <label class="col-form-label" for="must_include"> must_include<span style="color: red"> * </span></label>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text"  id="must_include" class="form-control" name="must_include"
                                        placeholder="must_include"  />
                                    @error('must_include')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>



                        <div class="col-12">
                            <div class="mb-1 row">
                                <div class="col-sm-3">
                                    <label class="col-form-label" for="feedback">FeedBack<span style="color: red"> * </span></label>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text"  id="feedback" class="form-control" name="feedback"
                                        placeholder="Feedback"  />
                                    @error('feedback')
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
                                <th>Code</th>
                                <th>Before Balance</th>
                                <th>After Balance</th>
                                <th>Before Amount</th>
                                <th>After Amount</th>
                                <th>Before Transaction Code</th>
                                <th>After Transaction Code</th>
                                <th>Must Include</th>
                                <th>Feedback</th>
                                <th>Actions</th>


                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($providerResponses as $providerResponse)
                            <tr data-id="{{ $providerResponse->id }}">
                                <td>{{ $providerResponse->code }}</td>
                                <td>{{ $providerResponse->before_balance }}</td>
                                <td>{{ $providerResponse->after_balance }}</td>
                                <td>{{ $providerResponse->before_amount }}</td>
                                <td>{{ $providerResponse->after_amount }}</td>
                                <td>{{ $providerResponse->before_trans_code }}</td>
                                <td>{{ $providerResponse->after_trans_code }}</td>
                                <td>{{ $providerResponse->must_include }}</td>
                                <td>{{ $providerResponse->feedback }}</td>

                                <td>
                                    <form id="deleteForm" method="POST" action="{{ route('delete-providerResponse') }}" class="d-inline">
                                        @method('DELETE')
                                        @csrf
                                        <input type="text" name="provider_id" id="delete-providerResponse-id" hidden>
                                        <button type="button" class="btn-link" style="border: none; background: none; padding: 0; margin: 0;"
                                           onclick="confirmDelete({{ $providerResponse->id }})">
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
        $(document).ready(function(){
            setTimeout(function(){
                $("#success-alert").alert('close');
            }, 3000);
        });
    </script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const nameInput = document.getElementById('code');
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
