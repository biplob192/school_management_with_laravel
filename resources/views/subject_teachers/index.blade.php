@extends('layouts.master_layout')

@section('page-title', __('Manage Subject Teachers'))

@section('header')
    <x-common.header title="{{ __('Subject Teachers') }}">
        <li class="breadcrumb-item"><a href="#">{{ __('Academics') }}</a></li>
        <li class="breadcrumb-item active">{{ __('Subject Teachers') }}</li>
    </x-common.header>
@endsection

@section('content')
    <x-action-box>
        <x-slot name="left">
            <a href="{{ route('subject_teachers.create') }}" class="btn btn-primary">
                <i class="fa fa-plus me-2"></i> {{ __('New Assignment') }}
            </a>
        </x-slot>
    </x-action-box>

    <x-table.table>
        <x-slot name="head">
            <tr>
                <x-table.th>#</x-table.th>
                <x-table.th>{{ __('Teacher') }}</x-table.th>
                <x-table.th>{{ __('Subject') }}</x-table.th>
                <x-table.th>{{ __('Class') }}</x-table.th>
                <x-table.th>{{ __('Section') }}</x-table.th>
                <x-table.th>{{ __('Group') }}</x-table.th>
                <x-table.th>{{ __('Shift') }}</x-table.th>
                <x-table.th>{{ __('CS Teacher?') }}</x-table.th>
                <x-table.th>{{ __('Action') }}</x-table.th>
            </tr>
        </x-slot>
        <x-slot name="body">
            @forelse($subjectTeachers as $st)
                <tr>
                    {{-- <td>{{ $loop->iteration }}</td> --}}
                    <td>{{ $subjectTeachers->firstItem() + $loop->index }}</td>
                    <td>{{ $st->teacher->user->name ?? '-' }}</td>
                    <td>{{ $st->subject->name ?? '-' }}</td>
                    <td>{{ $st->subject->class->name ?? '-' }}</td>
                    <td>{{ $st->section->name ?? '-' }}</td>
                    <td>{{ $st->group->name ?? '-' }}</td>
                    <td>{{ $st->shift ?? '-' }}</td>
                    <td>{{ $st->is_common_section_teacher ? 'Yes' : 'No' }}</td>
                    <td>
                        <a href="{{ route('subject_teachers.edit', $st->id) }}" class="btn btn-sm btn-secondary"><i class="fa fa-edit"></i></a>
                        <form action="{{ route('subject_teachers.destroy', $st->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center">No Records Found</td>
                </tr>
            @endforelse
        </x-slot>
    </x-table.table>

    {{ $subjectTeachers->links() }}
@endsection
