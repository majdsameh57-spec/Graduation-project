<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\shop;
use App\Models\merchant;
use App\Models\product;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // إحصائيات
        $shopsCount = shop::count();
        $activeMerchantsCount = merchant::count();
        $productsCount = product::count();
        $branchesCount = \App\Models\branch::count();

        // رسم بياني: عدد المحلات لكل شهر آخر 12 شهر
        $months = collect(range(0, 11))->map(function($i) {
            return Carbon::now()->subMonths($i)->format('Y-m');
        })->reverse()->values();
        $labels = $months->map(function($m) {
            return Carbon::createFromFormat('Y-m', $m)->translatedFormat('F Y');
        });
        $data = $months->map(function($m) {
            return shop::whereYear('created_at', substr($m,0,4))->whereMonth('created_at', substr($m,5,2))->count();
        });
        $shopsPerMonth = [
            'labels' => $labels,
            'data' => $data,
        ];

        // آخر 5 عمليات (تاجر جديد أو منتج جديد)
        $recentMerchants = merchant::orderBy('created_at', 'desc')->take(5)->get()->map(function($m) {
            return [
                'type' => 'merchant',
                'name' => $m->name,
                'created_at' => $m->created_at,
            ];
        });
        $recentProductsSimple = product::orderBy('created_at', 'desc')->take(5)->get()->map(function($p) {
            return [
                'type' => 'product',
                'name' => $p->name,
                'created_at' => $p->created_at,
            ];
        });
        $recentActivities = $recentMerchants->merge($recentProductsSimple)->sortByDesc('created_at')->take(5)->values();
        $recentShops = shop::with('merchant')->latest()->take(5)->get();
        $recentProducts = product::with('shop')->latest()->take(5)->get();

        return view('MerchantControlPanel.admin-dashboard', compact(
            'shopsCount', 'activeMerchantsCount', 'productsCount', 'branchesCount',
            'shopsPerMonth', 'recentActivities', 'recentShops', 'recentProducts'
        ));
    }
}
