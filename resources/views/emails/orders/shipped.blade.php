@component('mail::message')
    @if($client == 'customer')
        Hi {{$shipping->customer->name}},

            Your Shipping Order has been confirmed with id: {{$shipping->id}}
    @elseif($client == 'admin')
        Hello Admin,

            A Shipping Order has just been requested with id: {{$shipping->id}} by {{$shipping->customer->name}}
    @endif

{{--@component('mail::button', ['url' => ''])--}}
{{--Click to see--}}
{{--@endcomponent--}}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
