@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Reports'])
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12 mb-4">
                <div class="card">
                    <div class="card-body p-2 px-0 pt-3">
                        <form id="filter-download-form" method="GET" action="{{ url('reports') }}" onsubmit="return validateDates()">
                            <div class="row mx-3 mb-3">
                                <div class="row">
                                    <!-- Date Filters -->
                                    <div class="col-md-4">
                                        <p class="font-weight-bold mb-1">Start Date</p>
                                        <input type="date" name="start_date" id="start_date" class="form-control" placeholder="Start Date" value="{{ request()->get('start_date') }}">
                                    </div>
                                    <div class="col-md-4">
                                        <p class="font-weight-bold mb-1">End Date</p>
                                        <input type="date" name="end_date" id="end_date" class="form-control" placeholder="End Date" value="{{ request()->get('end_date') }}">
                                    </div>
                                    <div class="col-md-2 d-flex align-items-end">
                                        <button type="button" class="btn btn-secondary mb-0 px-5" onclick="clearDates()">Clear</button>
                                    </div>
                                </div>
                                <div id="start_date_error" class="text-danger mt-1 text-sm"></div> <!-- Error message div -->

                                <!-- Column Selection -->
                                <div class="col-md-12 mt-2">
                                    <p class="font-weight-bold mb-1">Select Columns to Download</p>
                                    <div class="row" id="specific-container">
                                        <div class="col-md-3">
                                            
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="columns[]" value="name" id="name">
                                                <label class="form-check-label" for="name">Name</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="columns[]" value="phone_number" id="phone_number">
                                                <label class="form-check-label" for="phone_number">Phone Number</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="columns[]" value="email" id="email">
                                                <label class="form-check-label" for="email">Email</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="columns[]" value="nationality" id="nationality">
                                                <label class="form-check-label" for="nationality">Nationality</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="columns[]" value="visitor" id="visitor">
                                                <label class="form-check-label" for="visitor">Visitor</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="columns[]" value="hostelry" id="hostelry">
                                                <label class="form-check-label" for="hostelry">Hostelry</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="columns[]" value="title" id="title">
                                                <label class="form-check-label" for="title">Ticket</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="columns[]" value="qty_ticket" id="qty_ticket">
                                                <label class="form-check-label" for="qty_ticket">Qty Ticket</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="columns[]" value="price_ticket" id="price_ticket">
                                                <label class="form-check-label" for="price_ticket">Price Ticket</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="columns[]" value="totalPayment_ticket" id="totalPayment_ticket">
                                                <label class="form-check-label" for="totalPayment_ticket">Total Payment Ticket</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="columns[]" value="paymentMethod_ticket" id="paymentMethod_ticket">
                                                <label class="form-check-label" for="paymentMethod_ticket">Payment Method Ticket</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="columns[]" value="name_add" id="name_add">
                                                <label class="form-check-label" for="name_add">Additionals</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="columns[]" value="qty_add" id="qty_add">
                                                <label class="form-check-label" for="qty_add">Qty Additionals</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="columns[]" value="price_add" id="price_add">
                                                <label class="form-check-label" for="price_add">Price Add</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="columns[]" value="totalPayment_add" id="totalPayment_add">
                                                <label class="form-check-label" for="totalPayment_add">Total Payment Add</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="columns[]" value="paymentMethod_add" id="paymentMethod_add">
                                                <label class="form-check-label" for="paymentMethod_add">Payment Method Add</label>
                                            </div>                        
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="columns[]" value="name_receiver" id="name_receiver">
                                                <label class="form-check-label" for="name_receiver">Name Receiver</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="columns[]" value="type_receiver" id="type_receiver">
                                                <label class="form-check-label" for="type_receiver">Type Receiver</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="columns[]" value="phone_receiver" id="phone_receiver">
                                                <label class="form-check-label" for="phone_receiver">Phone Receiver</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="columns[]" value="carPlate_receiver" id="carPlate_receiver">
                                                <label class="form-check-label" for="carPlate_receiver">Car Plate Receiver</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="columns[]" value="nominal_cms" id="nominal_cms">
                                                <label class="form-check-label" for="nominal_cms">Nominal Commission</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="columns[]" value="total_cms" id="total_cms">
                                                <label class="form-check-label" for="total_cms">Total Commission</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="columns[]" value="username" id="username">
                                                <label class="form-check-label" for="username">Admin</label>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Select/Deselect All -->
                                    <div class="form-check mt-3">
                                        <input class="form-check-input" type="checkbox" id="select_all">
                                        <label class="form-check-label" for="select_all">Select/Deselect All</label>
                                    </div>
                                </div>


                                <!-- Submit Buttons -->
                                <div class="col-md-12 d-flex align-items-end">
                                    <button type="submit" class="btn btn-dark me-2 mb-0" onclick="document.getElementById('filter-download-form').action='{{ url('reports') }}'"><i class="fas fa-filter text-white text-sm opacity-10 mx-1"></i>Filter</button>
                                    <button type="submit" class="btn btn-info mb-0" onclick="document.getElementById('filter-download-form').action='{{ url('reports/export') }}'"><i class="fas fa-download text-white text-sm opacity-10 mx-1"></i>Report</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="d-flex card-header pb-0">
                        <h6>Reports Table</h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2 pt-3">
                        <form method="GET" action="{{ url('reports') }}">
                            <div class="row card-body py-2" id="search-criteria">
                                <div class="row col-md-8">
                                    @if(!empty($searchColumns))
                                        @foreach($searchColumns as $index => $column)
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label for="search_column">Search By</label>
                                                    <select name="search_columns[]" class="form-control search-column" data-index="{{ $index }}">
                                                    <option value="name" {{ $column == 'name' ? 'selected' : '' }}>Name</option>
                                                        <option value="nationality" {{ $column == 'nationality' ? 'selected' : '' }}>nationality</option>
                                                        <option value="hostelry" {{ $column == 'hostelry' ? 'selected' : '' }}>Hostelry</option>
                                                        <option value="qty_ticket" {{ $column == 'qty_ticket' ? 'selected' : '' }}>Qty Ticket</option>
                                                        <option value="paymentMethod_ticket" {{ $column == 'paymentMethod_ticket' ? 'selected' : '' }}>Payment Method</option>
                                                        <option value="price_ticket" {{ $column == 'price_ticket' ? 'selected' : '' }}>Ticket Price</option>
                                                        <option value="qty_add" {{ $column == 'qty_add' ? 'selected' : '' }}>Qty Add</option>
                                                        <option value="price_add" {{ $column == 'price_add' ? 'selected' : '' }}>Add Price</option>
                                                        <option value="paymentMethod_add" {{ $column == 'paymentMethod_add' ? 'selected' : '' }}>Payment Method Add</option>
                                                        <option value="name_receiver" {{ $column == 'name_receiver' ? 'selected' : '' }}>Receiver</option>
                                                        <option value="type_receiver" {{ $column == 'type_receiver' ? 'selected' : '' }}>Type of Receiver</option>
                                                        <option value="created_at" {{ $column == 'created_at' ? 'selected' : '' }}>Date</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-5 search-keyword-container">
                                                <div class="form-group">
                                                    <label for="search_keyword">Keyword</label>
                                                    @if ($column == 'created_at')
                                                        <div class="d-flex">
                                                            <div class="col-md-6">
                                                                <input type="date" name="search_keywords[{{ $index }}][start_date]" class="form-control" value="{{ $searchKeywords[$index]['start_date'] ?? '' }}">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <input type="date" name="search_keywords[{{ $index }}][end_date]" class="form-control ms-1" value="{{ $searchKeywords[$index]['end_date'] ?? '' }}">
                                                            </div>
                                                        </div>
                                                        <div class="text-danger date-error text-sm" style="display:none;">Start date must be before end date.</div>
                                                    @else
                                                        <input type="text" name="search_keywords[{{ $index }}]" class="form-control" value="{{ $searchKeywords[$index] ?? '' }}">
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label for="search_column">Search By</label>
                                                <select name="search_columns[]" class="form-control search-column" data-index="0">
                                                <option value="name">Name</option>
                                                    <option value="nationality">Nationality</option>
                                                    <option value="hostelry">Hostelry</option>
                                                    <option value="qty_ticket">Qty Ticket</option>
                                                    <option value="paymentMethod_ticket">paymentMethod_ticket</option>
                                                    <option value="price_ticket">Ticket Price</option>
                                                    <option value="qty_add">Qty Add</option>
                                                    <option value="price_add">Add Price</option>
                                                    <option value="paymentMethod_add">Payment Method Add</option>
                                                    <option value="name_receiver">Receiver</option>
                                                    <option value="type_receiver">Type of Receiver</option>
                                                    <option value="created_at">Date</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-5 search-keyword-container">
                                            <div class="form-group">
                                                <label for="search_keyword">Keyword</label>
                                                <input type="text" name="search_keywords[0]" class="form-control">
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    <div class="col-md-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary mr-2 me-3">Search</button>
                                        <a href="{{ route('reports') }}" class="btn btn-secondary mr-2 me-3 d-flex align-items-center">Clear</a>
                                        <button type="button" class="btn btn-info" id="add-criteria">Add Criteria</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            No
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            @sortablelink('name', 'Name')</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            @sortablelink('phone_number', 'Phone Number')</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            @sortablelink('email', 'Email')</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            @sortablelink('nationality', 'Nationality')</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            @sortablelink('visitor', 'Visitor')</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            @sortablelink('hostelry', 'Hostelry')</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            @sortablelink('title', 'Ticket')</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            @sortablelink('qty_ticket', 'Qty.')</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            @sortablelink('price_ticket', 'Ticket Price')</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            @sortablelink('totalPayment_ticket', 'Total Payment Ticket')</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            @sortablelink('paymentMethod_ticket', 'Payment Method Ticket')</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            @sortablelink('paymentMethod_ticket', 'Proof of Payment')</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            @sortablelink('name_add', 'Additional')</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            @sortablelink('qty_drink', 'Qty. Add')</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            @sortablelink('price_add', 'Additional Price')</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            @sortablelink('totalPayment_add', 'Total Payment Additional')</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            @sortablelink('paymentMethod_add', 'Payment Method Additional')</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            @sortablelink('name_receiver', 'Name Receiver')</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            @sortablelink('type_receiver', 'Type Receiver')</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            @sortablelink('phone_receiver', 'Phone Receiver')</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            @sortablelink('carPlate_receiver', 'Receiver Plate')</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            @sortablelink('nominal_cms', 'Nominal Commission')</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            @sortablelink('total_cms', 'Total Commission')</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            @sortablelink('created_at', 'Created at')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($reports as $item)
                                    <tr>
                                        <td class="text-center">
                                            <div class="d-flex px-3 py-1">
                                                <span class="text-secondary text-xs font-weight-bold">{{ $loop->iteration + $startNumber }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $item->name }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $item->phone_number }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $item->email }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $item->nationality }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $item->visitor }}</p>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold">{{ $item->hostelry }}</span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold">{{ $item->title }}</span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold">{{ $item->qty_ticket }}</span>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <p class="text-xs font-weight-bold mb-0">Rp{{ number_format($item->price_ticket, 0, ',', '.') }}</p>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <p class="text-xs font-weight-bold mb-0">Rp{{ number_format($item->totalPayment_ticket, 0, ',', '.') }}</p>
                                        </td>
                                        @if ($item->paymentMethod_ticket == "Cash")
                                        <td class="align-middle text-center text-sm">
                                            <span class="badge badge-sm bg-gradient-success">Cash</span>
                                        </td>
                                        @elseif ($item->paymentMethod_ticket == "Card")
                                        <td class="align-middle text-center text-sm">
                                            <span class="badge badge-sm bg-gradient-info">Card</span>
                                        </td>
                                        @elseif ($item->paymentMethod_ticket == "Qris")
                                        <td class="align-middle text-center text-sm">
                                            <span class="badge badge-sm bg-gradient-primary">Qris</span>
                                        </td>
                                        @elseif ($item->paymentMethod_ticket == "Transfer")
                                        <td class="align-middle text-center text-sm">
                                            <span class="badge badge-sm bg-gradient-secondary">Transfer</span>
                                        </td>
                                        @elseif ($item->paymentMethod_ticket == "Hotel")
                                        <td class="align-middle text-center text-sm">
                                            <span class="badge badge-sm bg-gradient-secondary">Paid</span>
                                        </td>
                                        @else
                                        <td class="align-middle text-center text-sm">
                                            <span class="badge badge-sm bg-gradient-danger">Delay</span>
                                        </td>
                                        @endif
                                        <td class="align-middle text-center text-sm">
                                            <a href="{{ url('/storage/' . $item->document) }}" target="_blank"><p class="text-xs font-weight-bold mb-0">{{ $item->document }}</p></a>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold">{{ $item->name_add }}</span>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <p class="text-xs font-weight-bold mb-0">{{ $item->qty_add }}</p>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <p class="text-xs font-weight-bold mb-0">Rp{{ number_format($item->price_add, 0, ',', '.') }}</p>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <p class="text-xs font-weight-bold mb-0">Rp{{ number_format($item->totalPayment_add, 0, ',', '.') }}</p>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <p class="text-xs font-weight-bold mb-0">{{ $item->paymentMethod_add }}</p>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <p class="text-xs font-weight-bold mb-0">{{ $item->name_receiver }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $item->type_receiver }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $item->phone_receiver }}</p>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <p class="text-xs font-weight-bold mb-0">{{ $item->carPlate_receiver }}</p>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <p class="text-xs font-weight-bold mb-0">Rp{{ number_format($item->nominal_cms, 0, ',', '.') }}</p>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <p class="text-xs font-weight-bold mb-0">Rp{{ number_format($item->total_cms, 0, ',', '.') }}</p>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <p class="text-xs font-weight-bold mb-0">{{ $item->created_at }}</p>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="mx-3 d-flex justify-content-between align-items-center">
                                <div>
                                    <form action="{{ url('reports') }}" method="GET">
                                        <label for="items_per_page" class="form-label">Items per page:</label>
                                        <select name="items_per_page" id="items_per_page" class="form-select" onchange="this.form.submit()">
                                            <option value="10" {{ request('items_per_page') == 10 ? 'selected' : '' }}>10</option>
                                            <option value="25" {{ request('items_per_page') == 25 ? 'selected' : '' }}>25</option>
                                            <option value="50" {{ request('items_per_page') == 50 ? 'selected' : '' }}>50</option>
                                            <option value="100" {{ request('items_per_page') == 100 ? 'selected' : '' }}>100</option>
                                        </select>
                                    </form>
                                </div>
                                <div class="mx-3">
                                    {!! $reports->appends(Request::except('page'))->render() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth.footer')
    </div>

    @push('js')
    <!-- select/deselect all -->
    <script>
        document.getElementById('select_all').addEventListener('change', function() {
            const container = document.getElementById('specific-container');
            const checkboxes = container.querySelectorAll('input[type="checkbox"]:not(#select_all)');
            checkboxes.forEach(checkbox => checkbox.checked = this.checked);
        });
    </script>
    <script>
        function clearDates() {
            document.querySelector('input[name="start_date"]').value = '';
            document.querySelector('input[name="end_date"]').value = '';
        }
    </script>

    <!-- Search by data -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let criteriaCount = {{ !empty($searchColumns) ? count($searchColumns) : 1 }};

            document.getElementById('add-criteria').addEventListener('click', function() {
                var criteriaRow = document.createElement('div');
                criteriaRow.classList.add('row', 'col-md-8');
                criteriaRow.innerHTML = `
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="search_column">Search By</label>
                            <select name="search_columns[]" class="form-control search-column" data-index="${criteriaCount}">
                                <option value="name">Name</option>
                                <option value="nationality">Nationality</option>
                                <option value="hostelry">Hostelry</option>
                                <option value="qty_ticket">Qty Ticket</option>
                                <option value="paymentMethod_ticket">paymentMethod_ticket</option>
                                <option value="price_ticket">Ticket Price</option>
                                <option value="qty_add">Qty Add</option>
                                <option value="price_add">Add Price</option>
                                <option value="paymentMethod_add">Payment Method Add</option>
                                <option value="name_receiver">Receiver</option>
                                <option value="type_receiver">Type of Receiver</option>
                                <option value="created_at">Date</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-5 search-keyword-container">
                        <div class="form-group">
                            <label for="search_keyword">Keyword</label>
                            <input type="text" name="search_keywords[${criteriaCount}]" class="form-control search-keyword">
                        </div>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="button" class="btn btn-danger remove-criteria">Remove</button>
                    </div>
                `;
                document.getElementById('search-criteria').appendChild(criteriaRow);
                criteriaCount++;
            });

            document.getElementById('search-criteria').addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-criteria')) {
                    e.target.closest('.row').remove();
                }
            });

            document.getElementById('search-criteria').addEventListener('change', function(e) {
                if (e.target.classList.contains('search-column')) {
                    var index = e.target.dataset.index;
                    var keywordContainer = e.target.closest('.row').querySelector('.search-keyword-container');
                    if (e.target.value == 'created_at') {
                        keywordContainer.innerHTML = `
                            <div class="form-group">
                                <label for="search_keyword">Keyword</label>
                                <div class="d-flex">
                                    <div class="col-md-6">
                                        <input type="date" name="search_keywords[${index}][start_date]" class="form-control search-keyword"></div>
                                    <div class="col-md-6">
                                        <input type="date" name="search_keywords[${index}][end_date]" class="form-control search-keyword ms-1"></div>
                                </div>
                                <div class="text-danger date-error text-sm" style="display:none;">Start date must be before end date.</div>
                            </div>
                        `;
                    } else {
                        keywordContainer.innerHTML = `
                            <div class="form-group">
                                <label for="search_keyword">Keyword</label>
                                <input type="text" name="search_keywords[${index}]" class="form-control search-keyword">
                            </div>
                        `;
                    }
                }
            });

            document.getElementById('search-form').addEventListener('submit', function(e) {
                let valid = true;
                document.querySelectorAll('.date-error').forEach(function(error) {
                    error.style.display = 'none';
                });

                document.querySelectorAll('.search-keyword-container').forEach(function(container) {
                    const startDateInput = container.querySelector('input[name*="[start_date]"]');
                    const endDateInput = container.querySelector('input[name*="[end_date]"]');

                    if (startDateInput && endDateInput) {
                        const startDate = startDateInput.value;
                        const endDate = endDateInput.value;

                        if (startDate && endDate && startDate > endDate) {
                            valid = false;
                            container.querySelector('.date-error').style.display = 'block';
                        }
                    }
                });

                if (!valid) {
                    e.preventDefault();
                }
            });
        });
    </script>

    <!-- Filter by date -->
    <script>
        function validateDates() {
            var startDate = document.getElementById('start_date').value;
            var endDate = document.getElementById('end_date').value;
            var startDateError = document.getElementById('start_date_error');

            // Clear any previous error message
            startDateError.textContent = '';

            if (startDate && endDate && startDate > endDate) {
                startDateError.textContent = 'Start Date cannot be greater than End Date.';
                return false; // Prevent form submission
            }

            return true; // Allow form submission
        }

        function clearDates() {
            document.getElementById('start_date').value = '';
            document.getElementById('end_date').value = '';
            document.getElementById('start_date_error').textContent = ''; // Clear any previous error message
        }
    </script>
    @endpush
@endsection