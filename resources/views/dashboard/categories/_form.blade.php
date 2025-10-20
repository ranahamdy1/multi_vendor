@if ($errors->any())
    <div class="alert alert-danger">
        <h3>Error Occurred!</h3>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="mb-3">
    <label for="name" class="form-label">Category Name</label>
    <input type="text" name="name" id="name"
           class="form-control @error('name') is-invalid @enderror"
           value="{{ old('name', $category->name) }}"
           placeholder="Enter category name" required>

    @error('name')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="parent_id" class="form-label">Category Parent</label>
    <select name="parent_id" id="parent_id" class="form-select">
        <option value="">Primary Category</option>
        @foreach($parents as $parent)
            <option value="{{ $parent->id }}" @selected(old('parent_id', $category->parent_id) == $parent->id)>
                {{ $parent->name }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label for="description" class="form-label">Description</label>
    <textarea name="description" id="description" rows="3"
              class="form-control" placeholder="Enter description">{{ old('description', $category->description) }}</textarea>
</div>

<div class="mb-3">
    <label for="image" class="form-label">Image</label>
    <input type="file" name="image" id="image" class="form-control" accept="image/*">
    @if($category->image)
        <img src="{{ asset('storage/' . $category->image) }}" alt="" height="60" class="mt-2">
    @endif
</div>

<div class="mb-3">
    <label class="form-label d-block">Status</label>
    <div class="form-check form-check-inline">
        <input type="radio" name="status" id="active" value="1" class="form-check-input"
            @checked(old('status', $category->status) == 1)>
        <label for="active" class="form-check-label">Active</label>
    </div>
    <div class="form-check form-check-inline">
        <input type="radio" name="status" id="archived" value="0" class="form-check-input"
            @checked(old('status', $category->status) == 0)>
        <label for="archived" class="form-check-label">Archived</label>
    </div>
    @error('status')
    <div class="text-danger mt-1">{{ $message }}</div>
    @enderror
</div>

<button type="submit" class="btn btn-primary">Save</button>
