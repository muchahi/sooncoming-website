@if(auth()->user()->is_admin)
<div class="mb-3">
    <label for="type" class="form-label">Type</label>
    <select name="type" id="type" class="form-control form-control-sm @error('type') is-invalid @enderror"
        required>
        <option value="local" {{ old('type', $location->type ?? '') == 'local' ? 'selected' : '' }}>Local</option>
        <option value="international" {{ old('type', $location->type ?? '') == 'international' ? 'selected' : '' }}>
            International</option>
    </select>
    @error('type')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>

<div class="mb-3">
    <label for="place" class="form-label">Place</label>
    <input type="text" name="place" id="place"
        class="form-control form-control-sm @error('place') is-invalid @enderror"
        value="{{ old('place', $location->place ?? '') }}" required>
    @error('place')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>

<div class="mb-3">
    <label for="country" class="form-label">Country</label>
    <input type="text" name="country" id="country"
        class="form-control form-control-sm @error('country') is-invalid @enderror"
        value="{{ old('country', $location->country ?? '') }}">
    @error('country')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>

<div class="mb-3">
    <label for="city" class="form-label">City</label>
    <input type="text" name="city" id="city"
        class="form-control form-control-sm @error('city') is-invalid @enderror"
        value="{{ old('city', $location->city ?? '') }}">
    @error('city')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>

<div class="mb-3">
    <label for="postal_code" class="form-label">Postal Code</label>
    <input type="text" name="postal_code" id="postal_code"
        class="form-control form-control-sm @error('postal_code') is-invalid @enderror"
        value="{{ old('postal_code', $location->postal_code ?? '') }}">
    @error('postal_code')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>

<button type="submit" class="btn btn-success">Save</button>
@else
<span class="text-muted">Restricted</span>
@endif
