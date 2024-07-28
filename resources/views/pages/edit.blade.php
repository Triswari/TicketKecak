@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Edit'])

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
                            <form id="deleteForm" action="{{ url('/delete/'.$booking->id_booking) }}" method="post">
                                @csrf
                                <button type="button" class="btn btn-danger btn-sm ms-auto mb-0 d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                    <i class="fas fa-trash-alt me-2" aria-hidden="true"></i>Delete
                                </button>
                            </form>
                            <!-- Modal -->
                            <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                    <div class="modal-header border-0">
                                        
                                        <button type="button" class="btn-close modal1" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body pt-0">
                                        <h5 class="modal-title d-flex justify-content-sm-center text-bolder mb-2 fs-4" id="deleteModalLabel">Confirm Delete</h5>
                                        <p class="d-flex justify-content-sm-center mb-0" id="deleteModalLabel">Are you sure you want to delete this data?</p>
                                        <p class="d-flex justify-content-sm-center mb-0" id="deleteModalLabel">This action cannot be undone.</p>
                                    </div>
                                    <div class="modal-footer d-flex justify-content-sm-center border-0">
                                        <button type="button" class="btn btn-secondary px-6" data-bs-dismiss="modal">Cancel</button>
                                        <button type="button" class="btn btn-danger px-6" id="confirmDelete">Delete</button>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        

                        @if ($errors->any())
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif
                        
                        <form name='autoSumForm' method="POST" action="{{ url('/update/'.$booking->id_booking) }}" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">ID Admin <span class="required-icon">*</span></label>
                                            <input class="form-control" type="number" id="id-user" name="id" value="{{ $booking->id }}" >
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="username" class="form-control-label">Username Admin <span class="required-icon">*</span></label>
                                            <input class="form-control" type="text" id="username" name="username" value="{{ $booking->user->username }}" >
                                        </div>
                                    </div>
                                </div>
                                <hr class="horizontal dark">
                                <p class="text-uppercase text-sm">Customer Information</p>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Name <span class="required-icon">*</span></label>
                                            <input class="form-control" type="text" name= "name" value="{{ $booking->customer->name }}"">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Phone Number</label>
                                            <input class="form-control" type="tel" name="phone_number" value="{{ $booking->customer->phone_number }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Email</label>
                                            <input class="form-control" type="email" name="email"  value="{{ $booking->customer->email }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Nationality</label>
                                            <input class="form-control" type="text" name="nationality" value="{{ $booking->customer->nationality }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Visitor</label>
                                            <input class="form-control" name="visitor" id="example-text-input" value="{{ $booking->customer->visitor }}">
                                            </input>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Hostelry</label>
                                            <input class="form-control" type="text" name="hostelry" value="{{ $booking->customer->hostelry }}">
                                        </div>
                                    </div>
                                </div>
                                <hr class="horizontal dark">
                                <p class="text-uppercase text-sm">Ticket Information</p>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">ID Ticket <span class="required-icon">*</span></label>
                                            <input class="form-control" type="number" id="id-ticket" name="id_ticket" value="{{ $booking->id_ticket }}" onblur="fetchTitlePriceTicket();">
                                            <div id="id-ticket-error" class="text-danger mt-1 text-sm"></div> <!-- Error message div -->
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Ticket Title</label>
                                            <input class="form-control" type="text" id="title" value="">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Total Ticket <span class="required-icon">*</span></label>
                                            <input class="form-control" type="number" id= "ticket" name="qty_ticket" onkeyup="multiplication();" value="{{ $booking->qty_ticket }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Ticket Price</label>
                                            <input class="form-control" type="number" id="price" value="" onkeyup="multiplication();">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Total Payment</label>
                                            <input class="form-control" type="number" id="total" name="totalPayment_ticket" value="{{ $booking->totalPayment_ticket }}" onkeyup="multiplication();">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="example-select-input" class="form-control-label">Payment Method</label>
                                            <select class="form-control" name="paymentMethod_ticket" id="example-select-input">
                                                <option value="" {{ is_null($booking->paymentMethod_ticket) ? 'selected' : '' }}>---SELECT---</option>
                                                <option value="Cash" {{ $booking->paymentMethod_ticket == 'Cash' ? 'selected' : '' }}>Cash</option>
                                                <option value="Card" {{ $booking->paymentMethod_ticket == 'Card' ? 'selected' : '' }}>Card</option>
                                                <option value="GlobalTix" {{ $booking->paymentMethod_ticket == 'GlobalTix' ? 'selected' : '' }}>GlobalTix</option>
                                                <option value="Qris" {{ $booking->paymentMethod_ticket == 'Qris' ? 'selected' : '' }}>Qris</option>
                                                <option value="Transfer" {{ $booking->paymentMethod_ticket == 'Transfer' ? 'selected' : '' }}>Transfer</option>
                                                <option value="Paid" {{ $booking->paymentMethod_ticket == 'Paid' ? 'selected' : '' }}>Paid</option>
                                                <option value="Delay" {{ $booking->paymentMethod_ticket == 'Delay' ? 'selected' : '' }}>Delay</option>
                                            </select>
                                        </div>
                                    </div>
                                    @if($booking->document)
                                    <!-- <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="existing-document" class="form-control-label">Existing Proof of Payment</label>
                                            <a href="{{ url('/storage/' . $booking->document) }}" target="_blank" class="text-sm">{{ basename($booking->document) }}</a>
                                        </div>
                                    </div> -->
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="document" class="form-control-label">Proof of Payment | </label>
                                            <a href="{{ url('/storage/' . $booking->document) }}" target="_blank" class="text-sm">{{ basename($booking->document) }}</a>
                                            <input class="form-control" type="file" id="document" name="document">
                                        </div>
                                    </div>
                                    @endif
                                    
                                </div>    
                                <hr class="horizontal dark">
                                <p class="text-uppercase text-sm">Additional Information</p>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">ID Additional</label>
                                            <input class="form-control" type="number" id="id-add" name="id_add" value="{{ $booking->id_add }}" onblur="fetchNamePriceAdd();">
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
                                            <label for="example-text-input" class="form-control-label">Qty. Additional</label>
                                            <input class="form-control" type="number" id="add" name="qty_add" onkeyup="multiplyadd();" value="{{ $booking->qty_add }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Additional Price</label>
                                            <input class="form-control" type="number" id="price-add" value="" onkeyup="multiplyadd();">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Total Payment Additional</label>
                                            <input class="form-control" type="number" id="total-payment-add" name ="totalPayment_add" value="{{ $booking->totalPayment_add }}" onkeyup="multiplyadd();">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="example-select-input" class="form-control-label">Payment Method Additional</label>
                                            <select class="form-control" name="paymentMethod_add" id="example-select-input">
                                                <option value="" {{ is_null($booking->paymentMethod_add) ? 'selected' : '' }}>---SELECT---</option>
                                                <option value="Cash" {{ $booking->paymentMethod_add == 'Cash' ? 'selected' : '' }}>Cash</option>
                                                <option value="Card" {{ $booking->paymentMethod_add == 'Card' ? 'selected' : '' }}>Card</option>
                                                <option value="GlobalTix" {{ $booking->paymentMethod_add == 'GlobalTix' ? 'selected' : '' }}>GlobalTix</option>
                                                <option value="Qris" {{ $booking->paymentMethod_add == 'Qris' ? 'selected' : '' }}>Qris</option>
                                                <option value="Transfer" {{ $booking->paymentMethod_add == 'Transfer' ? 'selected' : '' }}>Transfer</option>
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
                                            <input class="form-control" id="name-receiver " type="text" name="name_receiver" value="{{ $booking->commission->name_receiver }}" >
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Type Receiver</label>
                                            <input class="form-control" type="text" name="type_receiver" value="{{ $booking->commission->type_receiver }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Phone Receiver</label>
                                            <input class="form-control" type="text" name ="phone_receiver" value="{{ $booking->commission->phone_receiver }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Receiver Vehicle Plate</label>
                                            <input class="form-control" type="text" name="carPlate_receiver" value="{{ $booking->commission->carPlate_receiver }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">nominal commission</label>
                                            <input class="form-control" type="text" id="nominal-cms" name="nominal_cms" value="{{ $booking->commission->nominal_cms }}" onkeyup="multiplication();">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">total commission</label>
                                            <input class="form-control" type="text" id="total-commission" name="total_cms" value="{{ $booking->total_cms }}" onkeyup="multiplication();">
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success btn-sm ms-auto"><i class="fas fa-sync-alt me-2"></i>Update</button>
                            </div>
                        </form> 
                    </div>
            </div>
               
        </div>
        @include('layouts.footers.auth.footer')
    </div>



<!-- Script Perhitungan Otomatis Ticket dan Drink -->
<script>
    function multiplication() {
        var txtFirstNumberValue = document.getElementById('ticket').value;
        var txtSecondNumberValue = document.getElementById('price').value;
        var txtThirdNumberValue = document.getElementById('nominal-cms').value;
        var result = parseInt(txtFirstNumberValue) * parseInt(txtSecondNumberValue);
        var commissionResult = parseInt(txtFirstNumberValue) * parseInt(txtThirdNumberValue);
        if(!isNaN(result)) {
            document.getElementById('total').value=result;
            document.getElementById('total-commission').value=commissionResult;
        }
    }

    function multiplyadd() {
        var txtThirdNumberValue = document.getElementById('add').value;
        var txtFourthNumberValue = document.getElementById('price-add').value;
        var drinkResult = parseInt(txtThirdNumberValue) * parseInt(txtFourthNumberValue);
        if(!isNaN(drinkResult)) {
            document.getElementById('total-payment-add').value=drinkResult;
        }
    }

    document.getElementById('confirmDelete').addEventListener('click', function () {
        document.getElementById('deleteForm').submit();
    });
</script>

<!-- get data by id additional -->
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

<!-- get data by id ticket -->
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