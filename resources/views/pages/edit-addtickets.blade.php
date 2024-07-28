@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Edit Ticket'])

    @if(session()->has('success') || session()->has('error'))
    <div id="alert">
        @include('components.alert')
    </div>
    @endif
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <h6>Edit Ticket</h6>
                    </div>
                    <button type="button" class="btn btn-link text-danger py-0 ms-auto mb-0 d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#deleteModal">
                        <i class="fas fa-trash-alt text-danger me-2"></i>Delete
                    </button>
                    <div class="card-body">
                        <form action="{{ route('addtickets.update', $ticket->id_ticket) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="name">ID</label>
                                <input type="text" class="form-control" name="id_ticket" value="{{ $ticket->id_ticket }}" required readonly>
                            </div>
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" name="title" value="{{ $ticket->title }}" required>
                            </div>
                            <div class="form-group">
                                <label for="price">Price</label>
                                <input type="number" class="form-control" name="price_ticket" value="{{ $ticket->price_ticket }}" required>
                            </div>
                            <button type="submit" class="btn btn-dark">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth.footer')
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-0">
                    <h5 class="modal-title text-center mb-2 fs-4" id="deleteModalLabel">Confirm Delete</h5>
                    <p class="text-center mb-0">Are you sure you want to delete this ticket?</p>
                    <p class="text-center mb-0">This action cannot be undone.</p>
                </div>
                <div class="modal-footer d-flex justify-content-center border-0">
                    <button type="button" class="btn btn-secondary px-6" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteForm" action="{{ route('addtickets.destroy', $ticket->id_ticket) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger px-6">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal pop up -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Ensure the modal is centered
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'), {
            backdrop: 'static',
            keyboard: false
        });

        document.querySelectorAll('[data-bs-toggle="modal"]').forEach(button => {
            button.addEventListener('click', function() {
                deleteModal.show();
            });
        });
    });
</script>

@endsection


