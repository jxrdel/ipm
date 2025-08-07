@php
    use Carbon\Carbon;
@endphp

<x-mail::message>
Good day,

Please note that the following contracts are due to end within the next 4 months ( {{ $startdate}} - {{ $enddate }} ).

See attached file for more details.

<table width="100%" cellpadding="0" cellspacing="0" border="1" style="border-collapse: collapse; width: 100%; border: 1px solid #ccc;">
    <thead>
        <tr style="background-color: #191980; text-align: center; color: #ffffff;">
            <th style="padding: 8px; border: 1px solid #ccc;">Contract</th>
            <th style="padding: 8px; border: 1px solid #ccc;">End Date</th>
        </tr>
    </thead>
    <tbody>
        @foreach($contracts as $contract)
            <tr>
                <td style="padding: 8px; border: 1px solid #ccc;">{{ $contract->Name }}</td>
                <td style="padding: 8px; border: 1px solid #ccc;">
                    {{ \Carbon\Carbon::parse($contract->EndDate)->toFormattedDateString() }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>


<x-mail::button :url="$url">
    View Contracts
</x-mail::button>

</x-mail::message>