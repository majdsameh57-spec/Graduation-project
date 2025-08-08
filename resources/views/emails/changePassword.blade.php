<x-mail::message>
# تغيير كلمة المرور

{{-- {{ $name }} لما اكون معرف private وباعت المتغيرات في content --}}
{{ $user->name }}

<x-mail::panel :url="''">
تم تغير كلمة مرور حسابك , اذا لم تكن انت اتصل بالعميل
</x-mail::panel>

<x-mail::button :url="''">
اتصل بالعميل
</x-mail::button>

شكرا<br>
{{ config('app.name') }}
</x-mail::message>
