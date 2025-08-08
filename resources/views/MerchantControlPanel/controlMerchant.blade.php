@extends('MerchantControlPanel.parent')

@section('title', 'سيولتك - لوحة تحكم التاجر')

@section('styles')
    <style>
        .greeting-section {
            text-align: center;
            padding: 50px 0;
            background-color: #f0f8ff;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        .greeting-section h1 {
            font-size: 2rem;
            font-weight: bold;
            color: #007bff;
        }
        .greeting-section p {
            font-size: 1.2rem;
            color: #333;
        }
    </style>
@endsection

@section('content')
    <div class="container mt-5">
        <div class="greeting-section">
            <h1>مرحبًا بك، </h1>
            <p>أنت الآن في لوحة تحكم التاجر الخاصة بك. من هنا يمكنك إدارة جميع التفاصيل المتعلقة بمتجرك.</p>
        </div>
    </div>
@endsection
