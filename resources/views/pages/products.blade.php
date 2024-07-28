@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Products'])

    @if(session()->has('success') || session()->has('error'))
    <div id="alert">
        @include('components.alert')
    </div>
    @endif
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Tickets</h6>
                        <a href="{{ route('addtickets.create') }}" class="btn btn-info btn-sm">Add Ticket</a>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="row m-2">
                            @foreach($tickets as $ticket)
                            <div class="col-md-4">
                                <div class="card mb-4">
                                    <div class="card-body bg-gradient-info border-radius">
                                        <h5 class="card-title text-white">ID Ticket: {{ $ticket->id_ticket }}</h5>
                                        <h5 class="card-title">{{ $ticket->title }}</h5>
                                        <p class="card-text white">Rp{{ number_format($ticket->price_ticket, 0, ',', '.') }}</p>
                                        <a href="{{ route('addtickets.edit', $ticket->id_ticket) }}" class="btn btn-dark btn-sm">Edit</a>
                                        <form id="deleteForm{{ $ticket->id_ticket }}" action="{{ route('addtickets.destroy', $ticket->id_ticket) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $ticket->id_ticket }}">Delete</button>
                                        </form>
                                        <!-- Modal -->
                                        <div class="modal fade" id="deleteModal{{ $ticket->id_ticket }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $ticket->id_ticket }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                <div class="modal-header border-0">
                                                    <button type="button" class="btn-close modal1" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body pt-0">
                                                    <h5 class="modal-title d-flex justify-content-sm-center text-bolder mb-2 fs-4" id="deleteModalLabel{{ $ticket->id_ticket }}">Confirm Delete</h5>
                                                    <p class="d-flex justify-content-sm-center mb-0" id="deleteModalLabel{{ $ticket->id_ticket }}">Are you sure you want to delete this data?</p>
                                                    <p class="d-flex justify-content-sm-center mb-0" id="deleteModalLabel{{ $ticket->id_ticket }}">This action cannot be undone.</p>
                                                </div>
                                                <div class="modal-footer d-flex justify-content-sm-center border-0">
                                                    <button type="button" class="btn btn-secondary px-6" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="button" class="btn btn-danger px-6" id="confirmDelete{{ $ticket->id_ticket }}">Delete</button>
                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Additionals</h6>
                        <a href="{{ route('additionals.create') }}" class="btn btn-secondary btn-sm">Add Additional</a>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="row m-2">
                            @foreach($additionals as $additional)
                            <div class="col-md-4">
                                <div class="card mb-4">
                                    <div class="card-body bg-gradient-secondary border-radius">
                                        <h5 class="card-title text-white">ID Additional: {{ $additional->id_add }}</h5>
                                        <h5 class="card-title">{{ $additional->name_add }}</h5>
                                        <p class="card-text white">Rp{{ number_format($additional->price_add, 0, ',', '.') }}</p>
                                        <a href="{{ route('additionals.edit', $additional->id_add) }}" class="btn btn-dark btn-sm">Edit</a>
                                        <form id="deleteForm{{ $additional->id_add }}" action="{{ route('additionals.destroy', $additional->id_add) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $additional->id_add }}">Delete</button>
                                        </form>
                                        <!-- Modal -->
                                        <div class="modal fade" id="deleteModal{{ $additional->id_add }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $additional->id_add }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                <div class="modal-header border-0">
                                                    
                                                    <button type="button" class="btn-close modal1" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body pt-0">
                                                    <h5 class="modal-title d-flex justify-content-sm-center text-bolder mb-2 fs-4" id="deleteModalLabel{{ $additional->id_add }}">Confirm Delete</h5>
                                                    <p class="d-flex justify-content-sm-center mb-0" id="deleteModalLabel{{ $additional->id_add }}">Are you sure you want to delete this data?</p>
                                                    <p class="d-flex justify-content-sm-center mb-0" id="deleteModalLabel{{ $additional->id_add }}">This action cannot be undone.</p>
                                                </div>
                                                <div class="modal-footer d-flex justify-content-sm-center border-0">
                                                    <button type="button" class="btn btn-secondary px-6" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="button" class="btn btn-danger px-6" id="confirmDelete{{ $additional->id_add }}">Delete</button>
                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>
        </div>
        @include('layouts.footers.auth.footer')
    </div>

<!-- modal pop up -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        @foreach($tickets as $ticket)
            document.getElementById('confirmDelete{{ $ticket->id_ticket }}').addEventListener('click', function () {
                document.getElementById('deleteForm{{ $ticket->id_ticket }}').submit();
            });
        @endforeach

        @foreach($additionals as $additional)
            document.getElementById('confirmDelete{{ $additional->id_add }}').addEventListener('click', function () {
                document.getElementById('deleteForm{{ $additional->id_add }}').submit();
            });
        @endforeach
    });
</script>
@endsection