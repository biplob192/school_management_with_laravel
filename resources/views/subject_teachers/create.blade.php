@extends('layouts.master_layout')

@section('page-title', __('Assign Subject Teacher'))

@section('header')
    <x-common.header title="{{ __('Assign Subject Teacher') }}">
        <li class="breadcrumb-item"><a href="{{ route('subject_teachers.index') }}">{{ __('Subject Teachers') }}</a></li>
        <li class="breadcrumb-item active">{{ __('Create') }}</li>
    </x-common.header>
@endsection

@section('content')
    <form method="POST" action="{{ route('subject_teachers.store') }}">
        @csrf

        <div class="row">
            <div class="col-md-3">
                <x-form.input name="shift" label="Shift" type="select" :options="['Morning' => 'Morning', 'Day' => 'Day']" :value="old('shift') ?? 'Morning'" required />
            </div>

            <div class="col-md-3">
                <x-form.input name="class_id" label="Class" type="select" :options="$classes" :value="old('class_id')" required />
            </div>

            <div class="col-md-3">
                {{-- <x-form.input name="group_id" label="Group" type="select" :options="$groups" :value="old('group_id')" /> --}}
                <x-form.input name="group_id" id="group_id" label="Group" type="select" :options="[]" :show-asterisk-id="'group_id-required-marker'" />
            </div>

            <div class="col-md-3">
                <x-form.input name="is_common_section" label="Section Assignment" type="checkbox" checkboxLabel="Assign To All Section" :checked="old('is_common_section')" />
                {{-- <x-form.checkboxes name="permissions" label="Assign Permissions" :options="['create' => 'Create', 'edit' => 'Edit', 'delete' => 'Delete']" :selected="old('permissions', [])" /> --}}
            </div>

            <div class="col-md-3">
                {{-- <x-form.input name="section_id" label="Section" type="select" :options="$sections" :value="old('section_id')" :show-asterisk-id="'section_id-required-marker'" /> --}}
                <x-form.input name="section_id" id="section_id" label="Section" type="select" :options="[]" :show-asterisk-id="'section_id-required-marker'" />
            </div>

            <div class="col-md-3">
                {{-- <x-form.input name="subject_id" label="Subject" type="select" :options="$subjects" :value="old('subject_id')" placeholder="Select a subject" required /> --}}
                <x-form.input name="subject_id" id="subject_id" label="Subject" type="select" :options="[]" placeholder="Select a subject" required />
            </div>

            <div class="col-md-3">
                <x-form.input name="teacher_id" label="Teacher" type="select" :options="$teachers" :value="old('teacher_id')" required />
            </div>
        </div>

        <x-form.button class="mt-3">Assign</x-form.button>
    </form>
@endsection

{{-- <script>
    document.addEventListener('DOMContentLoaded', function() {
        const isCommonCheckbox = document.querySelector('[name="is_common_section"]');
        const sectionSelect = document.querySelector('[name="section_id"]');
        const sectionAsterisk = document.getElementById('section_id-required-marker');

        function toggleSectionRequirement() {
            const isChecked = isCommonCheckbox.checked;

            // Toggle HTML required attribute
            if (isChecked) {
                sectionSelect.removeAttribute('required');
                if (sectionAsterisk) sectionAsterisk.style.display = 'none';
            } else {
                sectionSelect.setAttribute('required', 'required');
                if (sectionAsterisk) sectionAsterisk.style.display = 'inline';
            }
        }

        // Initial toggle
        toggleSectionRequirement();

        // On checkbox change
        isCommonCheckbox.addEventListener('change', toggleSectionRequirement);
    });
</script> --}}

