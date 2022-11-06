@extends('layout')

@section('content')
    <div class="container">
        <div class="border p-2">
            <form id="import_excel" action="{{ route('students.store') }}" enctype="multipart/form-data" method="POST">
                @csrf
                <div class="d-flex justify-content-center">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label for="import_file" class="form-label">Importar Planilha</label>
                            <input type="file" class="form-control" id="import_file" name="import_file">
                        </div>

                        <div class="col-12 mb-3">
                            <label for="month" class="form-label">Data referente aos dados da planilha</label>
                            <input type="month" min="2018-01" class="form-control" id="month" name="month" value="{{ Carbon\Carbon::now('America/Sao_Paulo')->format('Y') }}-{{ Carbon\Carbon::now('America/Sao_Paulo')->format('m') }}">
                        </div>

                        <div class="col-12">
                            <div class="d-flex align-items-center justify-content-between">
                                <a href="{{ route('students.index') }}" class="btn btn-outline-secondary" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="Voltar para a página anterior">Voltar</a>
                                <button type="submit" class="btn btn-primary float-end mb-3" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="Importar planilha">Importar Planilha</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
