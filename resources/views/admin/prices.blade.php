@extends('admin.layout')

@section('title', 'Manage Prices')

@section('content')
<div class="admin-form-container">
    <!-- Price Form (Add or Edit) -->
    <div class="card admin-form-card">
        <h3 id="formTitle">Add New Price</h3>
        <form id="priceForm" action="{{ route('admin.prices.store') }}" method="POST" class="admin-form">
            @csrf
            <div id="methodField"></div>
            <div class="form-group">
                <label>Category</label>
                <select name="category" id="categoryField" required>
                    <option value="Food">Food</option>
                    <option value="Fuel">Fuel</option>
                    <option value="Electricity">Electricity</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            <div class="form-group">
                <label>Item Name</label>
                <input type="text" name="item_name" id="itemNameField" required placeholder="e.g. Bread (1 loaf)">
            </div>
            <div class="form-group">
                <label>Price Value</label>
                <input type="number" step="0.001" name="price" id="priceField" required placeholder="e.g. 0.190">
            </div>
            <div class="form-group">
                <label>Price Source</label>
                <select name="source" id="sourceField" required>
                    <option value="Official">Official / Regulated</option>
                    <option value="Market">Estimated Market</option>
                </select>
            </div>
            <button type="submit" id="submitBtn" class="btn-primary">+ Add Price</button>
            <button type="button" id="cancelBtn" onclick="resetForm()" class="btn-secondary" style="display: none;">Cancel Edit</button>
        </form>
    </div>

    <!-- Prices List -->
    <div class="card admin-list-card">
        <h3>Current Tracked Prices</h3>
        <table>
            <thead>
                <tr>
                    <th>Category</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Source</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($prices as $p)
                <tr>
                    <td><span class="category-name">{{ $p->category }}</span></td>
                    <td>{{ $p->item_name }}</td>
                    <td>{{ number_format($p->price, 3) }} TND</td>
                    <td>
                        <span class="badge {{ $p->source == 'Official' ? 'green' : 'orange' }}">
                            {{ $p->source }}
                        </span>
                    </td>
                    <td class="actions-cell">
                        <button type="button" onclick="editPrice({{ json_encode($p) }})" class="btn-primary btn-sm">Edit</button>
                        <form action="{{ route('admin.prices.destroy', $p->price_id) }}" method="POST" onsubmit="return confirm('Delete this price?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-danger" style="padding: 0.25rem 0.5rem; font-size: 0.85rem;">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
                @if($prices->count() == 0)
                <tr>
                    <td colspan="5" style="text-align: center; padding: 2rem;">No prices found.</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

<script>
function editPrice(price) {
    document.getElementById('formTitle').innerText = 'Edit Price';
    document.getElementById('priceForm').action = '/admin/prices/' + price.price_id;
    document.getElementById('methodField').innerHTML = '@method("PUT")';
    
    document.getElementById('categoryField').value = price.category;
    document.getElementById('itemNameField').value = price.item_name;
    document.getElementById('priceField').value = price.price;
    document.getElementById('sourceField').value = price.source;
    
    document.getElementById('submitBtn').innerText = 'Update Price';
    document.getElementById('cancelBtn').style.display = 'block';
    
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function resetForm() {
    document.getElementById('formTitle').innerText = 'Add New Price';
    document.getElementById('priceForm').action = "{{ route('admin.prices.store') }}";
    document.getElementById('methodField').innerHTML = '';
    
    document.getElementById('priceForm').reset();
    
    document.getElementById('submitBtn').innerText = '+ Add Price';
    document.getElementById('cancelBtn').style.display = 'none';
}
</script>
@endsection
