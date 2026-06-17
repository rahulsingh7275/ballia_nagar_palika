@extends('layouts.app')

@section('title','Property Tax Bills')

@section('content')

<div class="container-fluid mt-4">

    <h3>Property Tax Bills</h3>

    <div class="table-responsive">

        <table class="table table-bordered table-striped">

            <thead>

            <tr>

                <th>ID</th>
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

            @forelse($records as $row)

                <tr>

                    <td>{{ $row->id }}</td>

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
                    <td colspan="8" class="text-center">
                        No Records Found
                    </td>
                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection