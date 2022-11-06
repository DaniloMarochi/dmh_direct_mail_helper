@extends('layout')

@section('content')
    <div class="container">
        <div class="border p-2 d-flex flex-column align-items-center justify-content-center">
            <a style="width: 200px;" class="btn btn-success" href="{{ route('students.import') }}" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="Importar planilha">Importar Planilha</a>
            <a style="width: 200px;" class="btn btn-primary mt-2" href="{{ route('students.filter') }}" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="Buscar dados">Buscar Dados</a>
        </div>
    </div>
@endsection
