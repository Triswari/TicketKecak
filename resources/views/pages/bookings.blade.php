@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Bookings'])
        @if(session()->has('success') || session()->has('error'))
        <div id="alert">
            @include('components.alert')
        </div>
        @endif
    <div class="container-fluid py-4">
        <!-- search by data -->
        <div class="row">
            <div class="col-12 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <form method="GET" action="{{ route('bookings') }}" id="search-form">
                            <div class="row" id="search-criteria">
                                <div class="row col-md-8">
                                    @if(!empty($searchColumns))
                                        @foreach($searchColumns as $index => $column)
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label for="search_column">Search By</label>
                                                    <select name="search_columns[]" class="form-control search-column" data-index="{{ $index }}">
                                                        <option value="name" {{ $column == 'name' ? 'selected' : '' }}>Name</option>
                                                        <option value="nationality" {{ $column == 'nationality' ? 'selected' : '' }}>Nationality</option>
                                                        <option value="qty_ticket" {{ $column == 'qty_ticket' ? 'selected' : '' }}>Quantity Ticket</option>
                                                        <option value="hostelry" {{ $column == 'hostelry' ? 'selected' : '' }}>Hostelry</option>
                                                        <option value="paymentMethod_ticket" {{ $column == 'paymentMethod_ticket' ? 'selected' : '' }}>Payment Method</option>
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
                                                    <option value="qty_ticket">Quantity Ticket</option>
                                                    <option value="hostelry">Hostelry</option>
                                                    <option value="paymentMethod_ticket">Payment Method</option>
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
                                        <a href="{{ route('bookings') }}" class="btn btn-secondary mr-2 me-3 d-flex align-items-center">Clear</a>
                                        <button type="button" class="btn btn-info" id="add-criteria">Add Criteria</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Bookings table -->
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Bookings Table</h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-4">
                                            <a href="">
                                                No.
                                            </a>
                                        </th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">
                                            <a href="{{ route('bookings', ['sort_field' => 'name', 'sort_direction' => ($sortField == 'name' && $sortDirection == 'asc') ? 'desc' : 'asc']) }}">
                                                Name
                                            </a>
                                        </th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">
                                            <a href="{{ route('bookings', ['sort_field' => 'nationality', 'sort_direction' => ($sortField == 'nationality' && $sortDirection == 'asc') ? 'desc' : 'asc']) }}">
                                                Nationality
                                            </a>
                                        </th>
                                        <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                            <a href="{{ route('bookings', ['sort_field' => 'qty_ticket', 'sort_direction' => ($sortField == 'qty_ticket' && $sortDirection == 'asc') ? 'desc' : 'asc']) }}">
                                                Qty.
                                            </a>
                                        </th>
                                        <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                            <a href="{{ route('bookings', ['sort_field' => 'hostelry', 'sort_direction' => ($sortField == 'hostelry' && $sortDirection == 'asc') ? 'desc' : 'asc']) }}">
                                                Hostelry
                                            </a>
                                        </th>
                                        <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                            <a href="{{ route('bookings', ['sort_field' => 'paymentMethod_ticket', 'sort_direction' => ($sortField == 'paymentMethod_ticket' && $sortDirection == 'asc') ? 'desc' : 'asc']) }}">
                                                Payment Method
                                            </a>
                                        </th>
                                        <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                            <a href="">
                                                Receiver
                                            </a>
                                        </th>
                                        <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                            <a href="">
                                                Date
                                            </a>
                                        </th>
                                        <th class="text-secondary opacity-7"></th>
                                        <th class="text-secondary opacity-7"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($bookings as $index => $booking)
                                    <tr>
                                        <td class="text-center">
                                            <div class="d-flex px-4 py-1">
                                                <span class="text-secondary text-xs font-weight-bold">{{ $index + 1 }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $booking->name }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $booking->nationality }}</p>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold">{{ $booking->qty_ticket }}</span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold">{{ $booking->hostelry }}</span>
                                        </td>
                                        @if ($booking->paymentMethod_ticket == "Cash")
                                        <td class="align-middle text-center text-sm">
                                            <span class="badge badge-sm bg-gradient-success">Cash</span>
                                        </td>
                                        @elseif ($booking->paymentMethod_ticket == "Card")
                                        <td class="align-middle text-center text-sm">
                                            <span class="badge badge-sm bg-gradient-info">Card</span>
                                        </td>
                                        @elseif ($booking->paymentMethod_ticket == "Qris")
                                        <td class="align-middle text-center text-sm">
                                            <span class="badge badge-sm bg-gradient-primary">Qris</span>
                                        </td>
                                        @elseif ($booking->paymentMethod_ticket == "Transfer")
                                        <td class="align-middle text-center text-sm">
                                            <span class="badge badge-sm bg-gradient-secondary">Transfer</span>
                                        </td>
                                        @elseif ($booking->paymentMethod_ticket == "GlobalTix")
                                        <td class="align-middle text-center text-sm">
                                            <span class="badge badge-sm bg-gradient-success">GlobalTix</span>
                                        </td>
                                        @elseif ($booking->paymentMethod_ticket == "Paid")
                                        <td class="align-middle text-center text-sm">
                                            <span class="badge badge-sm bg-gradient-danger">Paid</span>
                                        </td>
                                        @else
                                        <td class="align-middle text-center text-sm">
                                            <span class="badge badge-sm bg-gradient-danger">Delay</span>
                                        </td>
                                        @endif
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold">{{ $booking->name_receiver }}</span>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ $booking->created_at ? $booking->created_at->format('Y-m-d') : 'N/A' }}
                                            </p>
                                        </td>
                                        <td class="align-middle">
                                            <a class="btn btn-link text-dark px-3 mb-0"
                                                data-toggle="tooltip" data-original-title="Edit user" href="{{ url('/edit/'.$booking->id_booking) }}">
                                                <i class="fas fa-pencil-alt text-dark me-2"></i>
                                                Edit
                                            </a>
                                        </td>
                                        <td class="align-middle">
                                            <a class="btn btn-link text-dark px-3 mb-0"
                                                data-toggle="tooltip" data-original-title="Edit user" href="{{ url('/invoice/'.$booking->id_booking) }}" target="_blank">
                                                <i class="fas fa-receipt text-dark me-2"></i>Invoice
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="mx-3 d-flex justify-content-between align-items-center">
                                <div>
                                    <form action="{{ route('bookings') }}" method="GET">
                                        <label for="items_per_page" class="form-label">Items per page:</label>
                                        <select name="items_per_page" id="items_per_page" class="form-select" onchange="this.form.submit()">
                                            <option value="10" {{ request('items_per_page') == 10 ? 'selected' : '' }}>10</option>
                                            <option value="25" {{ request('items_per_page') == 25 ? 'selected' : '' }}>25</option>
                                            <option value="50" {{ request('items_per_page') == 50 ? 'selected' : '' }}>50</option>
                                            <option value="100" {{ request('items_per_page') == 100 ? 'selected' : '' }}>100</option>
                                        </select>
                                    </form>
                                </div>
                                <div>
                                    {{ $bookings->appends(request()->except('page'))->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth.footer')
    </div>

<!-- Search by data bookings table -->
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
                            <option value="qty_ticket">Quantity Ticket</option>
                            <option value="hostelry">Hostelry</option>
                            <option value="paymentMethod_ticket">Payment Method</option>
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
@endsection
