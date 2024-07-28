@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Tickets'])

    @if(session()->has('success') || session()->has('error'))
    <div id="alert">
        @include('components.alert')
    </div>
    @endif
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                    <div class="card">
                        <div class="card-header pb-0">
                            <div class="d-flex align-items-center">
                                <p class="mb-0">Tickets Order</p>
                            </div>
                        </div>

                        @if ($errors->any())
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif
                        
                        <form name='autoSumForm' method="POST" action="{{ route('booking.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">ID Admin <span class="required-icon">*</span></label>
                                            <input class="form-control" type="text" id="id-user" name="id" value="{{ Auth::user()->id }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="username" class="form-control-label">Username Admin <span class="required-icon">*</span></label>
                                            <input class="form-control" type="text" id="username" name="username" value="{{ Auth::user()->username }}">
                                        </div>
                                    </div>
                                </div>
                                <hr class="horizontal dark">
                                <p class="text-uppercase text-sm">Customer Information</p>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Name <span class="required-icon">*</span></label>
                                            <input class="form-control" type="text" name="name" value="{{ old('name') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Phone Number</label>
                                            <input class="form-control" type="tel" name="phone_number" value="{{ old('phone_number') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Email</label>
                                            <input class="form-control" type="email" name="email" value="{{ old('email') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Nationality</label>
                                            <input class="form-control" type="text" name="nationality" value="{{ old('nationality') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Visitor</label>
                                            <select class="select-option" name="visitor" id="example-text-input">
                                                <option selected>---SELECT---</option>
                                                <option value="Domestic">Domestic</option>
                                                <option value="Foreign">Foreign</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Hostelry</label>
                                            <input class="form-control" type="text" name="hostelry" value="{{ old('hostelry') }}">
                                        </div>
                                    </div>
                                </div>
                                <hr class="horizontal dark">
                                <p class="text-uppercase text-sm">Ticket Information</p>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">ID Ticket <span class="required-icon">*</span></label>
                                            <input class="form-control" type="number" id="id-ticket" name="id_ticket" value="1" onblur="fetchTitlePriceTicket()">
                                            <div id="id-ticket-error" class="text-danger mt-1 text-sm"></div> <!-- Error message div -->
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Title Ticket</label>
                                            <input class="form-control" type="text" id="title" value="">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Qty Ticket <span class="required-icon">*</span></label>
                                            <input class="form-control" type="number" id="ticket" name="qty_ticket" value="{{ old('qty_ticket') }}" onkeyup="multiplication();">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Ticket Price</label>
                                            <input class="form-control" type="number" id="price" value="{{ old('price_ticket') }}" onkeyup="multiplication();">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Total Payment</label>
                                            <input class="form-control" type="number" id="total" name="totalPayment_ticket" value="{{ old('totalPayment_ticket') }}" onkeyup="multiplication();">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Payment Method</label>
                                            <select class="select-option" name="paymentMethod_ticket" id="example-text-input">
                                                <option value="">---SELECT---</option>
                                                <option value="Cash">Cash</option>
                                                <option value="Card">Card</option>
                                                <option value="GlobalTix">Global Tix</option>
                                                <option value="Qris">Qris</option>
                                                <option value="Transfer">Transfer</option>
                                                <option value="Paid">Paid</option>
                                                <option value="Delay">Delay</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="document" class="form-control-label">Proof of Payment</label>
                                            <input class="form-control" type="file" id="document" name="document">
                                        </div>
                                    </div>
                                </div>
                                <hr class="horizontal dark">
                                <p class="text-uppercase text-sm">Additional Information</p>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">ID Additional</label>
                                            <input class="form-control" type="number" id="id-add" name="id_add" onblur="fetchNamePriceAdd();">
                                            <div id="id-add-error" class="text-danger mt-1 text-sm"></div> <!-- Error message div -->
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Name Additional</label>
                                            <input class="form-control" type="text" id="name-add" value="">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Qty Additional</label>
                                            <input class="form-control" type="number" id="add" name="qty_add" value="{{ old('qty_add') }}" onkeyup="multiplyadd();">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Additional Price</label>
                                            <input class="form-control" type="number" id="price-add" value="{{ old('price_add') }}" onkeyup="multiplyadd();">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Total Payment Additional</label>
                                            <input class="form-control" type="number" id="total-payment-add" name="totalPayment_add" value="{{ old('totalPayment_add') }}" onkeyup="multiplyadd();">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Payment Method Additional</label>
                                            <select class="select-option" name="paymentMethod_add" id="example-text-input">
                                                <option value="">---SELECT---</option>
                                                <option value="Cash">Cash</option>
                                                <option value="Card">Card</option>
                                                <option value="GlobalTix">Global Tix</option>
                                                <option value="Qris">Qris</option>
                                                <option value="Transfer">Transfer</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <hr class="horizontal dark">
                                <p class="text-uppercase text-sm">Commission Information</p>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Name Receiver</label>
                                            <input class="form-control" id="name-receiver" type="text" name="name_receiver" value="{{ old('name_receiver') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Type Receiver</label>
                                            <input class="form-control" type="text" name="type_receiver" value="{{ old('type_receiver') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Phone Receiver</label>
                                            <input class="form-control" type="text" name="phone_receiver" value="{{ old('phone_receiver') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Receiver Vehicle Plate</label>
                                            <input class="form-control" type="text" name="carPlate_receiver" value="{{ old('carPlate_receiver') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Nominal Commission</label>
                                            <input class="form-control" type="number" id="nominal-cms" name="nominal_cms" value="{{ old('nominal_cms', '0') }}" onkeyup="multiplication();">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Total Commission</label>
                                            <input class="form-control" type="number" id="total-commission" name="total_cms" value="{{ old('total_cms') }}" onkeyup="multiplication();">
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success btn-sm ms-auto">Submit</button>
                            </div>
                        </form>
                    </div>
            </div>   
        </div>
        @include('layouts.footers.auth.footer')
    </div>

