@extends('layouts.dashboard')
@section('title','trash categories')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Categories</li>
@endsection

@section('content')

    <div class="mb-5">
        <a href="{{ route('dashboard.categories.index') }}" class="btn btn-sm btn-outline-primary">Back</a>
    </div>

    <x-alert type="success"/>

    <form action="{{ URL::current()}}" method="GET" class="d-flex justify-content-between mb-4">
        <x-form.input name="name" placeholder="Name" class="mx-2" :value="request('name')"/>
        <select name="status" class="form-control mx-2">
            <option value="">All</option>
            <option value="active" @selected(request('status')=='active')>Active</option>
            <option value="archived" @selected(request('status')=='archived')>Archived</option>
        </select>
        <button class="btn btn-dark mx-2">Filter</button>
    </form>

    <table class="table">
        <thead>
        <tr>
            <th>Image</th>
            <th>Id</th>
            <th>Name</th>
            <th>Status</th>
            <th>Deleted At</th>
            <th></th>
            <th></th>
        </tr>
        </thead>

        <tbody>
        @forelse($categories as $category)
            <tr>
                <td> <img src="{{asset('storage/' . $category->image)}}" alt="" height="50"> </td>
                <td>{{$category->id}}</td>
                <td>{{$category->name}}</td>
                <td>{{$category->status}}</td>
                <td>{{$category->deleted_at}}</td>
                <td>
                    <form action="{{ route('dashboard.categories.restore', $category->id) }}" method="POST">
                        @csrf
                        @method('put')
                        <button type="submit" class="btn btn-sm btn-outline-info">Restore</button>
                    </form>
                </td>
                <td>
                    <form action="{{ route('dashboard.categories.force-delete', $category->id) }}" method="POST">
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

    {{$categories->withQueryString()->appends(['search'=>1])->links()}}

@endsection
