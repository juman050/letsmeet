@foreach($locations as $location)
<li class="locations-id" data-name="{{$location->name}}" data-id="{{$location->location_id}}">{{$location->name}}</li>
@endforeach