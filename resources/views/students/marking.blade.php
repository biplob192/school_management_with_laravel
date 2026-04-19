@extends('layouts.master_layout')

@section('page-title')
    {{ __('Marking') }}
@endsection

@push('header')
    <style>
        .loading-modal {
            position: fixed;
            z-index: 1000;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            background: rgba(255, 255, 255, .8) url("../../loading.gif") 50% 40% no-repeat;
        }
    </style>
@endpush


@section('header')
    <x-common.header title="{{ __('Enter Student Marks') }}">
        <li class="breadcrumb-item">
            <a href="javascript: void(0);">{{ __('Dashboard') }}</a>
        </li>
        <li class="breadcrumb-item active">{{ __('Marking') }}</li>
    </x-common.header>
@endsection

@section('content')
    <form method="POST" action="/submit-marks">
        @csrf
        <table>
            <thead>
                <tr>
                    <th>Student Name</th>
                    <th>Roll</th>
                    <th>CQ</th>
                    <th>MCQ</th>
                    <th>Prac</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($students as $student)
                    <tr>
                        <td>{{ $student->name }}</td>
                        <td>{{ $student->roll }}</td>
                        <td>
                            <input type="number" name="marks[{{ $student->id }}][cq]" min="0" max="50">
                        </td>
                        <td>
                            <input type="number" name="marks[{{ $student->id }}][mcq]" min="0" max="50">
                        </td>
                        <td>
                            <input type="number" name="marks[{{ $student->id }}][prac]" min="0" max="50">
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <button type="submit">Submit Marks</button>
    </form>
@endsection

@push('footer')
@endpush
