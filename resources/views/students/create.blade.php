<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ImportProject</title>
</head>
<body>
    <form action="{{ route('students.store') }}"
          enctype="multipart/form-data"
          method="POST">
        @csrf
        <input type="file" name="import_file" />
        <br />
        <button type="submit">Importar</button>
    </form>
</body>
</html>
