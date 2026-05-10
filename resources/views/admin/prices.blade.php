@extends('admin.layout')

@section('title', 'Manage Prices')

@section('content')
<div style="display: flex; gap: 2rem;">
    <!-- Price Form (Add or Edit) -->
    <div class="card" style="width: 350px; flex-shrink: 0; align-self: flex-start;">
        <h3 id="formTitle">Add New Price</h3>
        <form id="priceForm" action="{{ route('admin.prices.store') }}" method="POST" style="display: flex; flex-direction: column; gap: 1rem;">
            @csrf
            <div id="methodField"></div>
            <div>
                <label style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: #475569;">Category</label>
                <select name="category" id="categoryField" required style="width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: 6px;">
                    <option value="Food">Food</option>
                    <option value="Fuel">Fuel</option>
                    <option value="Electricity">Electricity</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            <div>
                <label style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: #475569;">Item Name</label>
                <input type="text" name="item_name" id="itemNameField" required placeholder="e.g. Bread (1 loaf)" style="width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: 6px; box-sizing: border-box;">
            </div>
            <div>
                <label style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: #475569;">Price Value</label>
                <input type="number" step="0.001" name="price" id="priceField" required placeholder="e.g. 0.190" style="width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: 6px; box-sizing: border-box;">
            </div>
            <div>
                <label style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: #475569;">Price Source</label>
                <select name="source" id="sourceField" required style="width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: 6px;">
                    <option value="Official">Official / Regulated</option>
                    <option value="Market">Estimated Market</option>
                </select>
            </div>
            <button type="submit" id="submitBtn" class="btn-primary" style="margin-top: 1rem;">+ Add Price</button>
            <button type="button" id="cancelBtn" onclick="resetForm()" style="display: none; padding: 0.75rem; background: #e2e8f0; border: none; border-radius: 6px; cursor: pointer; color: #475569;">Cancel Edit</button>
        </form>
    </div>

    <!-- Prices List -->
    <div class="card" style="flex: 1;">
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
                    <td><span style="font-weight: 600;">{{ $p->category }}</span></td>
                    <td>{{ $p->item_name }}</td>
                    <td>{{ number_format($p->price, 3) }} TND</td>
                    <td>
                        <span class="badge {{ $p->source == 'Official' ? 'green' : 'orange' }}">
                            {{ $p->source }}
                        </span>
                    </td>
                    <td style="display: flex; gap: 0.5rem;">
                        <button type="button" onclick="editPrice({{ json_encode($p) }})" class="btn-primary" style="padding: 0.25rem 0.5rem; font-size: 0.85rem; background: #2B5CE6;">Edit</button>
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
