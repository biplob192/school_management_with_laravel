@extends('layouts.master_layout')

@section('page-title', __('Edit Subject Teacher Assignment'))

@section('header')
    <x-common.header title="{{ __('Edit Assignment') }}">
        <li class="breadcrumb-item"><a href="{{ route('subject_teachers.index') }}">{{ __('Subject Teachers') }}</a></li>
        <li class="breadcrumb-item active">{{ __('Edit') }}</li>
    </x-common.header>
@endsection

@section('content')
    {{-- <form method="POST" action="{{ route('subject_teachers.update', $subjectTeacher->id) }}">
        @csrf
        @method('PUT')
        <x-form.input name="subject_id" label="Subject" type="select" :options="$subjects" :value="$subjectTeacher->subject_id" required />
        <x-form.input name="teacher_id" label="Teacher" type="select" :options="$teachers" :value="$subjectTeacher->teacher_id" required />
        <x-form.input name="section_id" label="Section" type="select" :options="$sections" :value="$subjectTeacher->section_id" />
        <x-form.input name="group_id" label="Group" type="select" :options="$groups" :value="$subjectTeacher->group_id" />
        <x-form.input name="shift" label="Shift" type="select" :options="['Morning' => 'Morning', 'Day' => 'Day']" :value="$subjectTeacher->shift" required />
        <x-form.checkbox name="is_common_section" label="Is Common Section?" :checked="$subjectTeacher->is_common_section" />

        <x-form.button class="mt-3">Update</x-form.button>
    </form> --}}

    <form method="POST" action="{{ route('subject_teachers.update', $subjectTeacher->id) }}">
        @csrf
        @method('PUT')
        <x-form.input name="subject_id" label="Subject" type="select" :options="$subjects" :value="$subjectTeacher->subject_id" required />
        <x-form.input name="teacher_id" label="Teacher" type="select" :options="$teachers" :value="$subjectTeacher->teacher_id" required />
        <x-form.input name="section_id" label="Section" type="select" :options="$sections" :value="$subjectTeacher->section_id" />
        <x-form.input name="group_id" label="Group" type="select" :options="$groups" :value="$subjectTeacher->group_id" />
        <x-form.input name="shift" label="Shift" type="select" :options="['Morning' => 'Morning', 'Day' => 'Day']" :value="$subjectTeacher->shift" required />
        <x-form.input name="is_common_section" type="checkbox" label="Is Common Section?" :checked="$subjectTeacher->is_common_section" />

        <x-form.button class="mt-3">Update</x-form.button>
    </form>

@endsection
