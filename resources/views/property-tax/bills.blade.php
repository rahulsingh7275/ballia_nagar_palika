@extends('layouts.app')

@section('title','Property Tax Bills')

@section('content')

<style>
    .table-pagination .pagination {
        margin-bottom: 0;
    }

    .table-pagination .page-link {
        padding: 0.25rem 0.55rem;
        font-size: 0.875rem;
    }

    .table-pagination .page-item:first-child .page-link,
    .table-pagination .page-item:last-child .page-link {
        min-width: 2.3rem;
    }

    .records-summary {
        font-size: 0.9rem;
        color: #6c757d;
    }
</style>

<div class="container-fluid mt-4">

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <h3>Property Tax Bills</h3>
    <hr>

    <form method="GET" action="{{ route('admin.property-tax.list') }}" class="mb-3">
        <div class="row align-items-end g-2">
            <div class="col-md-4">
                <label for="block_id" class="form-label mb-1">Filter by Block</label>
                <select name="block_id" id="block_id" class=" form-control">
                    <option value="">All Blocks</option>
                    @foreach($blocks as $block)
                        <option value="{{ $block->id }}" {{ (string) $selectedBlockId === (string) $block->id ? 'selected' : '' }}>
                            {{ $block->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <button type="submit" class="btn btn-primary btn-sm">Apply</button>
                   @php
                        $currentUser = auth()->user();
                    @endphp
                @if($currentUser?->isAdmin())
                <a href="{{url('admin/property-tax/upload')}}" class="btn btn-dark btn-sm">Click to Upload another file</a>
                @endif
            </div>
        </div>
    </form>

    <div class="table-responsive">

        <table class="table table-bordered table-striped">

            <thead>

            <tr>

                <th>ID</th>
                <th>Block</th>
                <th>Property ID</th>
                <th>Owner Name</th>
                <th>Father Name</th>
                <th>Address</th>
                <th>Bill Number</th>
                <th>Financial Year</th>
                <th>Action</th>

            </tr>

            </thead>

            <tbody>

            @php
                if(Request()->page){
                    $current_page = Request()->page; 
                }else{
                    $current_page = 1;
                }
            @endphp
            @forelse($records as $index=>$row)

                <tr>

                    <td>{{ ((($current_page-1)*20) + ++$index) }}</td>

                    <td>{{ $row->block->name ?? '-' }}</td>

                    <td>{{ $row->property_id }}</td>

                    <td>{{ $row->owner_name }}</td>

                    <td>{{ $row->father_name }}</td>

                    <td>{{ $row->address }}</td>

                    <td>{{ $row->bill_number }}</td>

                    <td>{{ $row->financial_year }}</td>

                    <td>

                        <a href="{{ route('admin.property-tax.bill.view',$row->id) }}"
                           class="btn btn-primary btn-sm">

                            View Bill

                        </a>

                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="9" class="text-center">
                        No Records Found
                    </td>
                </tr>

            @endforelse

            </tbody>

        </table>

        @if($records->hasPages())
            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mt-3 gap-2">
                <div class="records-summary">
                    Showing {{ $records->firstItem() }} to {{ $records->lastItem() }} of {{ $records->total() }} records
                </div>
                <div class="table-pagination">
                    {{ $records->links('pagination::bootstrap-4') }}
                </div>
            </div>
        @endif
<br />
    </div>

</div>

@endsection