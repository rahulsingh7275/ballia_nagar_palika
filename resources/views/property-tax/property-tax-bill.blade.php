@extends('layouts.app')

@section('title','Property Tax Bill')

@section('content')

@php

$grandTotal =
$row->house_tax_total_amount +
$row->water_tax_total_amount +
$row->water_charge_total_amount +
$row->sewerage_tax_total_amount +
$row->other_tax_total_amount;

@endphp

<style>
.container-bill{
    width:1000px;
    margin:auto;
    border:1px solid #000;
    padding:10px;
    background:#fff;
}
table{
    width:100%;
    border-collapse:collapse;
}
td,th{
    border:1px solid #000;
    padding:5px;
}
.center{text-align:center;}
.no-border{border:none!important;}
.tax-table td,.tax-table th{
    border:1px solid #000;
}
</style>


<div class="container-bill">

    <div style="display:flex;justify-content:flex-end;gap:8px;margin-bottom:10px;">
        <button type="button" onclick="window.print()" style="display:inline-flex;align-items:center;gap:6px;padding:6px 10px;background:#2563eb;color:#fff;border:none;border-radius:4px;cursor:pointer;">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2V9a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v7a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8" rx="2" ry="2"/></svg>
            Print / Save as PDF
        </button>
    </div>

    <table>
        <tr>

            <td width="25%" class="no-border">

                <b>बिल संख्या :</b>
                {{ $row->bill_number }}

                <br><br>

                <b>बिल दिनांक :</b>
                {{ $row->bill_date }}

            </td>

            <td width="50%" class="no-border center">

                <h2>नगर पालिका परिषद</h2>

                <h3>संपत्ति कर बिल</h3>

            </td>

            <td width="25%" class="no-border center">

                QR

            </td>

        </tr>
    </table>

    <table>

        <tr>
            <th colspan="8">
                गृह सम्बन्धी विवरण
            </th>
        </tr>

        <tr>

            <td>नई प्रापर्टी आईडी</td>
            <td>{{ $row->property_id }}</td>

            <td>पुरानी प्रापर्टी आईडी</td>
            <td>{{ $row->old_property_id }}</td>

            <td>चक नम्बर</td>
            <td>{{ $row->chuk_number }}</td>

            <td>वित्तीय वर्ष</td>
            <td>{{ $row->financial_year }}</td>

        </tr>

        <tr>

            <td>जोन</td>
            <td>{{ $row->zone_id }}</td>

            <td>वार्ड</td>
            <td colspan="2">{{ $row->ward_id }}</td>

            <td>मोहल्ला</td>
            <td colspan="2">{{ $row->mohalla_id }}</td>

        </tr>

        <tr>

            <td colspan="5">

                Name :
                {{ $row->owner_name }}

                <br><br>

                Father Name :
                {{ $row->father_name }}

                <br><br>

                House No :
                {{ $row->house_no }}

                <br><br>

                Address :
                {{ $row->address }}

                <br><br>

                Mobile :
                {{ $row->mobile }}

            </td>

            <td>{{ $row->total_arv }}</td>

            <td>{{ $row->created_at?->format('d-M-Y') }}</td>

            <td>{{ $row->property_type_id }}</td>

        </tr>

    </table>

    <br>

    <table class="tax-table">

        <tr>
            <th colspan="11">वित्तीय विवरण</th>
        </tr>

        <tr>
            <th>क्र०सं०</th>
            <th colspan="2">गृहकर</th>
            <th colspan="2">जलकर</th>
            <th colspan="2">जल शुल्क</th>
            <th colspan="2">सीवरेजकर</th>
            <th colspan="2">अन्यकर</th>
        </tr>

        <tr>
            <td>1</td>

            <td>वार्षिक मांग</td>
            <td>{{ $row->house_tax_current_tax }}</td>

            <td>वार्षिक मांग</td>
            <td>{{ $row->water_tax_current_tax }}</td>

            <td>वार्षिक मांग</td>
            <td>{{ $row->water_charge_current_tax }}</td>

            <td>वार्षिक मांग</td>
            <td>{{ $row->sewerage_tax_current_tax }}</td>

            <td>वार्षिक मांग</td>
            <td>{{ $row->other_tax_current_tax }}</td>
        </tr>

        <tr>
            <td>2</td>

            <td>बकाया</td>
            <td>{{ $row->house_tax_arrear }}</td>

            <td>बकाया</td>
            <td>{{ $row->water_tax_arrear }}</td>

            <td>बकाया</td>
            <td>{{ $row->water_charge_arrear }}</td>

            <td>बकाया</td>
            <td>{{ $row->sewerage_tax_arrear }}</td>

            <td>बकाया</td>
            <td>{{ $row->other_tax_arrear }}</td>
        </tr>

        <tr>
            <td>3</td>

            <td>ब्याज</td>
            <td>{{ $row->house_tax_interest }}</td>

            <td>ब्याज</td>
            <td>{{ $row->water_tax_interest }}</td>

            <td>ब्याज</td>
            <td>{{ $row->water_charge_interest }}</td>

            <td>ब्याज</td>
            <td>{{ $row->sewerage_tax_interest }}</td>

            <td>ब्याज</td>
            <td>{{ $row->other_tax_interest }}</td>
        </tr>
        

        <tr>
    <td>4</td>

    <td>मासिक ब्याज</td>
    <td>0.00</td>

    <td>मासिक ब्याज</td>
    <td>0.00</td>

    <td>मासिक ब्याज</td>
    <td>0.00</td>

    <td>मासिक ब्याज</td>
    <td>0.00</td>

    <td>मासिक ब्याज</td>
    <td>0.00</td>
