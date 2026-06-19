@extends('layouts.app')

@section('title', 'Property Tax')

@section('content')

<h2>Import Property Tax (Upload CSV or Excel File)</h2>

<hr />

<form method="POST"
      action="{{ route('admin.property-tax.import') }}"
      enctype="multipart/form-data">

    @csrf

    <div class="row">
        <div class="col-md-4 mb-3">
            <label class="form-label">Select Block</label>
            <select name="block_id" class="form-control" required>
                <option value="">Choose Block</option>
                @foreach($blocks as $block)
                    <option value="{{ $block->id }}">{{ $block->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4 mb-3">
            <div class="form-group">
                <label class="form-label">Upload CSV / Excel</label>
                <input type="file" name="file" class="form-control" style="cursor:pointer;" accept=".csv,.txt,.xls,.xlsx" required>
            </div>
        </div>
        <div class="col-md-4 mt-2 d-flex align-items-end">
            <button type="submit" class="btn btn-primary">Upload</button>
        </div>
    </div>
    <!-- <input type="file" name="file" class="form-control" required>

    <button type="submit">
        Upload
    </button> -->

</form>

@endsection