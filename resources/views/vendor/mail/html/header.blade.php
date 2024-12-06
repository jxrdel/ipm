@props(['url'])
<tr>
<td class="header">
<a href="https://contracts.moh.gov.tt/" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<p>MOH VDS</p>
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