<script>
    // document.addEventListener('DOMContentLoaded', function() {
    //     const classSelect = document.querySelector('[name="class_id"]');
    //     const groupSelect = document.querySelector('[name="group_id"]');
    //     const sectionSelect = document.querySelector('[name="section_id"]');
    //     const subjectSelect = document.querySelector('[name="subject_id"]');
    //     const isCommonCheckbox = document.querySelector('[name="is_common_section"]');
    //     const sectionAsterisk = document.getElementById('section_id-required-marker');

    //     function populateDropdown(select, data, placeholder = 'Select an option') {
    //         select.innerHTML = `<option value="">${placeholder}</option>`;
    //         for (const [key, value] of Object.entries(data)) {
    //             const option = document.createElement('option');
    //             option.value = key;
    //             option.textContent = value;
    //             select.appendChild(option);
    //         }
    //     }

    //     function resetDropdown(select, placeholder = 'Select an option') {
    //         select.innerHTML = `<option value="">${placeholder}</option>`;
    //     }

    //     classSelect.addEventListener('change', function() {
    //         const classId = this.value;

    //         resetDropdown(groupSelect, 'Loading groups...');
    //         resetDropdown(sectionSelect);
    //         resetDropdown(subjectSelect);

    //         fetch(`class/${classId}/groups`)
    //             .then(res => res.json())
    //             .then(data => {
    //                 if (data.groups && Object.keys(data.groups).length > 0) {
    //                     populateDropdown(groupSelect, data.groups);
    //                     groupSelect.required = true;
    //                 } else {
    //                     groupSelect.required = false;
    //                     resetDropdown(groupSelect, 'No groups');
    //                     fetch(`class/${classId}/sections`)
    //                         .then(res => res.json())
    //                         .then(sectionData => populateDropdown(sectionSelect, sectionData.sections));
    //                 }
    //             });
    //     });

    //     groupSelect.addEventListener('change', function() {
    //         const classId = classSelect.value;
    //         const groupId = this.value;

    //         resetDropdown(sectionSelect, 'Loading...');
    //         resetDropdown(subjectSelect);

    //         fetch(`class/${classId}/group/${groupId}/sections`)
    //             .then(res => res.json())
    //             .then(data => populateDropdown(sectionSelect, data.sections));
    //     });

    //     sectionSelect.addEventListener('change', function() {
    //         const sectionId = this.value;

    //         resetDropdown(subjectSelect, 'Loading...');
    //         fetch(`section/${sectionId}/subjects`)
    //             .then(res => res.json())
    //             .then(data => populateDropdown(subjectSelect, data.subjects));
    //     });

    //     function toggleSectionRequirement() {
    //         const isChecked = isCommonCheckbox.checked;
    //         if (isChecked) {
    //             sectionSelect.removeAttribute('required');
    //             if (sectionAsterisk) sectionAsterisk.style.display = 'none';
    //         } else {
    //             sectionSelect.setAttribute('required', 'required');
    //             if (sectionAsterisk) sectionAsterisk.style.display = 'inline';
    //         }
    //     }

    //     toggleSectionRequirement();
    //     isCommonCheckbox.addEventListener('change', toggleSectionRequirement);
    // });
</script>

