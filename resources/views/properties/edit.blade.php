<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Property</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container my-5">

    <div class="card shadow-sm">
        <div class="card-header">
            <h2 class="h5 mb-0">Edit Property</h2>
        </div>
        <div class="card-body">

            <form method="POST" action="{{ route('properties.update', $property->id) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="property_name" class="form-label">Property Name</label>
                    <input type="text" name="property_name" class="form-control" id="property_name" 
                           value="{{ old('property_name', $property->property_name) }}" required>
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label">Address</label>
                    <input type="text" name="address" class="form-control" id="address"
                           value="{{ old('address', $property->address) }}" required>
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label">Price</label>
                    <input type="number" name="price" class="form-control" id="price" step="0.01"
                           value="{{ old('price', $property->price) }}" required>
                </div>

                <div class="mb-3">
                    <label for="type" class="form-label">Type</label>
                    <select name="type" id="type" class="form-select" required>
                        @foreach(['House', 'Apartment', 'Condo', 'Land'] as $type)
                            <option value="{{ $type }}" {{ $property->type === $type ? 'selected' : '' }}>
                                {{ $type }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select id="status" name="status" class="form-select" required>
                        @foreach(['Available', 'Leased'] as $status)
                            <option value="{{ $status }}" {{ $property->status === $status ? 'selected' : '' }}>
                                {{ $status }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="bedrooms" class="form-label">Bedrooms</label>
                        <input type="number" name="bedrooms" class="form-control" id="bedrooms"
                               value="{{ old('bedrooms', $property->bedrooms) }}">
                    </div>
                    <div class="col-md-6">
                        <label for="bathrooms" class="form-label">Bathrooms</label>
                        <input type="number" name="bathrooms" class="form-control" id="bathrooms"
                               value="{{ old('bathrooms', $property->bathrooms) }}">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" class="form-control" id="description">{{ old('description', $property->description) }}</textarea>
                </div>

                <!-- Lease Fields -->
                <div id="lease-details" class="mb-3" style="{{ $property->status == 'Leased' ? '' : 'display:none;' }}">
                    <div class="mb-3">
                        <label for="tenant_name" class="form-label">Tenant Name</label>
                        <input type="text" name="tenant_name" class="form-control" id="tenant_name" value="{{ $property->tenant_name }}">
                    </div>
                    <div class="mb-3">
                        <label for="lease_start_date" class="form-label">Lease Start Date</label>
                        <input type="date" name="lease_start_date" class="form-control" id="lease_start_date" value="{{ $property->lease_start_date }}">
                    </div>
                    <div class="mb-3">
                        <label for="lease_end_date" class="form-label">Lease End Date</label>
                        <input type="date" name="lease_end_date" class="form-control" id="lease_end_date" value="{{ $property->lease_end_date }}">
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Update Property</button>
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary">Cancel</a>
                </div>

            </form>

        </div>
    </div>

</div>

<script>
    document.getElementById('status').addEventListener('change', function() {
        const leaseDetails = document.getElementById('lease-details');
        leaseDetails.style.display = this.value === 'Leased' ? 'block' : 'none';
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