</tr>

<tr>
    <td>5</td>

    <td><b>कुल मांग</b></td>
    <td><b>{{ $row->house_tax_total_amount }}</b></td>

    <td><b>कुल मांग</b></td>
    <td><b>{{ $row->water_tax_total_amount }}</b></td>

    <td><b>कुल मांग</b></td>
    <td><b>{{ $row->water_charge_total_amount }}</b></td>

    <td><b>कुल मांग</b></td>
    <td><b>{{ $row->sewerage_tax_total_amount }}</b></td>

    <td><b>कुल मांग</b></td>
    <td><b>{{ $row->other_tax_total_amount }}</b></td>
</tr>

<tr>
    <td>6</td>

    <td>छूट</td>
    <td>0.00</td>

    <td>छूट</td>
    <td>0.00</td>

    <td>छूट</td>
    <td>0.00</td>

    <td>छूट</td>
    <td>0.00</td>

    <td>छूट</td>
    <td>0.00</td>
</tr>

<tr>
    <td>7</td>

    <td>अग्रिम जमा *</td>
    <td>{{ $row->previous_year_advance_house }}</td>

    <td>अग्रिम जमा *</td>
    <td>{{ $row->previous_year_advance_water }}</td>

    <td>अग्रिम जमा *</td>
    <td>{{ $row->previous_year_advance_water_charge }}</td>

    <td>अग्रिम जमा *</td>
    <td>{{ $row->previous_year_advance_sewerage }}</td>

    <td>अग्रिम जमा *</td>
    <td>{{ $row->previous_year_advance_other }}</td>
</tr>

<tr>
    <td>8</td>

    <td><b>देय धनराशि</b></td>
    <td><b>{{ $row->house_tax_total_amount }}</b></td>

    <td><b>देय धनराशि</b></td>
    <td><b>{{ $row->water_tax_total_amount }}</b></td>

    <td><b>देय धनराशि</b></td>
    <td><b>{{ $row->water_charge_total_amount }}</b></td>

    <td><b>देय धनराशि</b></td>
    <td><b>{{ $row->sewerage_tax_total_amount }}</b></td>

    <td><b>देय धनराशि</b></td>
    <td><b>{{ $row->other_tax_total_amount }}</b></td>
</tr>

    </table>

    <br>

    <table class="tax-table">

    <tr>
        <th colspan="11" style="text-align:left;padding:8px;">
            सम्पूर्ण देय धनराशि योग (Grand Total) :
            {{ number_format($grandTotal,2) }}
        </th>
    </tr>

    <tr>

        <td></td>

        <td>भुगतान हेतु शेष राशि</td>
        <td>{{ $row->house_tax_total_amount }}</td>

        <td>भुगतान हेतु शेष राशि</td>
        <td>{{ $row->water_tax_total_amount }}</td>

        <td>भुगतान हेतु शेष राशि</td>
        <td>{{ $row->water_charge_total_amount }}</td>

        <td>भुगतान हेतु शेष राशि</td>
        <td>{{ $row->sewerage_tax_total_amount }}</td>

        <td>भुगतान हेतु शेष राशि</td>
        <td>{{ $row->other_tax_total_amount }}</td>

    </tr>

</table>
<div style="text-align:center;font-weight:bold;margin-top:10px;">
*** Information provided online is updated and no physical visit is required ***
</div>
<table style="margin-top:10px;">

<tr>
    <td style="background:#efefef;font-weight:bold;">
        वित्तीय वर्ष {{ $row->financial_year }} में पूर्व जमा धनराशि के विवरण
    </td>
</tr>

<tr>
    <td style="text-align:center;">
        No Previous Payment Transaction Done Through
        https://e-nagarsewaup.gov.in
        in Financial Year {{ $row->financial_year }}
    </td>
</tr>

</table>
<div style="margin-top:15px;text-align:center;font-size:11px;line-height:20px;">

Software developed by National Informatics Centre (NIC).

<br>

Data displayed on this website is the responsibility
of the concerned Urban Local Body (ULB).

<br>

In case of any discrepancy in the data, citizen should contact
the concerned Nagar Nigam / Nagar Palika Parishad / Nagar Panchayat.

<br>

NIC is not responsible for the correctness of the data.

</div>
</div>

<script>
function downloadCSV(){
    const row = @json($row);
    if(!row){ alert('No data to download'); return; }

    const headers = ['bill_number','bill_date','property_id','old_property_id','chuk_number','financial_year','owner_name','father_name','house_no','address','mobile','total_arv','created_at','property_type_id'];
    const values = headers.map(h => (row[h] === null || row[h] === undefined) ? '' : String(row[h]));

    const escapeCell = (s) => '"' + s.replace(/"/g, '""') + '"';
    const csv = headers.join(',') + '\n' + values.map(escapeCell).join(',');

    const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    const filename = 'property-tax-bill-' + (row.bill_number || 'record') + '.csv';
    a.download = filename;
    document.body.appendChild(a);
    a.click();
    a.remove();
    URL.revokeObjectURL(url);
}
</script>

@endsection