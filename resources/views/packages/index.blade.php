@extends('layouts/contentLayoutMaster')

@section('title', 'Package List')

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
                <form class="form form-horizontal" action="{{ route('update-or-create-package') }}" method="POST">
                    @csrf

                    <input type="hidden" name="id" id="record_id" value="">

                    <div class="row">

                        <div class="col-12">
                            <div class="mb-1 row">
                                <div class="col-sm-3">
                                    <label class="col-form-label" for="package_id">Package ID</label>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" id="package_id" class="form-control" name="package_id"
                                        placeholder="Search with Package Id" />
                                    @error('package_id')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>


                        <div class="col-12">
                            <div class="mb-1 row">
                                <div class="col-sm-3">
                                    <label class="col-form-label" for="regi_charge">Registration Charge</label>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" id="regi_charge" class="form-control" name="regi_charge"
                                        placeholder="Registration Charge" value="{{ old('regi_charge') }}" />
                                    @error('regi_charge')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Repeat the same structure for each field -->
                        <div class="col-12">
                            <div class="mb-1 row">
                                <div class="col-sm-3">
                                    <label class="col-form-label" for="regi_bonus">Registration Bonus</label>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" id="regi_bonus" class="form-control" name="regi_bonus"
                                        placeholder="Registration Bonus" value="{{ old('regi_bonus') }}" />
                                    @error('regi_bonus')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <!-- Repeat for all other fields as per the migration -->

                        <div class="col-12">
                            <div class="mb-1 row">
                                <div class="col-sm-3">
                                    <label class="col-form-label" for="regi_cashback">Registration Cashback</label>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" id="regi_cashback" class="form-control" name="regi_cashback"
                                        placeholder="Registration Cashback" value="{{ old('regi_cashback') }}" />
                                    @error('regi_cashback')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="mb-1 row">
                                <div class="col-sm-3">
                                    <label class="col-form-label" for="trans_charge">Transaction Charge</label>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" id="trans_charge" class="form-control" name="trans_charge"
                                        placeholder="Transaction Charge" value="{{ old('trans_charge') }}" />
                                    @error('trans_charge')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="mb-1 row">
                                <div class="col-sm-3">
                                    <label class="col-form-label" for="trans_bonus">Transaction Bonus</label>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" id="trans_bonus" class="form-control" name="trans_bonus"
                                        placeholder="Transaction Bonus" value="{{ old('trans_bonus') }}" />
                                    @error('trans_bonus')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="mb-1 row">
                                <div class="col-sm-3">
                                    <label class="col-form-label" for="charge_free_trans">Charge Free Transactions</label>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" id="charge_free_trans" class="form-control"
                                        name="charge_free_trans" placeholder="Charge Free Transactions"
                                        value="{{ old('charge_free_trans') }}" />
                                    @error('charge_free_trans')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="mb-1 row">
                                <div class="col-sm-3">
                                    <label class="col-form-label" for="daily_charge">Daily Charge</label>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" id="daily_charge" class="form-control" name="daily_charge"
                                        placeholder="Daily Charge" value="{{ old('daily_charge') }}" />
                                    @error('daily_charge')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="mb-1 row">
                                <div class="col-sm-3">
                                    <label class="col-form-label" for="daily_bonus">Daily Bonus</label>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" id="daily_bonus" class="form-control" name="daily_bonus"
                                        placeholder="Daily Bonus" value="{{ old('daily_bonus') }}" />
                                    @error('daily_bonus')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="mb-1 row">
                                <div class="col-sm-3">
                                    <label class="col-form-label" for="refer_plan">Referral Plan</label>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" id="refer_plan" class="form-control" name="refer_plan"
                                        placeholder="Referral Plan" value="{{ old('refer_plan') }}" />
                                    @error('refer_plan')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="mb-1 row">
                                <div class="col-sm-3">
                                    <label class="col-form-label" for="stock_limit">Stock Limit</label>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" id="stock_limit" class="form-control" name="stock_limit"
                                        placeholder="Stock Limit" value="{{ old('stock_limit') }}" />
                                    @error('stock_limit')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="mb-1 row">
                                <div class="col-sm-3">
                                    <label class="col-form-label" for="withdraw_limit">Withdraw Limit</label>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" id="withdraw_limit" class="form-control" name="withdraw_limit"
                                        placeholder="Withdraw Limit" value="{{ old('withdraw_limit') }}" />
                                    @error('withdraw_limit')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="mb-1 row">
                                <div class="col-sm-3">
                                    <label class="col-form-label" for="offline_requ">Offline Requests</label>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" id="offline_requ" class="form-control" name="offline_requ"
                                        placeholder="Online Requests" value="{{ old('offline_requ') }}" />
                                    @error('offline_requ')
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

                <div class="card-body">
                    <form action="#" method="get">
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                                data-bs-target="#createUser">Configure Package</button>
                        </div>
                    </form>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover" id="providersTable">
                        <thead>
                            <tr>
                                <th>Package ID</th>
                                <th>Registration Charge</th>
                                <th>Registration Bonus</th>
                                <th>Registration Cashback</th>
                                <th>Transaction Charge</th>
                                <th>Transaction Bonus</th>
                                <th>Charge Free Transactions</th>
                                <th>Daily Charge</th>
                                <th>Daily Bonus</th>
                                <th>Referral Plan</th>
                                <th>Stock Limit</th>
                                <th>Withdraw Limit</th>
                                <th>Offline Requests</th>
                                <th>Actions</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($packages as $package)
                                <tr data-id="{{ $package->id }}">
                                    <td>{{ $package->id }}</td>
                                    <td>{{ $package->regi_charge }}</td>
                                    <td>{{ $package->regi_bonus }}</td>
                                    <td>{{ $package->regi_cashback }}</td>
                                    <td>{{ $package->trans_charge }}</td>
                                    <td>{{ $package->trans_bonus }}</td>
                                    <td>{{ $package->charge_free_trans }}</td>
                                    <td>{{ $package->daily_charge }}</td>
                                    <td>{{ $package->daily_bonus }}</td>
                                    <td>{{ $package->refer_plan }}</td>
                                    <td>{{ $package->stock_limit }}</td>
                                    <td>{{ $package->withdraw_limit }}</td>
                                    <td>{{ $package->offline_requ }}</td>
                                    <td>


                                        <form id="deleteForm" method="POST" action="{{ route('delete-package') }}"
                                            class="d-inline">
                                            @method('DELETE')
                                            @csrf
                                            <input type="text" name="package_id" id="delete-package-id" hidden>
                                            <button type="button" class="btn-link"
                                                style="border: none; background: none; padding: 0; margin: 0;"
                                                onclick="confirmDelete({{ $package->id }})">
                                                <i data-feather="trash-2" class="me-50"></i>
                                            </button>
                                        </form>

                                        <form action="#" method="get" class="d-inline">
                                            <button type="button" class="btn-link" data-bs-toggle="modal"
                                                style="border: none; background: none; padding: 0; margin: 0;"
                                                data-bs-target={{ '#configure-package-' . $package->id }}>
                                                <i data-feather="edit-2" class="me-50"></i>
                                            </button>
                                        </form>
                                        <div class="modal fade" id={{ 'configure-package-' . $package->id }}
                                            tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-transparent">
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body pb-5 px-sm-5 pt-50">
                                                        <div class="text-center mb-2">
                                                            <h1 class="mb-1">Configure Package</h1>
                                                        </div>

                                                        <div class="card-body">

                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <div class="mb-1 row border rounded p-1">
                                                                        <div class="col-sm-3">
                                                                            <label class="col-form-label">Product Configure
                                                                                <span style="color: red"> * </span></label>
                                                                        </div>
                                                                        <div class="col-sm-9">
                                                                            <form
                                                                                action="{{ route('product-configure') }}"
                                                                                method="POST">
                                                                                @csrf
                                                                                <input type="hidden" name="package_id"
                                                                                    value="{{ $package->id }}">
                                                                                @foreach ($products as $product)
                                                                                    <div class="form-check mb-3">
                                                                                        <div
                                                                                            class="row align-items-center">
                                                                                            <input class="form-check-input"
                                                                                                type="hidden"
                                                                                                id="product-id-{{ $product->id }}"
                                                                                                name="products[{{ $product->id }}][product_id]"
                                                                                                value="{{ $product->id }}">

                                                                                            <input class="form-check-input"
                                                                                                type="hidden"
                                                                                                id="package-id{{ $product->id }}"
                                                                                                name="products[{{ $product->id }}][package_id]"
                                                                                                value="{{ $package->id }}">
                                                                                            <div class="col-sm-1">
                                                                                                <input
                                                                                                    class="form-check-input"
                                                                                                    type="checkbox"
                                                                                                    id="product-{{ $product->id }}"
                                                                                                    name="products[{{ $product->id }}][selected]"
                                                                                                    value="1">
                                                                                            </div>
                                                                                            <div class="col-sm-3">
                                                                                                <label
                                                                                                    class="form-check-label"
                                                                                                    for="product-{{ $product->id }}">
                                                                                                    {{ $product->name . ', ' . $product->code }}
                                                                                                </label>
                                                                                            </div>
                                                                                            <div class="col-sm-4">
                                                                                                <input type="text"
                                                                                                    class="form-control"
                                                                                                    id="commission-{{ $product->id }}"
                                                                                                    name="products[{{ $product->id }}][commission]"
                                                                                                    placeholder="Commission">
                                                                                            </div>
                                                                                            <div class="col-sm-4">
                                                                                                <input type="text"
                                                                                                    class="form-control"
                                                                                                    id="charge-{{ $product->id }}"
                                                                                                    name="products[{{ $product->id }}][charge]"
                                                                                                    placeholder="Charge">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                @endforeach
                                                                                <button type="submit"
                                                                                    class="btn btn-primary">Submit
                                                                                </button>
                                                                            </form>
                                                                            @if ($errors->any())
                                                                                <div class="text-danger mt-3">
                                                                                    <ul>
                                                                                        @foreach ($errors->all() as $error)
                                                                                            <li>{{ $error }}</li>
                                                                                        @endforeach
                                                                                    </ul>
                                                                                </div>
                                                                            @endif
                                                                        </div>
                                                                    </div>

                                                                    <div class="mb-1 row border rounded p-1">
                                                                        <div class="col-sm-3">
                                                                            <label class="col-form-label">Add balance
                                                                                <span style="color: red"> * </span></label>
                                                                        </div>
                                                                        <div class="col-sm-9">
                                                                            <form
                                                                                action="{{ route('add-balance') }}"
                                                                                method="POST">
                                                                                @csrf
                                                                                <input type="hidden" name="package_id"
                                                                                    value="{{ $package->id }}">
                                                                                @foreach ($gateways as $gateway)
                                                                                    <div class="form-check mb-3">
                                                                                        <div
                                                                                            class="row align-items-center">
                                                                                            <input class="form-check-input"
                                                                                                type="hidden"
                                                                                                name="gateways[{{ $gateway->id }}][package_id]"
                                                                                                value="{{ $package->id }}">

                                                                                            <input class="form-check-input"
                                                                                                type="hidden"
                                                                                                name="gateways[{{ $gateway->id }}][gateway_id]"
                                                                                                value="{{$gateway->id }}">


                                                                                            <div class="col-sm-1">
                                                                                                <input
                                                                                                    class="form-check-input"
                                                                                                    type="checkbox"
                                                                                                    id="gateway-{{ $gateway->id }}"
                                                                                                    name="gateways[{{ $gateway->id }}][selected]"
                                                                                                    value="1">
                                                                                            </div>
                                                                                            <div class="col-sm-3">
                                                                                                <label
                                                                                                    class="form-check-label"
                                                                                                    for="gateway-{{ $gateway->id }}">
                                                                                                    {{ $gateway->gateway_name . ', ' . $gateway->gateway_code }}
                                                                                                </label>
                                                                                            </div>


                                                                                            <div class="col-sm-4">
                                                                                                <input type="text"
                                                                                                    class="form-control"
                                                                                                    id="commission-{{ $gateway->id }}"
                                                                                                    name="gateways[{{ $gateway->id }}][commission]"
                                                                                                    placeholder="Commission">
                                                                                            </div>
                                                                                            <div class="col-sm-4">
                                                                                                <input type="text"
                                                                                                    class="form-control"
                                                                                                    id="charge-{{ $gateway->id }}"
                                                                                                    name="gateways[{{ $gateway->id }}][charge]"
                                                                                                    placeholder="Charge">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                @endforeach
                                                                                <button type="submit"
                                                                                    class="btn btn-primary">Submit
                                                                                </button>
                                                                            </form>
                                                                            @if ($errors->any())
                                                                                <div class="text-danger mt-3">
                                                                                    <ul>
                                                                                        @foreach ($errors->all() as $error)
                                                                                            <li>{{ $error }}</li>
                                                                                        @endforeach
                                                                                    </ul>
                                                                                </div>
                                                                            @endif
                                                                        </div>
                                                                    </div>

                                                                    <div class="mb-1 row border rounded p-1">
                                                                        <div class="col-sm-3">
                                                                            <label class="col-form-label">Withdraw Credit
                                                                                <span style="color: red"> * </span></label>
                                                                        </div>
                                                                        <div class="col-sm-9">
                                                                            <form
                                                                                action="{{ route('withdraw-credit') }}"
                                                                                method="POST">
                                                                                @csrf
                                                                                <input type="hidden" name="package_id"
                                                                                    value="{{ $package->id }}">
                                                                                @foreach ($methods as $method)
                                                                                    <div class="form-check mb-3">
                                                                                        <div
                                                                                            class="row align-items-center">
                                                                                            <input class="form-check-input"
                                                                                                type="hidden"
                                                                                                name="methods[{{ $method->id }}][package_id]"
                                                                                                value="{{ $package->id }}">

                                                                                            <input class="form-check-input"
                                                                                                type="hidden"
                                                                                                name="methods[{{ $method->id }}][method_id]"
                                                                                                value="{{$method->id }}">


                                                                                            <div class="col-sm-1">
                                                                                                <input
                                                                                                    class="form-check-input"
                                                                                                    type="checkbox"
                                                                                                    id="method-{{ $method->id }}"
                                                                                                    name="methods[{{ $method->id }}][selected]"
                                                                                                    value="1">
                                                                                            </div>
                                                                                            <div class="col-sm-3">
                                                                                                <label
                                                                                                    class="form-check-label"
                                                                                                    for="method-{{ $method->id }}">
                                                                                                    {{ $method->method_name . ', ' . $method->method_code }}
                                                                                                </label>
                                                                                            </div>


                                                                                            <div class="col-sm-4">
                                                                                                <input type="text"
                                                                                                    class="form-control"
                                                                                                    id="commission-{{ $method->id }}"
                                                                                                    name="methods[{{ $method->id }}][commission]"
                                                                                                    placeholder="Commission">
                                                                                            </div>
                                                                                            <div class="col-sm-4">
                                                                                                <input type="text"
                                                                                                    class="form-control"
                                                                                                    id="charge-{{ $method->id }}"
                                                                                                    name="methods[{{ $method->id }}][charge]"
                                                                                                    placeholder="Charge">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                @endforeach
                                                                                <button type="submit"
                                                                                    class="btn btn-primary">Submit
                                                                                </button>
                                                                            </form>
                                                                            @if ($errors->any())
                                                                                <div class="text-danger mt-3">
                                                                                    <ul>
                                                                                        @foreach ($errors->all() as $error)
                                                                                            <li>{{ $error }}</li>
                                                                                        @endforeach
                                                                                    </ul>
                                                                                </div>
                                                                            @endif
                                                                        </div>
                                                                    </div>

                                                                    <div class="mb-1 row border rounded p-1">
                                                                        <div class="col-sm-3">
                                                                            <label class="col-form-label">Drive Commission
                                                                                <span style="color: red"> * </span></label>
                                                                        </div>
                                                                        <div class="col-sm-9">
                                                                            <form
                                                                                action="{{ route('drive-commission') }}"
                                                                                method="POST">
                                                                                @csrf
                                                                                <input type="hidden" name="package_id"
                                                                                    value="{{ $package->id }}">
                                                                                @foreach ($drives as $drive)
                                                                                    <div class="form-check mb-3">
                                                                                        <div
                                                                                            class="row align-items-center">
                                                                                            <input class="form-check-input"
                                                                                                type="hidden"
                                                                                                name="drives[{{ $drive->id }}][package_id]"
                                                                                                value="{{ $package->id }}">

                                                                                            <input class="form-check-input"
                                                                                                type="hidden"
                                                                                                name="drives[{{ $drive->id }}][drive_id]"
                                                                                                value="{{$drive->id }}">


                                                                                            <div class="col-sm-1">
                                                                                                <input
                                                                                                    class="form-check-input"
                                                                                                    type="checkbox"
                                                                                                    id="drive-{{ $drive->id }}"
                                                                                                    name="drives[{{ $drive->id }}][selected]"
                                                                                                    value="1">
                                                                                            </div>
                                                                                            <div class="col-sm-3">
                                                                                                <label
                                                                                                    class="form-check-label"
                                                                                                    for="drive-{{ $drive->id }}">
                                                                                                    {{ $drive->range . ', ' . $drive->code }}
                                                                                                </label>
                                                                                            </div>


                                                                                            <div class="col-sm-4">
                                                                                                <input type="text"
                                                                                                    class="form-control"
                                                                                                    id="commission-{{ $drive->id }}"
                                                                                                    name="drives[{{ $drive->id }}][commission]"
                                                                                                    placeholder="Commission">
                                                                                            </div>
                                                                                            <div class="col-sm-4">
                                                                                                <input type="text"
                                                                                                    class="form-control"
                                                                                                    id="charge-{{ $drive->id }}"
                                                                                                    name="drives[{{ $drive->id }}][charge]"
                                                                                                    placeholder="Charge">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                @endforeach
                                                                                <button type="submit"
                                                                                    class="btn btn-primary">Submit
                                                                                </button>
                                                                            </form>
                                                                            @if ($errors->any())
                                                                                <div class="text-danger mt-3">
                                                                                    <ul>
                                                                                        @foreach ($errors->all() as $error)
                                                                                            <li>{{ $error }}</li>
                                                                                        @endforeach
                                                                                    </ul>
                                                                                </div>
                                                                            @endif
                                                                        </div>
                                                                    </div>

                                                                    <div class="mb-1 row border rounded p-1">
                                                                        <div class="col-sm-3">
                                                                            <label class="col-form-label">Balance Bonus
                                                                                <span style="color: red"> * </span></label>
                                                                        </div>
                                                                        <div class="col-sm-9">
                                                                            <form
                                                                                action="{{ route('balance-bonus') }}"
                                                                                method="POST">
                                                                                @csrf
                                                                                <input type="hidden" name="package_id"
                                                                                    value="{{ $package->id }}">
                                                                                @foreach ($balances as $balance)
                                                                                    <div class="form-check mb-3">
                                                                                        <div
                                                                                            class="row align-items-center">
                                                                                            <input class="form-check-input"
                                                                                                type="hidden"
                                                                                                name="balances[{{ $balance->id }}][package_id]"
                                                                                                value="{{ $package->id }}">

                                                                                            <input class="form-check-input"
                                                                                                type="hidden"
                                                                                                name="balances[{{ $balance->id }}][balance_id]"
                                                                                                value="{{$balance->id }}">


                                                                                            <div class="col-sm-1">
                                                                                                <input
                                                                                                    class="form-check-input"
                                                                                                    type="checkbox"
                                                                                                    id="balances-{{ $balance->id }}"
                                                                                                    name="balances[{{ $balance->id }}][selected]"
                                                                                                    value="1">
                                                                                            </div>
                                                                                            <div class="col-sm-3">
                                                                                                <label
                                                                                                    class="form-check-label"
                                                                                                    for="balance-{{ $balance->id }}">
                                                                                                    {{ $balance->range . ', ' . $balance->code }}
                                                                                                </label>
                                                                                            </div>


                                                                                            <div class="col-sm-4">
                                                                                                <input type="text"
                                                                                                    class="form-control"
                                                                                                    id="commission-{{ $balance->id }}"
                                                                                                    name="balances[{{ $balance->id }}][commission]"
                                                                                                    placeholder="Commission">
                                                                                            </div>
                                                                                            <div class="col-sm-4">
                                                                                                <input type="text"
                                                                                                    class="form-control"
                                                                                                    id="charge-{{ $balance->id }}"
                                                                                                    name="balances[{{ $balance->id }}][charge]"
                                                                                                    placeholder="Charge">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                @endforeach
                                                                                <button type="submit"
                                                                                    class="btn btn-primary">Submit
                                                                                </button>
                                                                            </form>
                                                                            @if ($errors->any())
                                                                                <div class="text-danger mt-3">
                                                                                    <ul>
                                                                                        @foreach ($errors->all() as $error)
                                                                                            <li>{{ $error }}</li>
                                                                                        @endforeach
                                                                                    </ul>
                                                                                </div>
                                                                            @endif
                                                                        </div>
                                                                    </div>

                                                                </div>



                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{-- <div class="mx-1 d-flex justify-content-end">
                        <nav aria-label="Page navigation">
                            <ul class="pagination mt-2">
                                <li class="page-item prev"><a class="page-link"
                                        style="pointer-events: {{ $package->currentPage() == 1 ? 'none' : '' }}"
                                        href="{{ $package->url($package->currentPage() - 1) }}"></a>
                                </li>
                                @for ($i = 1; $i <= $package->lastPage(); $i++)
                                    <li class="page-item {{ $i == $providers->currentPage() ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $package->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endfor
                                <li class="page-item next" disabled><a class="page-link"
                                        style="pointer-events: {{ $package->currentPage() == $package->lastPage() ? 'none' : '' }}"
                                        href="{{ $package->url($package->currentPage() + 1) }}"></a>
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
            const nameInput = document.getElementById('package_id');
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

    document.addEventListener('DOMContentLoaded', function() {

        @if(session('openModal'))
            var packageId = "{{ session('packageId') }}";
            console.log(packageId);
            $('#configure-package-' + packageId).modal('show');
        @endif
    });
    </script>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        function confirmDelete(packageId) {

            document.getElementById('delete-package-id').value = packageId;
            Swal.fire({
                title: 'Are you sure?',
                text: 'If you delete the provider, any product or offer of this provider will be deleted!',
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
