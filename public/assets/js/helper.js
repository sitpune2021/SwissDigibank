$(document).ready(function () {
    const oldBranchId = $('#oldState').val();
    $.ajax({
        url: "{{ url('/GetBranches') }}",
        type: "GET",
        success: function (response) {
            $('#branchDropdown').append('<option value="">Select Branch</option>');
            $.each(response, function (key, branch) {
                let selected = (branch.id == oldBranchId) ? 'selected' : '';
                $('#branchDropdown').append(`<option value="${branch.id}" ${selected}>${branch.branch_name}</option>`);
            });
        },
        error: function () {
            alert('Failed to fetch branches.');
        }
    });
});