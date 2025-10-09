@extends('layouts.dashboard')
@section('title','categories create')

@section('content')
    <div class="container mt-4">
        <h3 class="mb-4">Add New Category</h3>

        <form action="{{ route('dashboard.categories.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            @include('dashboard.categories._form')

        </form>
    </div>
@endsection
