<x-mail::message>
# welcome {{ $info['name'] }}

{{ $info['body'] }}

<x-mail::button :url="''">
Button Text
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
