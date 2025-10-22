@extends('layouts.app')

@section('content')
<div class="flex h-screen bg-gray-100">
    @include('layouts.sidebar')

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden">
        @yield('main-content')
    </div>
</div>
@endsection
