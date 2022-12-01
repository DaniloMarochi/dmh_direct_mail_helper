@extends('layout')

@section('content')
    <div class="container">
        <div class="mt-5">
            <div class="border rounded p-2 bg-white mt-3 mb-3">
                <div class="d-flex align-items-center justify-content-between">
                    <h1>Estudantes de {{ Str::ucfirst($month_formatted) }} - {{ $year }}</h1>
                    <div class="d-flex align-items-center justify-content-between">
                        <form id="direct-mail-form" action="{{ route('students.direct.email', ['month' => $month, 'year' => $year]) }}">
                            @csrf
                            <button @isset($disable_direct_mail_button) @if ($disable_direct_mail_button) disabled @endif @endisset id="direct-mail-button" type="submit" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="Enviar mala direta" class="btn btn-outline-danger">
                                <i class="fa fa-envelope"></i> Mala Direta
                            </button>
                        </form>
                        &nbsp;
                        <a href="{{ route('students.filter') }}" class="btn btn-outline-secondary" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="Voltar para página anterior">Voltar</a>
                    </div>
                </div>

                <div class="mt-5">
                    <div class="mt-5">
                        <div class="rounded shadow p-2 bg-white mt-3 mb-3">
                            <livewire:student-table month="{{ $month }}" year="{{ $year }}" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
