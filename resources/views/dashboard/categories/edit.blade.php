@extends('layouts.dashboard')
@section('title','categories edit')

@section('content')
    <div class="container mt-4">
        <h3 class="mb-4">Edit Category</h3>

        <form action="{{ route('dashboard.categories.update',$category->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('put')

            @include('dashboard.categories._form')

        </form>
    </div>
@endsection
