@extends('layout')

@section('content')
    <div class="container">
        <div class="mt-5">
            <div class="border rounded p-2 bg-white mt-3 mb-3">
                <div class="d-flex align-items-center justify-content-between">
                    <a href="{{ route('students.filter') }}" class="btn btn-outline-secondary" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="Voltar para a página anterior">Voltar</a>
                    <h1 class="">Média: {{ number_format($media, 0) }}%</h1>
                </div>
                <div class="rounded shadow p-2 bg-white mt-3 mb-3">
                    <livewire:student-email-table email="{{$email}}"/>
                </div>
            </div>
        </div>
    </div>
@endsection