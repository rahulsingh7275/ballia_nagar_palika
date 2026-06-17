@extends('layouts.app')

@section('title', 'Property Tax')

@section('content')

<h2>Import Property Tax CSV</h2>

<form method="POST"
      action="{{ route('admin.property-tax.import') }}"
      enctype="multipart/form-data">

    @csrf

    <input type="file" name="file" required>

    <button type="submit">
        Upload
    </button>

</form>

@endsection