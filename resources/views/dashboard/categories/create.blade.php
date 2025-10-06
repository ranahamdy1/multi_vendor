@extends('layouts.dashboard')
@section('title','categories create')

@section('content')
    <div class="container mt-4">
        <h3 class="mb-4">Add New Category</h3>

        <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Category Name</label>
                <input type="text" name="name" id="name" class="form-control" placeholder="Enter category name" required>
            </div>

            <div class="mb-3">
                <label for="parent_id" class="form-label">Category Parent</label>
                <select name="parent_id" id="parent_id" class="form-select">
                    <option value="">Primary Category</option>
                    @foreach($parents as $parent)
                        <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" rows="3" class="form-control" placeholder="Enter description"></textarea>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Image</label>
                <input type="file" name="image" id="image" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label d-block">Status</label>
                <div class="form-check form-check-inline">
                    <input type="radio" name="status" id="active" value="1" class="form-check-input" checked>
                    <label for="active" class="form-check-label">Active</label>
                </div>
                <div class="form-check form-check-inline">
                    <input type="radio" name="status" id="archived" value="0" class="form-check-input">
                    <label for="archived" class="form-check-label">Archived</label>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
@endsection
