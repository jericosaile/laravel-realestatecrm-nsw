<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container my-4">

    <!-- Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
        <h1 class="h3">Welcome, {{ auth()->user()->name }}</h1>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-outline-danger">Logout</button>
        </form>
    </div>

    <div class="row">

        <!-- Left Column: Add Property Form -->
        <div class="col-12 col-lg-4 mb-4">
            <!-- Mobile toggle button -->
            <button class="btn btn-primary d-lg-none mb-3 w-100" type="button" data-bs-toggle="collapse" data-bs-target="#addPropertyForm" aria-expanded="false" aria-controls="addPropertyForm">
                Add Property
            </button>

            <!-- Form Container -->
            <div class="collapse d-lg-block" id="addPropertyForm">
                <div class="card shadow-sm h-100">
                    <div class="card-header">
                        <h2 class="h5 mb-0">Add Property</h2>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('properties.store') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="property_name" class="form-label">Property Name</label>
                                <input type="text" class="form-control" id="property_name" name="property_name" placeholder="Enter property name">
                            </div>

                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" class="form-control" id="address" name="address" placeholder="Enter address">
                            </div>

                            <div class="mb-3">
                                <label for="price" class="form-label">Price</label>
                                <input type="number" class="form-control" id="price" name="price" step="0.01" placeholder="Enter price">
                            </div>

                            <div class="mb-3">
                                <label for="type" class="form-label">Type</label>
                                <select class="form-select" id="type" name="type" required>
                                    <option value="">-- Select Type --</option>
                                    <option value="House">House</option>
                                    <option value="Apartment">Apartment</option>
                                    <option value="Condo">Condo</option>
                                    <option value="Land">Land</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" id="status" name="status" required>
                                    <option value="">-- Select Status --</option>
                                    <option value="Available">Available</option>
                                    <option value="Leased">Leased</option>
                                </select>
                            </div>

                            <div class="row">
                                <div class="col-6 mb-3">
                                    <label for="bedrooms" class="form-label">Bedrooms</label>
                                    <input type="number" class="form-control" id="bedrooms" name="bedrooms" placeholder="Bedrooms">
                                </div>
                                <div class="col-6 mb-3">
                                    <label for="bathrooms" class="form-label">Bathrooms</label>
                                    <input type="number" class="form-control" id="bathrooms" name="bathrooms" placeholder="Bathrooms">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" placeholder="Enter property description"></textarea>
                            </div>

                            <!-- Lease Fields -->
                            <div id="lease-fields" class="mb-3" style="display:none;">
                                <label class="form-label">Tenant Name</label>
                                <input type="text" class="form-control mb-2" name="tenant_name" placeholder="Tenant Name">
                                <input type="date" class="form-control mb-2" name="lease_start_date">
                                <input type="date" class="form-control" name="lease_end_date">
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Add Property</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Properties List -->
        <div class="col-12 col-lg-8">
            <h2 class="mb-3">Your Properties</h2>

            @if($properties->isEmpty())
                <p>No properties added yet.</p>
            @else
                <div class="row row-cols-1 row-cols-md-2 g-4">
                    @foreach($properties as $property)
                        <div class="col">
                            <div class="card h-100 shadow-sm">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $property->property_name }}</h5>
                                    <p class="card-text">
                                        <strong>Address:</strong> {{ $property->address }}<br>
                                        <strong>Price:</strong> ${{ number_format($property->price, 2) }}<br>
                                        <strong>Type:</strong> {{ $property->type }}<br>
                                        <strong>Status:</strong> {{ $property->status }}<br>
                                        @if($property->status == 'Leased')
                                            <strong>Tenant:</strong> {{ $property->tenant_name }}<br>
                                            <strong>Lease Start:</strong> {{ $property->lease_start_date }}<br>
                                            <strong>Lease End:</strong> {{ $property->lease_end_date }}<br>
                                        @endif
                                        <strong>Bedrooms:</strong> {{ $property->bedrooms }}<br>
                                        <strong>Bathrooms:</strong> {{ $property->bathrooms }}
                                    </p>
                                </div>
                                <div class="card-footer d-flex flex-column flex-sm-row justify-content-between gap-2">
                                    <a href="{{ route('properties.edit', $property->id) }}" class="btn btn-sm btn-primary w-100 w-sm-auto">Edit</a>
                                    <form action="{{ route('properties.destroy', $property->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger w-100 w-sm-auto" onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                    <a href="{{ route('properties.payment', $property->id) }}" class="btn btn-sm btn-secondary w-100 w-sm-auto">Manage Payments</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

</div>

<script>
    // Show/hide lease fields
    document.getElementById('status').addEventListener('change', function () {
        const leaseFields = document.getElementById('lease-fields');
        leaseFields.style.display = this.value === 'Leased' ? 'block' : 'none';
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
