@extends('layouts.dashboard')
@section('title','categories')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Categories</li>
@endsection

@section('content')

    <div class="mb-5">
        <a href="{{ route('dashboard.categories.create') }}" class="btn btn-sm btn-outline-primary mr-2">Create</a>
    </div>

    @if(session()->has('success'))
        <div class="alert alert-success">
            {{session('success')}}
        </div>
    @endif

    <table class="table">
        <thead>
        <tr>
            <th></th>
            <th>Id</th>
            <th>Name</th>
            <th>Parent</th>
            <th>Created At</th>
            <th></th>
            <th></th>
        </tr>
        </thead>

        <tbody>
        @forelse($categories as $category)
            <tr>
                <td></td>
                <td>{{$category->id}}</td>
                <td>{{$category->name}}</td>
                <td>{{$category->parent_id}}</td>
                <td>{{$category->created_at}}</td>
                <td>
                    <a href="{{ route('dashboard.categories.edit', $category->id) }}" class="btn btn-sm btn-outline-success">Edit</a>
                </td>
                <td>
                    <form action="{{ route('dashboard.categories.destroy', $category->id) }}" method="POST">
                        @csrf
                        <!-- Form Method Spoofing -->
                        <input type="hidden" name="_method" value="delete">
                        @method('delete')
                        <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7"> no categories found</td>
            </tr>
            @endforelse
        </tbody>

    </table>

@endsection
