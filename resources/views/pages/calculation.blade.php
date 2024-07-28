@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Calculation'])

    <div class="container-fluid py-4">
    <!-- Card Money -->
    <div class="row">
            <div class="col-12 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                    <form method="GET" action="{{ route('calculation.index') }}" onsubmit="return validateDates()">
                        <div class="row">
                            <div class="row">
                                <div class="col-md-4"> Start Date
                                    <input type="date" name="start_date" id="start_date" class="form-control" placeholder="Start Date" value="{{ request('start_date', $startDate) }}">
                                </div>
                                <div class="col-md-4"> End Date
                                    <input type="date" name="end_date" id="end_date" class="form-control" placeholder="End Date" value="{{ request('end_date', $endDate) }}">
                                </div>
                                <div class="col-md-2 d-flex align-items-end justify-content-center">
                                    <button type="submit" class="btn btn-info mb-0 px-5 mt-2">Filter</button>
                                </div>
                                <div class="col-md-2 d-flex align-items-end px-0 justify-content-center">
                                    <button type="button" class="btn btn-secondary mb-0 px-5 mt-2" onclick="clearDates()">Clear</button>
                                </div>
                            </div>
                            <div id="start_date_error" class="text-danger mt-1 text-sm"></div> <!-- Error message div -->
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
        <div class="col-xl-4 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Cash Payment</p>
                                    <h5 class="font-weight-bolder">
                                        Rp{{ number_format($cashMoney, 0, ',', '.') }}
                                    </h5>
                                    <p class="mb-0">from</p>
                                    <p class="mb-0">
                                        <span class="text-success text-sm font-weight-bolder">{{ $count }}</span>
                                        Cash Payment
                                    </p>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-success shadow-primary text-center rounded-circle">
                                    <i class="fa fa-money-bill text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Card Payment</p>
                                    <h5 class="font-weight-bolder">
                                        Rp{{ number_format($cardMoney, 0, ',', '.') }}
                                    </h5>
                                    <p class="mb-0">from</p>
                                    <p class="mb-0">
                                        <span class="text-success text-sm font-weight-bolder">{{ $card }}</span>
                                        Card Payment
                                    </p>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-info shadow-danger text-center rounded-circle">
                                    <i class="fa fa-credit-card text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">GlobalTix</p>
                                    <h5 class="font-weight-bolder">
                                        Rp{{ number_format($globaltixMoney, 0, ',', '.') }}
                                    </h5>
                                    <p class="mb-0">from</p>
                                    <p class="mb-0">
                                        <span class="text-success text-sm font-weight-bolder">{{ $globaltix }}</span>
                                        Global Tix
                                    </p>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                                    <i class="ni ni-world text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Qris Payment</p>
                                        <h5 class="font-weight-bolder">
                                            Rp{{ number_format($qrisMoney, 0, ',', '.') }}
                                        </h5>
                                        <p class="mb-0">from</p>
                                        <p class="mb-0">
                                            <span class="text-success text-sm font-weight-bolder">{{ $qris }}</span>
                                            Qris Payment
                                    </p>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                                    <i class="fas fa-qrcode text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Transfer Payment</p>
                                        <h5 class="font-weight-bolder">
                                            Rp{{ number_format($transferMoney, 0, ',', '.') }}
                                        </h5>
                                        <p class="mb-0">from</p>
                                        <p class="mb-0">
                                            <span class="text-success text-sm font-weight-bolder">{{ $transfer }}</span>
                                            Transfer Payment
                                    </p>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-secondary shadow-warning text-center rounded-circle">
                                    <i class="fas fa-dollar-sign text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Paid at Hotel</p>
                                        <h5 class="font-weight-bolder">
                                            Rp{{ number_format($paidMoney, 0, ',', '.') }}
                                        </h5>
                                        <p class="mb-0">from</p>
                                        <p class="mb-0">
                                            <span class="text-success text-sm font-weight-bolder">{{ $paid }}</span>
                                            Paid at Hotel
                                    </p>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-danger shadow-warning text-center rounded-circle">
                                    <i class="fas fa-hotel text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <h6>Custom Calculation</h6>
                    </div>
                    <div class="card-body">
                        <form id="calculationForm">
                            <div id="calculations">
                                <div class="calculation-row mb-3">
                                    <input type="text" name="formula[]" class="form-control" placeholder="Enter your formula (e.g., a + b - c)" required>
                                </div>
                            </div>
                            <button type="button" class="btn btn-secondary" onclick="addCalculationRow()">Add Another Calculation</button>
                            <button type="button" class="btn btn-primary" onclick="calculate()">Calculate</button>
                        </form>
                        <div id="result" class="mt-4">
                            <h5>Results</h5>
                            <ul id="resultsList" class="list-group">
                                <!-- Results will be appended here -->
                            </ul>
                        </div>
                    </div>
                    <div class="card-footer text-center pt-0 px-lg-2 px-1"></div>
                </div>
            </div>
        
        @include('layouts.footers.auth.footer')
    </div>

    <!-- Custom Calculation -->
    <script>
        function addCalculationRow() {
            const calculationsDiv = document.getElementById('calculations');
            const newCalculationRow = document.createElement('div');
            newCalculationRow.className = 'calculation-row mb-3';
            newCalculationRow.innerHTML = '<input type="text" name="formula[]" class="form-control" placeholder="Enter your formula (e.g., a + b - c)" required>';
            calculationsDiv.appendChild(newCalculationRow);
        }

        function calculate() {
            const form = document.getElementById('calculationForm');
            const formData = new FormData(form);
            const formulas = formData.getAll('formula[]');
            const resultsList = document.getElementById('resultsList');
            resultsList.innerHTML = '';

            formulas.forEach((formula, index) => {
                try {
                    const result = evalFormula(formula);
                    const resultItem = document.createElement('li');
                    resultItem.className = 'list-group-item';
                    resultItem.textContent = `Result of formula ${index + 1}: ${result}`;
                    resultsList.appendChild(resultItem);
                } catch (error) {
                    const errorItem = document.createElement('li');
                    errorItem.className = 'list-group-item text-danger';
                    errorItem.textContent = `Error in formula ${index + 1}: ${error.message}`;
                    resultsList.appendChild(errorItem);
                }
            });
        }

        function evalFormula(formula) {
            // Define variables that can be used in the formulas
            const variables = { a: 1, b: 2, c: 3, d: 4 }; // Example variables, you can modify this as needed
            const func = new Function(...Object.keys(variables), `return ${formula}`);
            return func(...Object.values(variables));
        }
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
@endsection
