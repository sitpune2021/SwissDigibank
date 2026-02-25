@forelse($ornaments as $ornament)
<tr>
    <td class="px-2  border">{{ $ornament->application_id }}</td>
    <td class="px-2  border">{{ $ornament->item_type }}</td>
    <td class="px-2  border">{{ $ornament->item_name }}</td>
    <td class="px-2  border">{{ $ornament->no_of_items }}</td>
    <td class="px-2  border">{{ $ornament->value_per_gram }}</td>
    <td class="px-2  border">{{ $ornament->gross_weight }}</td>
    <td class="px-2  border">{{ $ornament->net_weight }}</td>
    <td class="px-2  border">{{ $ornament->tunch }}</td>
    <td class="px-2  border">{{ $ornament->fine_weight }}</td>
    <td class="px-2  border">{{ $ornament->total_value }}</td>
    <td class="px-2  border">
        <img src="{{ asset('uploads/'.$ornament->image) }}" width="50" />
    </td>

    <td class="px-2  border">
        @if(hasPermission('gold-loan.ornaments.update'))
        {{-- Update Form --}}
        <form action="{{ route('gold-loan.ornaments.update', $ornament->id) }}" method="POST">
            @csrf
            {{-- Agar aap PATCH chahte ho to: @method('PATCH') use karo --}}
            
            <select name="status" class="w-24 border rounded">
                <option value="Mortgage" {{ $ornament->status == 'Mortgage' ? 'selected' : '' }}>Mortgage</option>
                <option value="Released" {{ $ornament->status == 'Released' ? 'selected' : '' }}>Released</option>
            </select>
            <td class="px-2  border">
               <textarea name="remark" class="w-full border rounded mt-1" placeholder="Remarks">{{ $ornament->remark }}</textarea>
             </td>
            <td class="px-2  border">
               <button type="submit" class="btn btn-sm rounded-10 text-sm uppercase btn-primary mt-1">Update</button></td>
        </form>
        @endif
    </td>
</tr>
@empty
<tr>
    <td colspan="14" class="text-center py-3">No Ornaments Found</td>
</tr>
@endforelse

<tr>
    <td colspan="14" class="px-2 py-2">
        {{ $ornaments->links() }}
    </td>
</tr>
