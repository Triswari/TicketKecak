@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Restore'])
    @if(session()->has('success') || session()->has('error'))
        <div id="alert">
            @include('components.alert')
        </div>
    @endif
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-6">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Ticket Table</h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Deleted at</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">Title</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">Price</th>
                                        <th class="text-secondary opacity-7"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($deletedTickets as $ticket)
                                        <tr>
                                            <td class="text-center">
                                                <div class="d-flex py-1 justify-content-center">
                                                    <span class="text-secondary text-xs font-weight-bold">{{ $ticket->deleted_at }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ $ticket->title }}</p>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span class="text-secondary text-xs font-weight-bold">Rp{{ number_format($ticket->price_ticket, 0, ',', '.') }}</span>
                                            </td>
                                            <td class="text-center align-middle">
                                                <form action="{{ route('tickets.restore', $ticket->id_ticket) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success">Restore</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Additional Table</h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Deleted at</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">Title</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">Price</th>
                                        <th class="text-secondary opacity-7"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($deletedAdd as $add)
                                        <tr>
                                            <td class="text-center">
                                                <div class="d-flex py-1 justify-content-center">
                                                    <span class="text-secondary text-xs font-weight-bold">{{ $add->deleted_at }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ $add->name_add }}</p>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span class="text-secondary text-xs font-weight-bold">Rp{{ number_format($add->price_add, 0, ',', '.') }}</span>
                                            </td>
                                            <td class="text-center align-middle">
                                                <form action="{{ route('add.restore', $add->id_add) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success">Restore</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Booking Table</h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Deleted at</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">Name</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">Nationality</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">Qty. Ticket</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">Hostelry</th>
                                        <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">Payment Method</th>
                                        <th class="text-secondary opacity-7"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($deletedBookings as $booking)
                                        <tr>
                                            <td class="text-center">
                                                <div class="d-flex py-1 ps-3">
                                                    <span class="text-secondary text-xs font-weight-bold">{{ $booking->deleted_at }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ $booking->name }}</p>
                                            </td>
                                            <td class="align-middle">
                                                <span class="text-secondary text-xs font-weight-bold">{{ $booking->nationality }}</span>
                                            </td>
                                            <td class="align-middle">
                                                <span class="text-secondary text-xs font-weight-bold">{{ $booking->qty_ticket }}</span>
                                            </td>
                                            <td class="align-middle">
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
                                            @elseif ($booking->paymentMethod_ticket == "Hotel")
                                            <td class="align-middle text-center text-sm">
                                                <span class="badge badge-sm bg-gradient-danger">Hotel</span>
                                            </td>
                                            @else
                                            <td class="align-middle text-center text-sm">
                                                <span class="badge badge-sm bg-gradient-danger">Delay</span>
                                            </td>
                                            @endif
                                            <td class="text-center align-middle">
                                                <form action="{{ route('booking.restore', $booking->id_booking) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success">Restore</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>User Table</h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Deleted at</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">Username</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">Email</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">Role</th>
                                        <th class="text-secondary opacity-7"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($deletedUser as $user)
                                        <tr>
                                            <td class="text-center">
                                                <div class="d-flex py-1 ps-3">
                                                    <span class="text-secondary text-xs font-weight-bold">{{ $user->deleted_at }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ $user->username }}</p>
                                            </td>
                                            <td class="align-middle">
                                                <span class="text-secondary text-xs font-weight-bold">{{ $user->email }}</span>
                                            </td>
                                            <td class="align-middle">
                                                <span class="text-secondary text-xs font-weight-bold">{{ $user->role }}</span>
                                            </td>
                                            <td class="text-center align-middle">
                                                <form action="{{ route('user.restore', $user->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success">Restore</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth.footer')
    </div>
@endsection
