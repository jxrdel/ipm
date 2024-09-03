@props(['url'])
<tr>
<td class="header">
<a href="http://10.100.0.86:5050" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="https://upload.wikimedia.org/wikipedia/commons/a/a1/Coat_of_arms_of_Trinidad_and_Tobago.svg" class="logo" alt="Laravel Logo">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
