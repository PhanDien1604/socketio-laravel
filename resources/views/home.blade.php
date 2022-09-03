@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-4">
            <div class="card">
                <div class="card-header">
                    Friend
                </div>
                <div class="card-body">
                    <div class="friends">
                        @foreach ($friends as $friend)
                        <aside class="info">
                            <div class="avatar">
                                <img src="{{ asset('images/user.png') }}" alt="">
                            </div>
                            <h5 class="name">{{ $friend['name'] }}</h5>
                            <input type="hidden" class="friend_id" name="" value="{{ $friend['id'] }}">
                        </aside>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="col-8">
            <div class="card box-chat">
                <div class="card-header">
                    <aside class="info">
                        <div class="avatar">
                            <img src="{{ asset('images/user.png') }}" alt="">
                        </div>
                        <h5 class="name receiver-name"></h5>
                    </aside>
                </div>
                <div class="card-body">
                    <div class="box-messages border rounded">
                        {{-- content messages --}}
                    </div>

                    <form id="form-chat" action="" method="get">
                        <input type="hidden" class="receiver_id" name="receiver_id" value="{{ $friend['id'] }}">

                        <div class="form-group mt-3">
                            <textarea id="content-message" class="form-control" rows="5" placeholder="Enter your message" required></textarea>
                            <button id="form-submit" class="btn btn-success mt-3">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
@endpush
