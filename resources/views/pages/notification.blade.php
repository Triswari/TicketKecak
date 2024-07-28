@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Notifications'])

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
                        <h6>Notifications</h6>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            @foreach($notifications as $notification)
                            <div class="list-group-item d-flex justify-content-between notif {{ in_array($notification->type, ['success', 'update']) ? 'bg-gradient-notif' : 'bg-gradient-warning' }}">
                                <div class="col-md-6">
                                    <strong>{{ ucfirst($notification->type) }}</strong> 
                                    <small class="notif-small">{{ $notification->created_at->diffForHumans() }}</small>
                                    <br>
                                    {{ $notification->message }}
                                </div>
                                <div class="notif-date">
                                    {{ $notification->created_at->format('d M Y H:i') }}
                                </div>
                                <form action="{{ route('notifications.destroy', $notification->id_notification) }}" method="POST" style="display: inline;" class="d-flex align-items-center">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="mb-0 btn btn-danger">
                                        <i class="far fa-trash-alt text-white"></i>
                                    </button>
                                </form>
                            </div>
                            @endforeach
                        </ul>
                    </div>
                    <div class="card-footer text-center pt-0 px-lg-2 px-1">
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth.footer')
    </div>
@endsection
