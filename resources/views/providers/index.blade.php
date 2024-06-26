@extends('layouts/contentLayoutMaster')

@section('title', 'User List')

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
                <form class="form form-horizontal" action="{{ route('create-user') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-1 row">
                                <div class="col-sm-3">
                                    <label class="col-form-label" for="first-name">Name<span style="color: red"> * </span></label>
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
                                    <label class="col-form-label" for="email-id">Email<span style="color: red"> * </span></label>
                                </div>
                                <div class="col-sm-9">
                                    <input type="email" id="email" class="form-control" name="email"
                                        placeholder="Email" value="{{ old('email') }}" required/>
                                    @error('email')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-1 row">
                                <div class="col-sm-3">
                                    <label class="col-form-label" for="phn-id">Phone Number<span style="color: red"> * </span></label>
                                </div>
                                <div class="col-sm-9">
                                    <input type="number" id="phn" class="form-control" name="phone"
                                        placeholder="phone number" value="{{ old('phone') }}" required/>
                                    @error('number')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>


                        <div class="col-12">
                            <div class="mb-1 row">
                                <div class="col-sm-3">
                                    <label class="col-form-label" for="password">Password<span style="color: red"> * </span></label>
                                </div>
                                <div class="col-sm-9">
                                    <div class="input-group input-group-merge form-password-toggle">
                                        <input class="form-control form-control-merge" id="login-password"
                                            type="password" name="password" placeholder="············"
                                            aria-describedby="login-password" tabindex="2" required/>
                                        <span class="input-group-text cursor-pointer"><i
                                                data-feather="eye"></i></span>
                                    </div>
                                    @error('password')
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
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone Number</th>
                                <th>Created at</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>
                                        <span class="fw-bold">
                                            {{ $user->name }}
                                        </span>
                                    </td>
                                    <td>
                                        {{ $user->email }}
                                    </td>
                                    <td>
                                        <span>
                                            {{ $user->phone }}
                                        </span>
                                    </td>

                                    <td>{{ \Carbon\Carbon::parse($user->created_at)->format('d M Y H:ia') }}</td>
                                    <td>

                                        {{-- <a class="" href="#">
                                            <i data-feather="eye" class="me-50"></i>
                                        </a> --}}

                                        <a href="#" class="edit-user" data-bs-toggle="modal"
                                            data-bs-target="#editUser" data-user-id="{{ $user->id }}">
                                            <i data-feather="edit-2" class="me-50"></i>
                                        </a>

                                        <form id="deleteForm" method="POST" action="{{ route('delete-user') }}" class="d-inline">
                                            @method('DELETE')
                                            @csrf
                                            <input type="text" name="user_id" id="delete-user-id" hidden>
                                            <button type="button" class="btn-link" style="border: none; background: none; padding: 0; margin: 0;"
                                               onclick="confirmDelete({{ $user->id }})">
                                               <i data-feather="trash-2" class="me-50"></i>
                                            </button>
                                         </form>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mx-1 d-flex justify-content-end">
                        <nav aria-label="Page navigation">
                            <ul class="pagination mt-2">
                                <li class="page-item prev"><a class="page-link"
                                        style="pointer-events: {{ $users->currentPage() == 1 ? 'none' : '' }}"
                                        href="{{ $users->url($users->currentPage() - 1) }}"></a>
                                </li>
                                @for ($i = 1; $i <= $users->lastPage(); $i++)
                                    <li class="page-item {{ $i == $users->currentPage() ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $users->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endfor
                                <li class="page-item next" disabled><a class="page-link"
                                        style="pointer-events: {{ $users->currentPage() == $users->lastPage() ? 'none' : '' }}"
                                        href="{{ $users->url($users->currentPage() + 1) }}"></a>
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const editLinks = document.querySelectorAll('.edit-user');

            editLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const userId = this.dataset.userId;

                    const editForm = document.getElementById('edit-user-form');
                    editForm.action = `/users/${userId}`;

                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken;

                    axios.get(`/users/${userId}/edit`)
                        .then(response => {

                            const userData = response.data;

                            document.getElementById('first-name').value = userData.name;
                            document.getElementById('email-id').value = userData.email;
                            document.getElementById('phn-id').value = userData.phone;
                        })
                        .catch(error => {
                            console.error('Error fetching user data', error);
                        });
                });
            });
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function(){
            setTimeout(function(){
                $("#success-alert").alert('close');
            }, 3000);
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