<!-- Script Perhitungan Otomatis -->
<script>
    function multiplication() {
        var qtyTicket = document.getElementById('ticket').value;
        var ticketPrice = document.getElementById('price').value;
        var nominalCms = document.getElementById('nominal-cms').value;
        var totalPayment = parseInt(qtyTicket) * parseInt(ticketPrice);
        var totalCommission = parseInt(qtyTicket) * parseInt(nominalCms);
        if (!isNaN(totalPayment)) {
            document.getElementById('total').value = totalPayment;
            document.getElementById('total-commission').value = totalCommission;
        }
    }

    function multiplyadd() {
        var qtyAdd = document.getElementById('add').value;
        var addPrice = document.getElementById('price-add').value;
        var totalPaymentAdd = parseInt(qtyAdd) * parseInt(addPrice);
        if (!isNaN(totalPaymentAdd)) {
            document.getElementById('total-payment-add').value = totalPaymentAdd;
        }
    }
</script>

<!-- Get data by id additional -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var idAdditionalInput = document.getElementById('id-add');
        if (idAdditionalInput.value) {
            fetchNamePriceAdd();
        }
    });

    function fetchNamePriceAdd() {
        var id = document.getElementById('id-add').value;
        var errorDiv = document.getElementById('id-add-error');

        // Clear previous error message
        errorDiv.textContent = '';

        if (id) {
            fetch(`/get-name-price-add/${id}`)
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(errorData => Promise.reject(errorData));
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.error) {
                        errorDiv.textContent = data.error;
                        document.getElementById('name-add').value = '';
                        document.getElementById('price-add').value = '';
                    } else {
                        if (data.name_add !== null) {
                            document.getElementById('name-add').value = data.name_add;
                        } else {
                            document.getElementById('name-add').value = '';
                        }
                        if (data.price_add !== null) {
                            document.getElementById('price-add').value = data.price_add;
                        } else {
                            document.getElementById('price-add').value = '';
                        }
                    }
                })
                .catch(error => {
                    errorDiv.textContent = error.error || 'Error fetching name and price (Wrong ID)';
                    document.getElementById('name-add').value = '';
                    document.getElementById('price-add').value = '';
                });
        }
    }
</script>

<!-- Get data by id ticket -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var idTicketInput = document.getElementById('id-ticket');
        if (idTicketInput.value) {
            fetchTitlePriceTicket();
        }
    });

    function fetchTitlePriceTicket() {
        var id = document.getElementById('id-ticket').value;
        var errorDiv = document.getElementById('id-ticket-error');

        // Clear previous error message
        errorDiv.textContent = '';

        if (id) {
            fetch(`/get-title-price-ticket/${id}`)
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(errorData => Promise.reject(errorData));
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.error) {
                        errorDiv.textContent = data.error;
                        document.getElementById('title').value = '';
                        document.getElementById('price').value = '';
                    } else {
                        if (data.title !== null) {
                            document.getElementById('title').value = data.title;
                        } else {
                            document.getElementById('title').value = '';
                        }
                        if (data.price_ticket !== null) {
                            document.getElementById('price').value = data.price_ticket;
                        } else {
                            document.getElementById('price').value = '';
                        }
                    }
                })
                .catch(error => {
                    errorDiv.textContent = error.error || 'Error fetching title and price (Wrong ID)';
                    document.getElementById('title').value = '';
                    document.getElementById('price').value = '';
                });
        }
    }
</script>

@endsection


