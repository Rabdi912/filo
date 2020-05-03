@component('mail::message')
# Your request has been {{ $approved }}!

Hello {{ $Name }},

This email is to confirm that your request for a {{ $itemColor }} {{ $itemCategory }} has been {{ $approved }}. Your request was submitted at {{ $requestSubmitted }}.

For more details please visit the FiLo System.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
