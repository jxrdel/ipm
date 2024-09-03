<x-mail::message>
Please be advised that the contract for <strong>{{$itemname}}</strong> ends in {{$daysdifference}} days on <strong>{{$enddate}}</strong> 
 
<x-mail::button :url="$url">
View Contracts
</x-mail::button>
 

</x-mail::message>