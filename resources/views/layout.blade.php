<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>DMH - Direct Mail Helper</title>

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    @livewireStyles
    @powerGridStyles
</head>

<body class="antialiased">

    @if (Session::has('success'))
        <div style="z-index: 9999;" class="alert alert-dismissible bg-success fade show d-flex align-items-center justify-content-center position-absolute top-0 end-0 shadow m-2" role="alert">
            <div>
                <strong class="text-white">Sucesso</strong> <span class="text-white">{{ Session::get('success') }}</span>
            </div>
            <button type="button" class="btn-close text-white" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (Session::has('warning'))
        <div style="z-index: 9999;" class="alert alert-dismissible bg-warning fade show d-flex align-items-center justify-content-center position-absolute top-0 end-0 shadow m-2" role="alert">
            <div>
                <strong class="text-white">Info</strong> <span class="text-white">{{ Session::get('warning') }}</span>
            </div>
            <button type="button" class="btn-close text-white" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (Session::has('error'))
        <div style="z-index: 9999;" class="alert alert-dismissible bg-danger fade show d-flex align-items-center justify-content-center position-absolute top-0 end-0 shadow m-2" role="alert">
            <div>
                <strong class="text-white">Erro</strong> <span class="text-white">{{ Session::get('error') }}</span>
            </div>
            <button type="button" class="btn-close text-white" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <header class="bg-primary">
        <div class="d-flex flex-row align-items-center justify-content-start p-2">
            <a style="width: 200px;" href="{{ route('students.index') }}" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="Voltar para a home">
                <img class="w-100" src="{{ asset('assets/images/dmh.PNG') }}" alt="logo">
            </a>
            &nbsp;
            <h1>
                DMH - Direct Mail Helper
            </h1>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    {{-- JQuery Scripts --}}
    <script src="https://code.jquery.com/jquery-3.6.0.slim.js" integrity="sha256-HwWONEZrpuoh951cQD1ov2HUK5zA5DwJ1DNUXaM6FsY=" crossorigin="anonymous"></script>

    {{-- JavaScript Bundle with Popper --}}
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js" integrity="sha384-IDwe1+LCz02ROU9k972gdyvl+AESN10+x7tBKgc9I5HFtuNz0wWnPclzo6p9vxnk" crossorigin="anonymous"></script>

    {{-- SweetAlert 2 Scripts --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.5/dist/sweetalert2.all.min.js"></script>

    {{-- Activate bootstrap tooltips --}}
    <script>
        $(document).ready(() => {
            $('#direct-mail-button').click(function(event) {
                event.preventDefault();

                Swal.fire({
                    title: 'Tem certeza que deseja enviar a mala direta?',
                    showDenyButton: true,
                    confirmButtonText: 'Sim',
                    denyButtonText: `Não`,
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire('Enviado!', 'Mala direta encaminhada para todos os usuários.', 'success')
                        $('#direct-mail-form').submit();
                    } else if (result.isDenied) {
                        Swal.fire('Mala direta cancelada!', 'Nada foi enviado.', 'info')
                    }
                })
            })
        });

        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
    </script>

    {{-- Powergrid and Livewire Scripts --}}
    @livewireScripts
    @powerGridScripts

    <script>
        window.addEventListener('showAlert', event => {
            alert(event.detail.message);
        })
    </script>
</body>

</html>
