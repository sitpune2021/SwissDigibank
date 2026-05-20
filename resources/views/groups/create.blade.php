@extends('layout.main')
@section('content')
    <style>
        input[type="checkbox"] {
            width: 28px;
            height: 28px;
            accent-color: green;
            /* For modern browsers */
        }

        button[type="reset"]:active {
            transform: scale(0.95);
            opacity: 0.7;
            transition: 0.1s;
        }

        /* Fallback for browsers without accent-color support */
        input[type="checkbox"]:checked {
            background-color: green;
            border: none;
        }

        input[type="radio"] {
            width: 24px;
            height: 24px;
            accent-color: green;
            /* Modern browser support */
        }

        .tableWidth {
            width: 90%;
            margin: auto;

        }

        .bg-yellow {
            background-color: #e17100;
        }
    </style>


    <div class="main-inner">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
            <h3 class="text-lg font-semibold uppercase">
                Add New Group
            </h3>
        </div>

        <div class="col-span-12 box lg:col-span-12">
            <form method="POST" action="{{ $isEdit
        ? route('groups.update', base64_encode($group->id))
        : route('groups.store') }}" enctype="multipart/form-data">
                @if($isEdit)
                    @method('PUT')
                @endif
                @csrf

                <div class="grid grid-cols-2 gap-4 mt-6 xl:mt-8 xxxxxl:gap-6 mb-4">

                    {{-- Collection Center --}}
                    <div class="col-span-2 md:col-span-1">
                        <label class="md:text-lg font-medium block mb-4 uppercase">Collection Center</label>
                        <select name="collection_center_id" id="collection_center_id"
                            class="w-full text-sm bg-secondary/5 border border-n30 rounded-10 px-3 md:px-6 py-2 md:py-3">
                            <option value="">Select Collection Center</option>
                            @foreach($collectionCenters as $center)
                                <option value="{{ $center->id }}" {{ old('collection_center_id', $group->collection_center_id ?? '') == $center->id ? 'selected' : '' }}>
                                    {{ $center->center_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('collection_center_id')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Branch --}}
                    <div class="col-span-2 md:col-span-1">
                        <label class="md:text-lg font-medium block mb-4 uppercase">Branch</label>
                        <select name="branch_id" id="branch_id"
                            class="w-full text-sm bg-secondary/5 border border-n30 rounded-10 px-3 md:px-6 py-2 md:py-3">
                            <option value="">Select Branch</option>
                            {{-- Options will be populated dynamically --}}
                        </select>
                        @error('branch_id')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>


                    {{-- Open Date --}}
                    <div class="col-span-2 md:col-span-1">
                        <label class="md:text-lg font-medium block mb-4 uppercase">Open Date <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="open_date"
                            value="{{ old('open_date', isset($group) ? \Carbon\Carbon::parse($group->open_date)->format('d-m-Y') : '') }}"
                            placeholder="DD/MM/YYYY"
                            class="datepicker-field w-full text-sm bg-secondary/5 border border-n30 rounded-10 px-3 md:px-6 py-2 md:py-3">
                        @error('open_date')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Group Name --}}
                    <div class="col-span-2 md:col-span-1">
                        <label class="md:text-lg font-medium block mb-4 uppercase">Group Name <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="group_name" value="{{ old('group_name', $group->group_name ?? '') }}"
                            placeholder="Enter Group Name"
                            class="w-full text-sm bg-secondary/5 border border-n30 rounded-10 px-3 md:px-6 py-2 md:py-3">
                        @error('group_name')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Group No --}}
                    <div class="col-span-2 md:col-span-1">
                        <label class="md:text-lg font-medium block mb-4 uppercase">Group No <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="group_no" value="{{ old('group_no', $group->group_no ?? '') }}"
                            placeholder="Enter Group Number"
                            class="w-full text-sm bg-secondary/5 border border-n30 rounded-10 px-3 md:px-6 py-2 md:py-3">
                        @error('group_no')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Group Head Member --}}
                    <div class="col-span-2 md:col-span-1">
                        <label class="md:text-lg font-medium block mb-4 uppercase">Group Head Member <span
                                class="text-red-500">*</span></label>
                        <select name="group_head_member_id"
                            class="w-full text-sm bg-secondary/5 border border-n30 rounded-10 px-3 md:px-6 py-2 md:py-3 uppercase">
                            <option value="">Select Group Head Member</option>
                            @foreach($members as $member)
                                                <option value="{{ $member->id }}" {{ old('group_head_member_id', $group->
                                group_head_member_id ?? '') == $member->id ? 'selected' : '' }}>{{
                                $member->member_info_first_name }}</option>
                            @endforeach
                        </select>
                        @error('group_head_member_id')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Group Cashier --}}
                    <div class="col-span-2 md:col-span-1">
                        <label class="md:text-lg font-medium block mb-4 uppercase">Group Cashier</label>
                        <select name="group_cashier_member_id"
                            class="w-full text-sm bg-secondary/5 border border-n30 rounded-10 px-3 md:px-6 py-2 md:py-3 uppercase">
                            <option value="">Select Group Cashier</option>
                            @foreach($members as $member)
                                                <option value="{{ $member->id }}" {{ old('group_cashier_member_id', $group->
                                group_cashier_member_id ?? '') == $member->id ? 'selected' : '' }}>{{
                                $member->member_info_first_name }}</option>
                            @endforeach
                        </select>
                        @error('group_cashier_member_id')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Group Members --}}
                    <div class="col-span-2 md:col-span-1">
                        <label class="md:text-lg font-medium block mb-4 uppercase">
                            Group Members <span class="text-error">*</span>
                        </label>

                        <div id="group-members-wrapper"></div>

                        <a href="javascript:void(0)" onclick="addMember()"
                            class="text-primary uppercase text-sm font-medium mt-2 inline-block">
                            + Add Group Member
                        </a>

                        <p id="member-error" class="text-red-500 text-sm hidden">
                            You cannot select the same member more than once.
                        </p>

                        @error('group_member_ids')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- <div class="col-span-2 md:col-span-1">
                        <label class="md:text-lg font-medium block mb-4 uppercase">Group Members <span
                                class="text-error">*</span></label>
                        <div id="group-members-wrapper">
                            <div class="flex items-center gap-2 mb-2">
                                <select name="group_member_ids[]"
                                    class="group-member-select form-select w-full text-sm bg-secondary/5 border border-n30 rounded-10 px-3 md:px-6 py-2 md:py-3 uppercase">
                                    <option value="">Select Member</option>
                                    @foreach($members as $member)
                                    <option value="{{ $member->id }}">{{ $member->member_info_first_name }}</option>
                                    @endforeach
                                </select>

                                <button type="button" class="btn-error uppercase rounded-10 py-3 px-1 text-sm"
                                    onclick="removeMember(this)" style="display:none">
                                    Remove
                                </button>
                            </div>
                        </div>

                        <a href="javascript:void(0)" onclick="addMember()"
                            class="text-primary uppercase text-sm font-medium mt-2 inline-block">
                            + Add Group Member
                        </a>
                        <p id="member-error" class="text-red-500 text-sm hidden">
                            You cannot select the same member more than once.
                        </p>
                        @error('group_member_ids')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div> --}}

                    {{-- Group Active --}}
                    <div class="col-span-2 md:col-span-1">
                        <label class="md:text-lg font-medium block mb-4 uppercase">Group Active <span
                                class="text-error">*</span></label>
                        <div class="flex gap-6">
                            <label class="flex gap-2">
                                <input type="radio" name="is_active" value="1" {{ old('is_active', $group->is_active ??
                                    1) == 1 ? 'checked' : '' }} checked>
                                <p>Yes</p>
                            </label>

                            <label class="flex gap-2">
                                <input type="radio" name="is_active" value="0" {{ old('is_active', $group->is_active ??
                                    1) == 0 ? 'checked' : '' }}>
                                <p>No</p>
                            </label>
                        </div>
                        @error('is_active')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

               
                {{-- Buttons --}}
                <div class="flex justify-right gap-3 mt-6 col-span-2">
                    <button type="submit" class="btn-primary uppercase" style="background: linear-gradient(90deg, #e1d315, #e30f0f) !important; color: black;">
                        {{ $isEdit ? 'Update Group' : 'Add Group' }}
                    </button>

                    <a href="{{ route('groups.index') }}" class="btn-outline uppercase" style="background: linear-gradient(90deg, #e1d315, #e30f0f) !important; color: black;">
                        BACK
                    </a>
                </div>

            </form>


        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Datepicker CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.3.4/dist/css/datepicker.min.css">

    <!-- Datepicker JS -->
    <script src="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.3.4/dist/js/datepicker-full.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll('.datepicker-field').forEach(function (dateInput) {
                const picker = new Datepicker(dateInput, {
                    autohide: true,
                    format: 'dd-mm-yyyy',
                    maxDate: new Date(),
                });

                if (!dateInput.value) {
                    const today = new Date();
                    const formattedDate = today.toLocaleDateString('en-GB').split('/').join('-');
                    dateInput.value = formattedDate;
                }

                const calendarIcon = dateInput.parentElement.querySelector('.la-calendar');
                if (calendarIcon) {
                    calendarIcon.addEventListener('click', () => picker.show());
                }
            });
        });
    </script>

    <!--multiple slection Group Members-->
    <script>
        const selectedGroupMembers = @json($selectedMemberIds ?? []);
    </script>

    <script>
        const wrapper = document.getElementById('group-members-wrapper');

        function createMemberRow(selectedId = '') {
            const div = document.createElement('div');
            div.className = 'flex items-center gap-2 mb-2';

            div.innerHTML = `
                                                <select name="group_member_ids[]"
                                                    class="group-member-select form-select w-full text-sm bg-secondary/5 border border-n30 rounded-10 px-3 md:px-6 py-2 md:py-3 uppercase">
                                                    <option value="">Select Member</option>
                                                    @foreach($members as $member)
                                                        <option value="{{ $member->id }}">
                                                            {{ $member->member_info_first_name }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                                <button type="button"
                                                    class="btn-error uppercase rounded-10 py-3 px-1 text-sm"
                                                    onclick="removeMember(this)">
                                                    Remove
                                                </button>
                                            `;

            const select = div.querySelector('select');
            if (selectedId) {
                select.value = selectedId;
            }

            attachChangeListener(select);
            wrapper.appendChild(div);
            toggleFirstRemoveButton();
        }

        function addMember() {
            createMemberRow();
        }

        function removeMember(button) {
            button.parentElement.remove();
            toggleFirstRemoveButton();
        }

        function toggleFirstRemoveButton() {
            const buttons = wrapper.querySelectorAll('button');
            if (buttons.length === 1) {
                buttons[0].style.display = 'none';
            } else {
                buttons.forEach(btn => btn.style.display = 'inline');
            }
        }

        function attachChangeListener(select) {
            select.addEventListener('change', function () {
                const values = Array.from(
                    document.querySelectorAll('.group-member-select')
                ).map(s => s.value).filter(Boolean);

                const error = document.getElementById('member-error');

                if (values.length !== new Set(values).size) {
                    this.value = '';
                    error.classList.remove('hidden');
                } else {
                    error.classList.add('hidden');
                }
            });
        }

        /* ===============================
           INITIAL LOAD (CREATE / EDIT)
        =============================== */
        if (selectedGroupMembers.length > 0) {
            selectedGroupMembers.forEach(id => createMemberRow(id));
        } else {
            createMemberRow();
        }
    </script>



    {{-- jQuery (make sure it's loaded) --}}

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {

            function loadBranches(centerId, selectedBranch = null) {
                var branchDropdown = $('#branch_id');
                branchDropdown.empty();
                // branchDropdown.append('<option value="">Select Branch</option>');

                if (centerId) {
                    $.ajax({
                        url: '{{ url("branches-by-center") }}/' + centerId,
                        type: 'GET',
                        dataType: 'json',
                        success: function (data) {
                            console.log(data);
                            $.each(data, function (index, branch) {
                                var isSelected = (branch.id == selectedBranch) ? 'selected' : '';
                            branchDropdown.append(
                                    '<option value="'+ branch.branch_id +'" ' + isSelected +'>' +
                                    branch.branch_name +
                                    '</option>'
                                );
                            });
                           
                        },
                        error: function (xhr) {
                            console.log('Error fetching branches:', xhr.responseText);
                        }
                    });
                }
            }

            // Trigger on collection center change
            $('#collection_center_id').change(function () {
                var centerId = $(this).val();
                loadBranches(centerId);
            });

            // Preload for edit mode
            var initialCenter = $('#collection_center_id').val();
            var selectedBranch = '{{ old("branch_id", $group->branch_id ?? "") }}';
            if (initialCenter) {
                loadBranches(initialCenter, selectedBranch);
            }

        });
    </script>


@endsection