@push('footer')
    <script>
        $(document).ready(function() {
            const classSelect = $('[name="class_id"]');
            const groupSelect = $('[name="group_id"]');
            const sectionSelect = $('[name="section_id"]');
            const subjectSelect = $('[name="subject_id"]');
            const isCommonCheckbox = $('[name="is_common_section"]');
            const sectionAsterisk = $('#section_id-required-marker');
            const groupAsterisk = $('#group_id-required-marker');
            groupAsterisk.css('display', 'none'); // Default hide

            function populateDropdown($select, data, placeholder = 'Select an option') {
                $select.empty().append(new Option(placeholder, ''));
                $.each(data, function(key, value) {
                    $select.append(new Option(value, key));
                });
            }

            function resetDropdown($select, placeholder = 'Select an option') {
                $select.empty().append(new Option(placeholder, ''));
            }

            // function fetchAndPopulateAllByClass(classId) {
            //     if (!classId) return;

            //     resetDropdown(groupSelect, 'Loading groups...');
            //     resetDropdown(sectionSelect, 'Loading sections...');
            //     resetDropdown(subjectSelect, 'Loading subjects...');

            //     // Fetch all 3 dropdowns using parallel AJAX
            //     $.when(
            //         $.get(`/class/${classId}/groups`),
            //         $.get(`/class/${classId}/sections`),
            //         $.get(`/class/${classId}/subjects`)
            //     ).done(function(groupData, sectionData, subjectData) {
            //         populateDropdown(groupSelect, groupData[0].groups, 'Select Group');
            //         populateDropdown(sectionSelect, sectionData[0].sections, 'Select Section');
            //         populateDropdown(subjectSelect, subjectData[0].subjects, 'Select Subject');
            //     });
            // }

            function fetchAndPopulateAllByClass(classId) {
                resetDropdown(groupSelect, 'Loading groups...');
                resetDropdown(sectionSelect, 'Loading sections...');
                resetDropdown(subjectSelect, 'Loading subjects...');

                // Sections
                $.get(`/class/${classId}/sections`, function(sectionData) {
                    if (sectionData.sections && Object.keys(sectionData.sections).length > 0) {
                        populateDropdown(sectionSelect, sectionData.sections);
                    } else {
                        resetDropdown(sectionSelect, 'No sections');
                    }
                });

                // Subjects
                $.get(`/class/${classId}/subjects`, function(subjectData) {
                    if (subjectData.subjects && Object.keys(subjectData.subjects).length > 0) {
                        populateDropdown(subjectSelect, subjectData.subjects);
                    } else {
                        resetDropdown(subjectSelect, 'No subjects');
                    }
                });

                // Groups
                $.get(`/class/${classId}/groups`, function(data) {
                    if (data.groups && Object.keys(data.groups).length > 0) {
                        populateDropdown(groupSelect, data.groups);
                        groupSelect.prop('required', true);
                        groupAsterisk.css('display', 'inline');
                    } else {
                        resetDropdown(groupSelect, 'No groups');
                        groupSelect.prop('required', false);
                        groupAsterisk.css('display', 'none');
                    }
                });
            }

            function fetchSubjectsBySection(sectionId) {
                if (!sectionId) return;
                resetDropdown(subjectSelect, 'Loading...');
                $.get(`/section/${sectionId}/subjects`, function(data) {
                    // populateDropdown(subjectSelect, data.subjects, 'Select Subject');

                    if (data.subjects && Object.keys(data.subjects).length > 0) {
                        populateDropdown(subjectSelect, data.subjects, 'Select Subject');
                    } else {
                        resetDropdown(subjectSelect, 'No subjects');
                    }
                });
            }

            classSelect.on('change', function() {
                const classId = $(this).val();
                if (classId) {
                    fetchAndPopulateAllByClass(classId);
                }
            });

            // Group change: DO NOTHING (as per your requirement)
            groupSelect.on('change', function() {
                // Do nothing
            });

            sectionSelect.on('change', function() {
                if (!isCommonCheckbox.prop('checked')) {
                    const sectionId = $(this).val();
                    fetchSubjectsBySection(sectionId);
                }
            });

            function toggleSectionRequirement() {
                const isChecked = isCommonCheckbox.prop('checked');
                sectionSelect.prop('required', !isChecked);
                sectionAsterisk.css('display', isChecked ? 'none' : 'inline');

                if (isChecked) {
                    // If common section is checked, reload subjects for class only
                    const classId = classSelect.val();
                    if (classId) {
                        resetDropdown(subjectSelect, 'Loading...');
                        $.get(`/class/${classId}/subjects`, function(data) {
                            populateDropdown(subjectSelect, data.subjects, 'Select Subject');
                        });
                    }
                }
            }

            isCommonCheckbox.on('change', toggleSectionRequirement);
            toggleSectionRequirement(); // initialize on page load
        });
    </script>
@endpush
