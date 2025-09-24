<div class="flex items-center gap-1">
    <label for="{{ $id ?? 'selectAllStatus' }}">{{ $label ?? 'STATUS' }}</label>
    <input type="checkbox" id="{{ $id ?? 'selectAllStatus' }}">
</div>

@once
<script>
    function bindApproveAll(checkboxId, selectClass, approvedValue = 'approved', pendingValue = 'pending') {
        const checkbox = document.getElementById(checkboxId);
        if (!checkbox) return;

        checkbox.addEventListener('change', function() {
            const selects = document.querySelectorAll(`.${selectClass}`);
            selects.forEach(select => {
                select.value = checkbox.checked ? approvedValue : pendingValue;
            });
        });

        const selects = document.querySelectorAll(`.${selectClass}`);
        selects.forEach(select => {
            if (!select.value) {
                select.value = pendingValue;
            }
        });
        checkbox.checked = false;
    }
</script>
@endonce

<script>
    document.addEventListener('DOMContentLoaded', function() {
        bindApproveAll(
            '{{ $id ?? '
            selectAllStatus ' }}',
            '{{ $class ?? '
            select - transaction - status ' }}',
            '{{ $approvedValue ?? '
            approved ' }}',
            '{{ $pendingValue ?? '
            pending ' }}'
        );
    });
</script>