@extends('layout')

@section('content')
    <div class="container">
        <div class="border p-2">
            <form>
                <div class="d-flex justify-content-center">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label for="month" class="form-label">Data referente aos dados da planilha</label>
                            <input type="month" min="2018-01" class="form-control" id="month" name="month" value="{{ Carbon\Carbon::now('America/Sao_Paulo')->format('Y') }}-{{ Carbon\Carbon::now('America/Sao_Paulo')->format('m') }}">
                        </div>

                        <div class="col-12">
                            <div class="d-flex align-items-center justify-content-between">
                                <a data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="Buscar uma planilha" href="{{ route('students.index') }}" class="btn btn-outline-secondary">Voltar</a>
                                <button type="submit" class="btn btn-primary float-end mb-3">Buscar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            @isset($sheets)
                <h3>PLANILHAS</h3>
                <div class="row">
                    @foreach ($sheets as $index => $sheet)
                        <a data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="Planilha referente ao dia: {{ Carbon\Carbon::parse($index)->format('d/m/Y') }}" href="{{ route('students.show', ['month' => Carbon\Carbon::parse($index)->format('m'), 'year' => Carbon\Carbon::parse($index)->format('Y')]) }}" class="col-2 bg-secondary rounded p-2 m-2 d-flex flex-column align-items-center justify-content-center">
                            <div>
                                <strong style="font-size: 16pt;" class="text-white">{{ Carbon\Carbon::parse($index)->format('d/m/Y') }}</strong>
                            </div>
                            <div class="mt-3">
                                <i class="fa fa-file-excel" style="font-size: 50px;"></i>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <h3>NENHUMA PLANILHA NOS REGISTROS</h3>
            @endisset
        </div>
    </div>
@endsection
