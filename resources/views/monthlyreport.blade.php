@php
    use Carbon\Carbon;
@endphp

<x-mail::message>
Good day,

Please note that the following purchase contracts are scheduled to end within the next 4 months ( {{ $startdate}} - {{ $enddate }} ).

<table width="100%" cellpadding="0" cellspacing="0" border="1" style="border-collapse: collapse; width: 100%; border: 1px solid #ccc;">
    <thead>
        <tr style="background-color: #191980; text-align: center; color: #ffffff;">
            <th style="padding: 8px; border: 1px solid #ccc;">Contract</th>
            <th style="padding: 8px; border: 1px solid #ccc;">End Date</th>
            <th style="padding: 8px; border: 1px solid #ccc;">Cost</th>
            <th style="padding: 8px; border: 1px solid #ccc;">Time Remaining</th>
        </tr>
    </thead>
    <tbody>
        @foreach($contracts as $contract)
            <tr>
                <td style="padding: 8px; border: 1px solid #ccc;">{{ $contract->Name }}</td>
                <td style="padding: 8px; border: 1px solid #ccc;">
                    {{ \Carbon\Carbon::parse($contract->EndDate)->toFormattedDateString() }}
                </td>
                <td style="padding: 8px; border: 1px solid #ccc;">
                    ${{ number_format($contract->Cost, 2) }}
                </td>
                <td style="padding: 8px; border: 1px solid #ccc;">
                    {{ $contract->TimeRemaining }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>



<x-mail::button :url="$url">
    View Contracts
</x-mail::button>

</x-mail::message>