@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Dashboard'])
    <!-- Dashboard User -->
    @if(in_array(Auth::user()->role, ['user']))
    <div class="container-fluid py-4">
    <div class="row">
            <!-- Filter by date -->
            <div class="col-12 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                    <form method="GET" action="{{ route('home') }}" onsubmit="return validateDates()">
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
        <!-- Card money -->
        <div class="row">
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Cash Money</p>
                                    <h5 class="font-weight-bolder">
                                        Rp{{ number_format($cashMoney, 0, ',', '.') }}
                                    </h5>
                                    <p class="mb-0">from</p>
                                    <p class="mb-0">
                                        <span class="text-success text-sm font-weight-bolder">{{ $count }}</span>
                                        Cash ticket
                                    </p>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-warning shadow-primary text-center rounded-circle">
                                    <i class="fas fa-money-bill text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Visitor</p>
                                    <h5 class="font-weight-bolder">
                                        {{ $ticket }}
                                    </h5>
                                    <p class="mb-0">
                                        <span class="text-success text-sm font-weight-bolder">{{ $domestic }}</span>
                                        Domestic
                                    </p>
                                    <p class="mb-0">
                                        <span class="text-success text-sm font-weight-bolder">{{ $foreign }}</span>
                                        Foreign
                                    </p>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-info shadow-danger text-center rounded-circle">
                                    <i class="ni ni-world text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
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
                                        Ticket
                                    </p>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                                    <i class="fas fa-qrcode text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Sales</p>
                                    <h5 class="font-weight-bolder">
                                        Rp{{ number_format($totalPayment, 0, ',', '.') }}
                                    </h5>
                                    <p class="mb-0">
                                        <span class="text-secondary text-sm font-weight-bolder">Fix Money</span>
                                    </p>
                                    @php
                                        $sales = $totalPayment - $totalDelay - $cms;
                                    @endphp
                                    <p class="mb-0 font-weight-bolder">
                                        =
                                        <span class="text-success text-sm font-weight-bolder">Rp{{ number_format($sales, 0, ',', '.') }}</span>
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
        </div>
        <div class="row mt-4">
            <div class="col-lg-6 mb-lg-0 mb-4">
                <div class="card z-index-2 h-100">
                    <div class="card-header pb-0 pt-3 bg-transparent">
                        <h6 class="text-capitalize">Visitor Country</h6>
                        <p class="text-sm mb-0">
                            <i class="fa fa-user text-success pe-1"></i>
                            <span class="font-weight-bold">{{ $ticket }}</span> Visitor
                        </p>
                    </div>
                    <div class="card-body p-3">
                        <div class="chart">
                            <canvas id="visitorChart" class="chart-canvas" height="300"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="z-index-2 col-lg-3">
                <div class="card card-carousel overflow-hidden h-100 p-0">
                    <div id="carouselExampleCaptions" class="carousel slide h-100" data-bs-ride="carousel">
                        <div class="carousel-inner border-radius-lg h-100 d-flex justify-content-center">
                            <div class="col-lg-12 d-flex justify-content-center">
                            <div class="">
                            <div class="">
                                <div class="card my-2">
                                    <div class="card-body p-3">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="numbers">
                                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Commission</p>
                                                    
                                                    <h5 class="font-weight-bolder text-primary">
                                                        Rp{{ number_format($cms, 0, ',', '.') }}
                                                    </h5>
                                                    <p class="mb-0">from</p>
                                                    <p class="mb-0">
                                                        <span class="text-success text-sm font-weight-bolder">{{ $cmsTicket }}</span>
                                                        Ticket
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-12 text-end">
                                                <div class="icon icon-shape bg-gradient-warning shadow-primary text-center rounded-circle">
                                                    <i class="fas fa-user text-lg opacity-10" aria-hidden="true"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-12 col-sm-12 mb-xl-0 mb-4 pe-0">
                                <div class="card">
                                    <div class="card-body p-3">
                                        <div class="row">
                                            <div class="col-12 mobile-pe-7">
                                                <div class="numbers">
                                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Other Payment</p>
                                                    <h5 class="font-weight-bolder">
                                                        Rp{{ number_format($otherPayment, 0, ',', '.') }}
                                                    </h5>
                                                    <div class="d-flex">
                                                        <p class="mb-0">
                                                            <span class="text-danger text-sm font-weight-bolder">{{ $paid }}</span>
                                                            Paid
                                                        </p>
                                                        <p class="mb-0 ms-auto">
                                                            <span class="text-primary text-sm font-weight-bolder">{{ $qris }}</span>
                                                            QRIS
                                                        </p>
                                                    </div>
                                                    <div class="d-flex">
                                                        <p class="mb-0">
                                                            <span class="text-secondary text-sm font-weight-bolder">{{ $transfer }}</span>
                                                            Tf
                                                        </p>
                                                        <p class="mb-0 ms-auto">
                                                            <span class="text-info text-sm font-weight-bolder">{{ $card }}</span>
                                                            Card
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 text-end">
                                                <div class="icon icon-shape bg-gradient-info shadow-danger text-center rounded-circle">
                                                    <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="z-index-2 col-lg-3 mobile">
                <div class="card card-carousel overflow-hidden h-100 p-0">
                    <div id="carouselExampleCaptions" class="carousel slide h-100" data-bs-ride="carousel">
                        <div class="carousel-inner border-radius-lg h-100 d-flex justify-content-center">
                            <div class="col-lg-12 d-flex justify-content-center">
                            <div class="">
                            <div class="">
                                <div class="card my-2">
                                    <div class="card-body p-3">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="numbers">
                                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Delay Payment</p>
                                                    <h5 class="font-weight-bolder text-danger">
                                                        Rp{{ number_format($totalDelay, 0, ',', '.') }}
                                                    </h5>
                                                    <p class="mb-0">from</p>
                                                    <p class="mb-0">
                                                        <span class="text-success text-sm font-weight-bolder">{{ $delay }}</span>
                                                        Ticket
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-12 text-end">
                                                <div class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">
                                                    <i class="fas fa-hourglass-half text-lg opacity-10" aria-hidden="true"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                            <div class="col-xl-12 col-sm-12 mb-xl-0 mb-4 pe-0">
                                <div class="card">
                                    <div class="card-body p-3">
                                        <div class="row">
                                            <div class="col-12 mobile-pe1-7">
                                                <div class="numbers">
                                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Additionals</p>
                                                    <h5 class="font-weight-bolder">
                                                        Rp{{ number_format($totalAdd, 0, ',', '.') }}
                                                    </h5>
                                                    <p class="mb-0">from</p>
                                                    <p class="mb-0">
                                                        <span class="text-secondary text-sm font-weight-bolder">{{ $add }}</span>
                                                        Additional
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-12 text-end">
                                                <div class="icon icon-shape bg-gradient-success shadow-danger text-center rounded-circle">
                                                    <i class="fas fa-box text-lg opacity-10" aria-hidden="true"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>       
        </div>
        @include('layouts.footers.auth.footer')
    </div>
    @endif

    <!-- Dashboard admin & super admin -->
    @if(in_array(Auth::user()->role, ['super_admin', 'admin']))
    <div class="container-fluid py-4">
    <div class="row">
            <!-- filter by date -->
            <div class="col-12 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                    <form method="GET" action="{{ route('home') }}" onsubmit="return validateDates()">
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

        <!-- Card money -->
        <div class="row">
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Cash Money</p>
                                    <h5 class="font-weight-bolder">
                                        Rp{{ number_format($cashMoney, 0, ',', '.') }}
                                    </h5>
                                    <p class="mb-0">from</p>
                                    <p class="mb-0">
                                        <span class="text-success text-sm font-weight-bolder">{{ $count }}</span>
                                        Cash ticket
                                    </p>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-warning shadow-primary text-center rounded-circle">
                                    <i class="fas fa-money-bill text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Visitor</p>
                                    <h5 class="font-weight-bolder">
                                        {{ $ticket }}
                                    </h5>
                                    <p class="mb-0">
                                        <span class="text-success text-sm font-weight-bolder">{{ $domestic }}</span>
                                        Domestic
                                    </p>
                                    <p class="mb-0">
                                        <span class="text-success text-sm font-weight-bolder">{{ $foreign }}</span>
                                        Foreign
                                    </p>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-info shadow-danger text-center rounded-circle">
                                    <i class="ni ni-world text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
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
                                        Ticket
                                    </p>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                                    <i class="fas fa-qrcode text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Sales</p>
                                    <h5 class="font-weight-bolder">
                                        Rp{{ number_format($totalPayment, 0, ',', '.') }}
                                    </h5>
                                    <p class="mb-0">
                                        <span class="text-secondary text-sm font-weight-bolder">Fix Money</span>
                                    </p>
                                    @php
                                        $sales = $totalPayment - $totalDelay - $cms;
                                    @endphp
                                    <p class="mb-0 font-weight-bolder">
                                        =
                                        <span class="text-success text-sm font-weight-bolder">Rp{{ number_format($sales, 0, ',', '.') }}</span>
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
        </div>
        <div class="row mt-4">
            <div class="col-lg-6 mb-lg-0 mb-4">
                <div class="card z-index-2 h-100">
                    <div class="card-header pb-0 pt-3 bg-transparent">
                        <h6 class="text-capitalize">Visitor Country</h6>
                        <p class="text-sm mb-0">
                            <i class="fa fa-user text-success pe-1"></i>
                            <span class="font-weight-bold">{{ $ticket }}</span> Visitor
                        </p>
                    </div>
                    <div class="card-body p-3">
                        <div class="chart">
                            <canvas id="visitorChart" class="chart-canvas" height="300"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="z-index-2 col-lg-3">
                <div class="card card-carousel overflow-hidden h-100 p-0">
                    <div id="carouselExampleCaptions" class="carousel slide h-100" data-bs-ride="carousel">
                        <div class="carousel-inner border-radius-lg h-100 d-flex justify-content-center">
                            <div class="col-lg-12 d-flex justify-content-center">
                            <div class="">
                            <div class="">
                                <div class="card my-2">
                                    <div class="card-body p-3">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="numbers">
                                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Commission</p>
                                                    
                                                    <h5 class="font-weight-bolder text-primary">
                                                        Rp{{ number_format($cms, 0, ',', '.') }}
                                                    </h5>
                                                    <p class="mb-0">from</p>
                                                    <p class="mb-0">
                                                        <span class="text-success text-sm font-weight-bolder">{{ $cmsTicket }}</span>
                                                        Ticket
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-12 text-end">
                                                <div class="icon icon-shape bg-gradient-warning shadow-primary text-center rounded-circle">
                                                    <i class="fas fa-user text-lg opacity-10" aria-hidden="true"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-12 col-sm-12 mb-xl-0 mb-4 pe-0">
                                <div class="card">
                                    <div class="card-body p-3">
                                        <div class="row">
                                            <div class="col-12 mobile-pe-7">
                                                <div class="numbers">
                                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Other Payment</p>
                                                    <h5 class="font-weight-bolder">
                                                        Rp{{ number_format($otherPayment, 0, ',', '.') }}
                                                    </h5>
                                                    <div class="d-flex">
                                                        <p class="mb-0">
                                                            <span class="text-danger text-sm font-weight-bolder">{{ $paid }}</span>
                                                            Paid
                                                        </p>
                                                        <p class="mb-0 ms-auto">
                                                            <span class="text-primary text-sm font-weight-bolder">{{ $qris }}</span>
                                                            QRIS
                                                        </p>
                                                    </div>
                                                    <div class="d-flex">
                                                        <p class="mb-0">
                                                            <span class="text-secondary text-sm font-weight-bolder">{{ $transfer }}</span>
                                                            Tf
                                                        </p>
                                                        <p class="mb-0 ms-auto">
                                                            <span class="text-info text-sm font-weight-bolder">{{ $card }}</span>
                                                            Card
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 text-end">
                                                <div class="icon icon-shape bg-gradient-info shadow-danger text-center rounded-circle">
                                                    <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="z-index-2 col-lg-3 mobile">
                <div class="card card-carousel overflow-hidden h-100 p-0">
                    <div id="carouselExampleCaptions" class="carousel slide h-100" data-bs-ride="carousel">
                        <div class="carousel-inner border-radius-lg h-100 d-flex justify-content-center">
                            <div class="col-lg-12 d-flex justify-content-center">
                            <div class="">
                            <div class="">
                                <div class="card my-2">
                                    <div class="card-body p-3">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="numbers">
                                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Delay Payment</p>
                                                    <h5 class="font-weight-bolder text-danger">
                                                        Rp{{ number_format($totalDelay, 0, ',', '.') }}
                                                    </h5>
                                                    <p class="mb-0">from</p>
                                                    <p class="mb-0">
                                                        <span class="text-success text-sm font-weight-bolder">{{ $delay }}</span>
                                                        Ticket
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-12 text-end">
                                                <div class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">
                                                    <i class="fas fa-hourglass-half text-lg opacity-10" aria-hidden="true"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                            <div class="col-xl-12 col-sm-12 mb-xl-0 mb-4 pe-0">
                                <div class="card">
                                    <div class="card-body p-3">
                                        <div class="row">
                                            <div class="col-12 mobile-pe1-7">
                                                <div class="numbers">
                                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Additionals</p>
                                                    <h5 class="font-weight-bolder">
                                                        Rp{{ number_format($totalAdd, 0, ',', '.') }}
                                                    </h5>
                                                    <p class="mb-0">from</p>
                                                    <p class="mb-0">
                                                        <span class="text-secondary text-sm font-weight-bolder">{{ $add }}</span>
                                                        Additional
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-12 text-end">
                                                <div class="icon icon-shape bg-gradient-success shadow-danger text-center rounded-circle">
                                                    <i class="fas fa-box text-lg opacity-10" aria-hidden="true"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        <div class="row mt-4">
            <!-- Commissions table -->
            <div class="col-lg-12 mb-lg-0 mb-4">
                <div class="card">
                    <div class="card-header pb-0 p-3">
                        <div class="d-flex justify-content-between">
                            <h6 class="mb-2">Commissions Table</h6>
                        </div>
                    </div>
                    <form method="GET" action="{{ route('home') }}" id="search-form">
                        <div class="row card-body py-2" id="search-criteria">
                            <div class="row col-md-8">
                                    @if(!empty($searchColumns))
                                        @foreach($searchColumns as $index => $column)
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label for="search_column">Search By</label>
                                                    <select name="search_columns[]" class="form-control search-column" data-index="{{ $index }}">
                                                        <option value="name" {{ $column == 'name' ? 'selected' : '' }}>Guest</option>
                                                        <option value="name_receiver" {{ $column == 'name_receiver' ? 'selected' : '' }}>Receiver</option>
                                                        <option value="qty_ticket" {{ $column == 'qty_ticket' ? 'selected' : '' }}>Quantity Ticket</option>
                                                        <option value="type_receiver" {{ $column == 'type_receiver' ? 'selected' : '' }}>Type of Receiver</option>
                                                        <option value="total_cms" {{ $column == 'total_cms' ? 'selected' : '' }}>Total Commission</option>
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
                                                    <option value="name">Guest</option>
                                                    <option value="name_receiver">Receiver</option>
                                                    <option value="qty_ticket">Quantity Ticket</option>
                                                    <option value="type_receiver">Type of Receiver</option>
                                                    <option value="total_cms">Total Commission</option>
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
                                        <a href="{{ route('home') }}" class="btn btn-secondary mr-2 me-3 d-flex align-items-center">Clear</a>
                                        <button type="button" class="btn btn-info" id="add-criteria">Add Criteria</button>
                                    </div>
                                </div>
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table class="table lh-table-home align-items-center">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        @sortablelink('created_at', 'Date')
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        @sortablelink('name_receiver', 'Receiver')
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        @sortablelink('type_receiver', 'Type Of Receiver')
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        @sortablelink('name', 'Guest')
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                        @sortablelink('qty_ticket', 'Qty.')
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">
                                        @sortablelink('total_cms', 'Total Commission')
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $index => $item)
                                    @if(!empty($item->name_receiver))
                                        <!-- Tampilkan data jika kolom 'name' tidak kosong -->
                                        <tr>
                                            <td class="text-center">
                                                <div class="d-flex px-3 py-1">
                                                    <span class="text-secondary text-xs font-weight-bold">{{ $item->created_at ? $item->created_at->format('Y-m-d') : 'N/A' }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ $item->name_receiver }}</p>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ $item->type_receiver }}</p>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ $item->name }}</p>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span class="text-secondary text-xs font-weight-bold">{{ $item->qty_ticket }}</span>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <p class="text-xs font-weight-bold mb-0">Rp{{ number_format($item->total_cms, 0, ',', '.') }}</p>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                        <div class="mx-3 d-flex justify-content-between align-items-center">
                            <div>
                                <form action="{{ route('home') }}" method="GET">
                                    <label for="items_per_page" class="form-label">Items per page:</label>
                                    <select name="items_per_page" id="items_per_page" class="form-select mb-3" onchange="this.form.submit()">
                                        <option value="10" {{ request('items_per_page') == 10 ? 'selected' : '' }}>10</option>
                                        <option value="25" {{ request('items_per_page') == 25 ? 'selected' : '' }}>25</option>
                                        <option value="50" {{ request('items_per_page') == 50 ? 'selected' : '' }}>50</option>
                                        <option value="100" {{ request('items_per_page') == 100 ? 'selected' : '' }}>100</option>
                                    </select>
                                </form>
                            </div>
                            <div class="mx-3">
                                {{ $data->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Commission Calculation -->
            <div class="col-lg-6 mt-4">
                <div class="card">
                    <div class="card-header pb-0 p-3">
                        <h6 class="mb-0">Commission Calculation</h6>
                    </div>
                    <div class="card-body p-3">
                    <div class="container">
                        <form method="POST" action="{{ route('dashboard.hitung') }}">
                            @csrf
                                <div class="mb-3">
                                    <label for="ticket" class="form-label">Qty. Ticket</label>
                                    <input type="number" step="any" id="ticket" name="ticket" class="form-control" value="{{ old('ticket', $count) }}">
                                </div>
                                <div class="mb-3">
                                    <label for="price" class="form-label">Price Ticket</label>
                                    <input type="number" step="any" id="price" name="price" class="form-control" value="{{ old('price') }}">
                                </div>
                                <div class="mb-3">
                                    <label for="receiver" class="form-label">Qty. Commsission Ticket</label>
                                    <input type="number" step="any" id="receiver" name="receiver" class="form-control" value="{{ old('receiver', $cmsTicket) }}">
                                </div>
                                <div class="mb-4">
                                    <label for="nominal" class="form-label">Nominal Commission</label>
                                    <input type="number" step="any" id="nominal" name="nominal" class="form-control" value="{{ old('nominal') }}">
                                </div>
                                <button type="submit" class="mt-1 mb-4 btn btn-info">Calculate</button>
                        </form>
                        @if (session()->has('money'))
                            <div class="mt-4">
                                <h5>Cash Ticket: {{ session('ticket') }} x Rp{{ number_format(session('price'), 0, ',', '.') }} = Rp{{ number_format(session('cash'), 0, ',', '.') }}</h5>
                                <h5>Commission: {{ session('receiver') }} x Rp{{ number_format(session('nominal'), 0, ',', '.') }} = Rp{{ number_format(session('commission'), 0, ',', '.') }}</h5>
                                <h5>Money: Rp{{ number_format(session('cash'), 0, ',', '.') }} - Rp{{ number_format(session('commission'), 0, ',', '.') }} = Rp{{ number_format(session('money'), 0, ',', '.') }}</h5>
                            </div>
                        @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Note -->
            <div class="z-index-2 col-lg-6 mt-4">
                <div class="card card-carousel overflow-hidden h-100 p-0">
                    <div id="carouselExampleCaptions" class="carousel slide h-100" data-bs-ride="carousel">
                        <div class="carousel-inner border-radius-lg h-100">
                            <div class="popup-box body-note">
                                <div class="popup">
                                    <div class="content">
                                    <header>
                                        <p class="mb-0"></p>
                                        <i class="uil uil-times"></i>
                                    </header>
                                    <form action="#" class="form-note">
                                        <div class="row title btn-note">
                                        <label>Title</label>
                                        <input type="text" spellcheck="false">
                                        </div>
                                        <div class="row description btn-note">
                                        <label>Description</label>
                                        <textarea spellcheck="false"></textarea>
                                        </div>
                                        <div class="btn-note">
                                        <button class="fas fa-plus"></button></div>
                                    </form>
                                    </div>
                                </div>
                            </div>
                            <div class="wrapper-note">
                                <li class="add-box-note">
                                    <div class="icon-note"><i class="uil uil-plus"></i></div>
                                    <p>Add new note</p>
                                </li>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @include('layouts.footers.auth.footer')
    </div>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="{{ asset('vendor/larapex-charts/apexcharts.min.js') }}"></script>

    <!-- button clear filter by date -->
    <script>
        function clearDates() {
            document.querySelector('input[name="start_date"]').value = '';
            document.querySelector('input[name="end_date"]').value = '';
        }
    </script>

    <!-- Search by data commission table -->
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
                                <option value="name">Guest</option>
                                <option value="name_receiver">Receiver</option>
                                <option value="qty_ticket">Quantity Ticket</option>
                                <option value="type_receiver">Type of Receiver</option>
                                <option value="total_cms">Total Commission</option>
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
@endsection
