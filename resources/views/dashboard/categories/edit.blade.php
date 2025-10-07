@extends('layouts.dashboard')
@section('title','categories edit')

@section('content')
    <div class="container mt-4">
        <h3 class="mb-4">Edit Category</h3>

        <form action="{{ route('dashboard.categories.update',$category->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="mb-3">
                <label for="name" class="form-label">Category Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{$category->name}}" placeholder="Enter category name" required>
            </div>

            <div class="mb-3">
                <label for="parent_id" class="form-label">Category Parent</label>
                <select name="parent_id" id="parent_id" class="form-select">
                    <option value="">Primary Category</option>
                    @foreach($parents as $parent)
                        <option value="{{ $parent->id }}" @selected($category->parent_id == $parent->id)>{{ $parent->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" rows="3" class="form-control" placeholder="Enter description"> {{$category->description}}</textarea>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Image</label>
                <input type="file" name="image" id="image" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label d-block">Status</label>
                <div class="form-check form-check-inline">
                    <input type="radio" name="status" id="active" value="1" class="form-check-input" @checked($category->status == 'active')>
                    <label for="active" class="form-check-label">Active</label>
                </div>
                <div class="form-check form-check-inline">
                    <input type="radio" name="status" id="archived" value="0" class="form-check-input" @checked($category->status == 'archived')>
                    <label for="archived" class="form-check-label">Archived</label>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
@endsection
