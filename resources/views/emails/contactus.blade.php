@component('mail::message')
{{ $details['name'] }} : رسالة من

{{ $details['email'] }}  : البريد الإلكتروني

{{-- **الموضوع:** {{ $details['subject'] }} --}}

   :الرسالة

{{ $details['message'] }}

@endcomponent
