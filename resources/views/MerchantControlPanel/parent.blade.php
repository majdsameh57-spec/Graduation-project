<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places"></script>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('assets/bootstrap-5.3.0-alpha1/dist/css/bootstrap.rtl.min.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/toastr@2.1.4/build/toastr.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        :root {
            --primary-color: #0047b3;
            --primary-hover: #0035a0;
            --primary-light: #e3f2fd;
            --secondary-color: #0054d7;
            --sidebar-width: 280px;
            --content-bg: #f8fafc;
            --card-bg: #fff;
            --text-color: #1e293b;
            --text-light: #64748b;
            --accent-color: #FFB800;
            --success-color: #10b981;
            --danger-color: #ef4444;
            --border-radius: 14px;
            --border-radius-sm: 8px;
            --card-shadow: 0 2px 12px rgba(0,71,179,0.07);
            --card-shadow-hover: 0 8px 24px rgba(0,71,179,0.15);
            --transition-speed: 0.25s;
        }
        
        .sticky-nav-wrapper {
            position: relative;
            z-index: 999;
            height: 70px;
        }
        
        .navbar {
            transition: all 0.3s ease;
            padding: 0 1rem;
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(0,71,179,0.1);
            left: 0;
            right: 0;
            box-shadow: 0 4px 20px rgba(0,71,179,0.12);
            display: flex;
            align-items: center;
        }
        
        .navbar.fixed-top {
            top: 0;
            padding-right: calc(var(--sidebar-width) + 1rem);
            margin-right: 0;
            width: 100%;
            z-index: 99;
            left: 0;
            height: 70px;
        }
        
        @media (max-width: 992px) {
            .sticky-nav-wrapper {
                height: 60px;
            }
            
            .navbar.fixed-top {
                padding-right: 1rem;
                width: 100%;
                height: 60px;
            }
        }
        
        @media (max-width: 576px) {
            .sticky-nav-wrapper {
                height: 55px;
            }
            
            .navbar.fixed-top {
                height: 55px;
            }
        }
        
        .content-wrapper {
            padding-top: 40px !important;
        }
        
        .navbar-brand {
            font-weight: 700;
            color: var(--primary-color);
            padding: 0;
            position: relative;
        }
        
        .navbar-brand:after {
            content: '';
            position: absolute;
            bottom: -10px;
            right: 0;
            width: 40px;
            height: 3px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
            border-radius: 5px;
            transition: all 0.3s ease;
        }
        
        .navbar-brand:hover:after {
            width: 100%;
        }
        
        .page-title {
            color: var(--text-color);
            font-weight: 600;
            font-size: 1.1rem;
            position: relative;
            padding: 0.5rem 1rem;
            background: rgba(0,71,179,0.04);
            border-radius: var(--border-radius-sm);
        }
        
        .user-menu {
            display: flex;
            align-items: center;
        }
        
        .user-type .badge {
            padding: 0.35em 0.65em;
            font-weight: 500;
            border-radius: var(--border-radius-sm);
        }
        
        .bg-primary-light {
            background-color: var(--primary-light);
        }
        
        .bg-success-light {
            background-color: rgba(16,185,129,0.15);
        }
        
        .text-success {
            color: var(--success-color);
        }
        
        .user-avatar {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 42px;
            height: 42px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border-radius: 50%;
            font-weight: 600;
            font-size: 1.1rem;
            box-shadow: 0 3px 10px rgba(0,71,179,0.25);
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
            border: 2px solid rgba(255, 255, 255, 0.8);
        }
        
        .user-avatar:before {
            content: '';
            position: absolute;
            top: -10px;
            right: -10px;
            width: 20px;
            height: 20px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            transition: all 0.5s ease;
        }
        
        .user-avatar:hover {
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 6px 15px rgba(0,71,179,0.35);
        }
        
        .user-avatar:hover:before {
            transform: scale(8);
            opacity: 0.2;
        }

        .dropdown-menu {
            box-shadow: var(--card-shadow);
            border-radius: var(--border-radius-sm);
            border: 1px solid rgba(0,71,179,0.05);
            padding: 0.5rem 0;
            min-width: 220px;
            margin-top: 0.75rem;
            animation: fadeInDown 0.3s ease;
        }
        
        .user-profile-btn {
            background: transparent;
            border: none;
            color: var(--text-color);
            display: flex;
            align-items: center;
            padding: 0.5rem 0.75rem;
            border-radius: 50px;
            transition: all 0.3s ease;
            box-shadow: none;
        }
        
        .user-profile-btn:hover, .user-profile-btn:focus {
            background-color: rgba(0,71,179,0.05);
            color: var(--primary-color);
            box-shadow: none;
            transform: translateY(-2px);
        }
        
        .profile-dropdown-icon {
            font-size: 0.75rem;
            opacity: 0.7;
            transition: all 0.3s;
        }
        
        .user-profile-btn:hover .profile-dropdown-icon {
            opacity: 1;
            transform: rotate(180deg);
        }
        
        .profile-dropdown {
            padding: 0;
            width: 280px;
        }
        
        .dropdown-header {
            background-color: rgba(0,71,179,0.03);
            padding: 1rem;
            border-bottom: 1px solid rgba(0,71,179,0.05);
        }
        
        .dropdown-user-avatar {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border-radius: 50%;
            font-weight: 600;
            font-size: 1rem;
            box-shadow: 0 3px 10px rgba(0,71,179,0.25);
        }
        
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .dropdown-item {
            padding: 0.65rem 1rem;
            font-size: 0.9rem;
            font-weight: 500;
            color: var(--text-color);
            transition: all 0.2s;
            display: flex;
            align-items: center;
        }
        
        .dropdown-item:hover, .dropdown-item:focus {
            background-color: var(--primary-light);
            color: var(--primary-color);
            transform: translateX(-4px);
        }
        
        .dropdown-item i {
            width: 1.3rem;
            text-align: center;
            margin-left: 0.5rem;
            transition: all 0.2s;
        }
        
        .dropdown-item:hover i {
            transform: scale(1.15);
        }
        
        .dropdown-divider {
            margin: 0.5rem 0;
            opacity: 0.1;
        }
        
        .dropdown-item.text-danger {
            color: var(--danger-color);
        }
        
        .dropdown-item.text-danger:hover {
            background-color: rgba(239,68,68,0.1);
        }
        @media (max-width: 1200px) {
            :root {
                --sidebar-width: 250px;
            }
            .sidebar-section-title {
                font-size: 1rem;
            }
            .sidebar-link {
                padding: 0.65rem 1.25rem;
            }
        }
        
        @media (max-width: 992px) {
            :root {
                --sidebar-width: 280px;             }
            .navbar {
                padding: 0.5rem 1rem;
                flex-wrap: nowrap;
                flex-direction: row;
                min-height: 60px;
                justify-content: space-between;
                width: 100% !important;
            }
            .navbar-brand h2 {
                font-size: 1.1rem !important;
                margin-bottom: 0 !important;
            }
            .navbar-brand {
                font-size: 1rem !important;
                padding: 0.2rem 0;
                margin-right: 0;
                margin-left: auto;
            }
            .page-title {
                display: none;
            }
            .user-menu {
                flex-direction: row;
                gap: 0.5rem;
                align-items: center;
                justify-content: flex-end;
            }
            .dropdown-menu.profile-dropdown {
                min-width: 260px !important;
                right: 0 !important;
                left: auto !important;
                border-radius: var(--border-radius) !important;
                margin-top: 0.5rem !important;
                position: absolute;
            }
        }
        
        @media (max-width: 768px) {
            .navbar-brand h2 {
                font-size: 0.95rem !important;
            }
            .navbar-brand {
                font-size: 0.95rem !important;
            }
            .dropdown .btn {
                padding: 0.4rem 0.75rem;
                font-size: 0.9rem;
            }
            .user-menu {
                gap: 0.4rem;
            }
            .content-wrapper {
                padding: 1.25rem 0.9rem;
                padding-top: 75px !important;
            }
        }
        
        @media (max-width: 576px) {
            .user-menu {
                gap: 0.3rem;
            }
            .navbar {
                padding: 0.4rem 0.75rem;
            }
            .user-profile-btn {
                padding: 0.4rem 0.5rem;
            }
            .user-avatar {
                width: 36px;
                height: 36px;
                font-size: 0.9rem;
            }
            .dropdown-menu.profile-dropdown {
                min-width: 100% !important;
                width: calc(100vw - 30px);
                right: 0 !important;
                left: auto !important;
            }
            #mobileMenuBtn {
                width: 34px;
                height: 34px;
            }
        }
        
        @media (max-width: 380px) {
            .navbar-brand h2 {
                font-size: 0.85rem !important;
            }
            .font-semibold.me-1.d-none.d-sm-inline-block {
                display: none !important;
            }
        }
        
        body {
            font-family: 'Tajawal', Arial, sans-serif;
            background-color: var(--content-bg);
            color: var(--text-color);
            min-height: 100vh;
            overflow-x: hidden;
        }
        
        .sidebar {
            background: linear-gradient(135deg, #0047b3 70%, #0054d7 100%);
            width: var(--sidebar-width);
            min-height: 100vh;
            position: fixed;
            top: 0;
            right: 0;
            z-index: 1050;
            transition: all 0.3s ease;
            overflow-y: auto;
            box-shadow: 0 0 24px 0 rgba(0,71,179,0.15);
            max-height: 100vh;
            -webkit-overflow-scrolling: touch;
        }
        
        .sidebar::-webkit-scrollbar {
            width: 5px;
        }
        
        .sidebar::-webkit-scrollbar-thumb {
            background-color: rgba(255,255,255,0.2);
            border-radius: 6px;
        }
        
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(100%);
                right: 0;
                width: var(--sidebar-width);
                box-shadow: -5px 0 15px rgba(0,0,0,0.1);
            }
            
            .sidebar.show {
                transform: translateX(0);
            }
        }
        
        .sidebar-header {
            padding: 1.75rem 1.5rem 1.25rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        
        .sidebar-logo {
            font-size: 1.8rem;
            font-weight: 700;
            color: #fff;
            margin-bottom: 0.75rem;
            display: block;
            text-decoration: none;
        }
        
        .sidebar-logo:hover {
            color: #fff;
            text-decoration: none;
        }
        
        .sidebar-user {
            color: rgba(255,255,255,0.95);
            font-size: 1rem;
            font-weight: 500;
            margin-bottom: 1.5rem;
        }
        
        .sidebar-section {
            padding: 1.15rem 0 0.7rem 0;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        
        .sidebar-section-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #fff;
            padding: 0 1.5rem;
            margin-bottom: 0.8rem;
            display: flex;
            align-items: center;
        }
        
        .sidebar-section-title i {
            margin-left: 0.5rem;
            opacity: 0.9;
            font-size: 0.9rem;
        }
        
        .sidebar-nav {
            max-height: calc(100vh - 160px);
            overflow-y: auto;
            padding-bottom: 2rem;
            scrollbar-width: thin;
            scrollbar-color: rgba(255,255,255,0.2) transparent;
        }
        
        .sidebar-link {
            display: flex;
            align-items: center;
            padding: 0.7rem 1.5rem;
            color: rgba(255,255,255,0.85);
            text-decoration: none;
            transition: all var(--transition-speed);
            border-radius: var(--border-radius-sm);
            margin: 0.25rem 0.8rem;
            font-weight: 500;
        }
        
        .sidebar-link:hover, .sidebar-link.active {
            background: rgba(255,255,255,0.15);
            color: #fff;
            transform: translateX(-4px);
        }
        
        .sidebar-link i, .sidebar-link svg {
            margin-left: 0.8rem;
            font-size: 1.1rem;
            width: 1.3rem;
            text-align: center;
            transition: all var(--transition-speed);
        }
        
        .sidebar-link:hover i {
            transform: scale(1.15);
        }
        
        .content-wrapper {
            margin-right: var(--sidebar-width);
            padding: 2rem 1.5rem;
            min-height: 100vh;
            background: none;
            transition: all 0.3s ease;
            width: calc(100% - var(--sidebar-width));
        }
        
        @media (max-width: 992px) {
            .content-wrapper {
                margin-right: 0;
                width: 100%;
                padding: 1.75rem 1.25rem;
                padding-top: 70px !important;
            }
        }
        
        @media (max-width: 576px) {
            .content-wrapper {
                padding: 1.5rem 1rem;
                padding-top: 65px !important;
            }
        }
        .dashboard-card {
            background: var(--card-bg);
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
            padding: 1.75rem;
            height: 100%;
            border: none;
            transition: all var(--transition-speed);
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(0,71,179,0.05);
        }
        
        .dashboard-card:hover {
            box-shadow: var(--card-shadow-hover);
            transform: translateY(-3px);
        }
        
        .dashboard-card .card-title {
            color: var(--primary-color);
            font-weight: 700;
            font-size: 1.25rem;
            margin-bottom: 1.25rem;
            display: flex;
            align-items: center;
        }
        
        .dashboard-card .card-title i {
            margin-left: 0.5rem;
            font-size: 1.15rem;
        }
        
        .table {
            color: var(--text-color);
            margin-bottom: 0;
            vertical-align: middle;
        }
        
        .table thead th {
            font-weight: 600;
            border-bottom: 2px solid #e2e8f0;
            color: var(--text-color);
            background-color: rgba(0,71,179,0.03);
            padding: 0.75rem 1rem;
        }
        
        .table tbody td {
            padding: 0.75rem 1rem;
            vertical-align: middle;
        }
        
        .table-hover tbody tr:hover {
            background-color: rgba(0,71,179,0.02);
        }
        
        .table-responsive {
            border-radius: var(--border-radius-sm);
            overflow: hidden;
        }
        
        .btn {
            border-radius: var(--border-radius-sm);
            font-weight: 500;
            padding: 0.6rem 1.25rem;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }
        
        .btn-sm {
            padding: 0.4rem 0.75rem;
            font-size: 0.9rem;
        }
        
        .btn-group .btn {
            margin: 0 2px;
        }
        
        .btn i {
            font-size: 0.9rem;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover, .btn-primary:focus {
            background-color: var(--primary-hover);
            border-color: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,71,179,0.2);
        }
        
        .btn-info {
            background-color: #0ea5e9;
            border-color: #0ea5e9;
        }
        
        .btn-info:hover, .btn-info:focus {
            background-color: #0284c7;
            border-color: #0284c7;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(14,165,233,0.2);
        }
        
        .btn-danger {
            background-color: var(--danger-color);
            border-color: var(--danger-color);
        }
        
        .btn-danger:hover, .btn-danger:focus {
            background-color: #dc2626;
            border-color: #dc2626;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(239,68,68,0.2);
        }
        
        .form-control, .form-select {
            border-radius: var(--border-radius-sm);
            padding: 0.65rem 0.85rem;
            border: 1px solid #e2e8f0;
            transition: all var(--transition-speed);
            font-size: 1rem;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(0,71,179,0.15);
        }
        
        .form-label {
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--text-color);
            font-size: 0.95rem;
        }
        
        #map {
            height: 350px;
            width: 100%;
            border-radius: var(--border-radius);
            margin-top: 1rem;
            box-shadow: var(--card-shadow);
            border: 1px solid rgba(0,71,179,0.05);
        }
        
        .badge {
            font-weight: 500;
            padding: 0.35em 0.65em;
            border-radius: 6px;
        }
        
        .pagination {
            margin-bottom: 0;
        }
        
        .page-item .page-link {
            color: var(--primary-color);
            border-radius: var(--border-radius-sm);
            margin: 0 2px;
            font-weight: 500;
        }
        
        .page-item.active .page-link {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .stats-card {
            background: var(--card-bg);
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
            padding: 1.75rem;
            display: flex;
            align-items: center;
            gap: 1.25rem;
            margin-bottom: 1.5rem;
            border: 1px solid var(--primary-light);
            transition: all var(--transition-speed);
            position: relative;
            overflow: hidden;
        }
        
        .stats-card:hover {
            box-shadow: var(--card-shadow-hover);
            transform: translateY(-3px);
            border-color: rgba(0,71,179,0.2);
        }
        
        .stats-card:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
            transform: scaleX(0);
            transform-origin: right;
            transition: transform 0.3s ease;
        }
        
        .stats-card:hover:after {
            transform: scaleX(1);
            transform-origin: left;
        }
        
        .stats-icon {
            font-size: 2.5rem;
            color: var(--primary-color);
            background: var(--primary-light);
            border-radius: 50%;
            width: 65px;
            height: 65px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
            border: 1px solid rgba(0,71,179,0.1);
        }
        
        .stats-card:hover .stats-icon {
            transform: scale(1.1) rotate(5deg);
        }
        
        .stats-info {
            flex: 1;
        }
        
        .stats-title {
            font-size: 0.95rem;
            color: var(--text-light);
            font-weight: 600;
            margin-bottom: 0.25rem;
        }
        
        .stats-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-color);
        }
        
        @media (max-width: 1280px) {
            .content-wrapper {
                padding: 1.5rem 1rem;
            }
            
            .stats-card {
                padding: 1.5rem;
            }
            
            .stats-icon {
                width: 55px;
                height: 55px;
                font-size: 2rem;
            }
        }
        
        @media (max-width: 992px) {
            .sidebar {
                position: fixed;
                right: -100%;
                z-index: 200;
                box-shadow: 0 0 30px rgba(0,0,0,0.2);
            }
            
            .sidebar.show {
                right: 0;
            }
            
            .content-wrapper {
                margin-right: 0;
                padding: 1.5rem 1rem;
                padding-top: 90px !important;
            }
            
            .dashboard-card {
                padding: 1.5rem;
            }
        }
        
        @media (max-width: 768px) {
            .dashboard-card {
                padding: 1.25rem;
            }
            
            .stats-card {
                padding: 1.25rem;
                margin-bottom: 1rem;
            }
            
            .stats-icon {
                width: 50px;
                height: 50px;
                font-size: 1.75rem;
            }
            
            .stats-value {
                font-size: 1.3rem;
            }
        }
        
        @media (max-width: 576px) {
            .sidebar {
                width: 100%;
            }
            
            .content-wrapper {
                padding: 1.25rem 0.75rem;
                padding-top: 4rem;
            }
            
            .dashboard-card {
                padding: 1rem;
            }
            
            .table {
                font-size: 0.9rem;
            }
            
            .btn-group {
                flex-wrap: nowrap;
            }
            
            .btn-sm {
                padding: 0.35rem 0.6rem;
                font-size: 0.85rem;
            }
        }
        
        #mobileMenuBtn {
            position: relative;
            z-index: 1050;
            background-color: var(--primary-color);
            color: #fff;
            border: none;
            border-radius: var(--border-radius-sm);
            width: 38px;
            height: 38px;
            display: none;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 10px rgba(0,71,179,0.2);
            transition: all 0.2s;
            margin-right: 0;
        }
        #mobileMenuBtn i {
            font-size: 1.1rem;
        }
        #mobileMenuBtn:hover {
            background-color: var(--primary-hover);
            transform: scale(1.05);
        }
        @media (max-width: 992px) {
            #mobileMenuBtn {
                display: flex;
                margin-right: 0;
            }
        }
        
        @media (max-width: 992px) {
            #overlay {
                transition: opacity 0.3s ease;
            }
            
            #overlay.show {
                display: block !important;
                opacity: 0.5 !important;
            }
            
            body.menu-open {
                overflow: hidden;
            }
        }
        
        .sidebar.show {
            z-index: 1060;
        }
        
        .sticky-nav-wrapper + * {
            padding-top: 0.5rem;
        }
        
        .sidebar-link i {
            transition: transform 0.3s;
        }
        
        .sidebar-link:hover i {
            transform: scale(1.15);
        }
    </style>
    @yield('styles')
</head>

<body>
    <div class="flex flex-col-reverse lg:flex-row min-h-screen w-full">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <a href="" class="sidebar-logo">
                    <i class="fas fa-money-bill-wave me-2"></i>سيولتك
                </a>
                <div class="sidebar-user">
                    <span class="font-bold">مرحباً،</span>
                    {{ auth('admin')->check() ? auth('admin')->user()->name : auth('merchant')->user()->name }}
                </div>
            </div>

            <div class="sidebar-nav">
                {{-- لوحة إحصائيات التاجر (تظهر فقط للتاجر، وأول السايدبار) --}}
                @if(auth('merchant')->check())
                    <div class="sidebar-section">
                        <a href="{{ route('controlMerchant') }}" class="sidebar-link {{ request()->routeIs('controlMerchant') ? 'active' : '' }}">
                            <i class="fas fa-chart-bar"></i>
                            <span>لوحة الإحصائيات</span>
                        </a>
                    </div>
                @endif

                {{-- باقي السايدبار كما هو --}}
                @if(auth('admin')->check())
                <div class="sidebar-section">
                    <div class="sidebar-section-title">لوحة التحكم</div>
                    <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ (request()->routeIs('admin.dashboard') || request()->is('admin/dashboard') || request()->is('your-liquidity/control-merchant')) ? 'active' : '' }}">
                        <i class="fas fa-chart-bar"></i>
                        <span>لوحة تحكم المشرف</span>
                    </a>
                    <a href="{{ route('admin.shops') }}" class="sidebar-link {{ request()->routeIs('admin.shops') ? 'active' : '' }}">
                        <i class="fas fa-store"></i>
                        <span>إدارة المحلات</span>
                    </a>
                </div>
                @endif

                @canany(['Create-Shop', 'Create-Branch', 'Read-Products', 'Create-Product'])
                <div class="sidebar-section">
                    <div class="sidebar-section-title">بيانات المنتج</div>
                    @can(['Create-Shop'])
                    <a href="{{ route('shops.create') }}" 
                        class="sidebar-link {{ request()->routeIs('shops.create') ? 'active' : '' }}">
                        <i class="fas fa-store"></i>
                        <span>انشاء محل</span>
                    </a>
                    <a href="{{ route('shops.index') }}" 
                        class="sidebar-link {{ request()->routeIs('shops.index') ? 'active' : '' }}">
                        <i class="fas fa-store-alt"></i>
                        <span>عرض المحلات</span>
                    </a>
                    @endcan

                    @can(['Create-Branch'])
                    <a href="{{ route('branches.create') }}" 
                        class="sidebar-link {{ request()->routeIs('branches.create') ? 'active' : '' }}">
                    <i class="bi bi-diagram-3-fill me-2"></i>
                        <span>الفروع</span>
                    </a>
                    <a href="{{ route('paymentMethods.create') }}" 
                        class="sidebar-link {{ request()->routeIs('paymentMethods.create') ? 'active' : '' }}">
                        <i class="fas fa-credit-card"></i>
                        <span>طرق الدفع</span>
                    </a>
                    @endcan

                    @can(['Read-Products'])
                    @if(auth('admin')->check())
                    <a href="{{ route('admin.products') }}" 
                        class="sidebar-link {{ request()->routeIs('admin.products') ? 'active' : '' }}">
                        <i class="fas fa-box"></i>
                        <span>المنتجات</span>
                    </a>
                    @else
                    <a href="{{ route('products.index') }}" 
                        class="sidebar-link {{ request()->routeIs('products.index') ? 'active' : '' }}">
                        <i class="fas fa-box"></i>
                        <span>المنتجات</span>
                    </a>
                    @endif
                    @endcan

                    @can(['Create-Product'])
                    <a href="{{ route('products.create') }}" 
                        class="sidebar-link {{ request()->routeIs('products.create') ? 'active' : '' }}">
                        <i class="fas fa-upload"></i>
                        <span>رفع منتج</span>
                    </a>
                    @endcan
                </div>
                @endcanany

                @canany(['Create-Admin', 'Read-Admins', 'Read-Merchants', 'Create-Role', 'Read-Roles', 'Read-Roles', 'Read-Permissions'])
                <div class="sidebar-section">
                    <div class="sidebar-section-title">الصلاحيات</div>
                    @can(['Create-Admin'])
                    <a href="{{ route('admins.create') }}" 
                        class="sidebar-link {{ request()->routeIs('admins.create') ? 'active' : '' }}">
                        <i class="fas fa-user-shield"></i>
                        <span>انشاء مدير</span>
                    </a>
                    @endcan

                    @can(['Read-Admins'])
                    <a href="{{ route('admins.index') }}" 
                        class="sidebar-link {{ request()->routeIs('admins.index') ? 'active' : '' }}">
                        <i class="fas fa-users-cog"></i>
                        <span>عرض حسابات الادمن</span>
                    </a>
                    @endcan

                    @can(['Read-Merchants'])
                    <a href="{{ route('merchants.index') }}" 
                        class="sidebar-link {{ request()->routeIs('merchants.index') ? 'active' : '' }}">
                        <i class="fas fa-user-tie"></i>
                        <span>عرض حسابات التجار</span>
                    </a>
                    @endcan

                    @can(['Create-Role'])
                    <a href="{{ route('roles.create') }}" 
                        class="sidebar-link {{ request()->routeIs('roles.create') ? 'active' : '' }}">
                        <i class="fas fa-key"></i>
                        <span>انشاء دور</span>
                    </a>
                    @endcan

                    @can(['Read-Roles'])
                    <a href="{{ route('roles.index') }}" 
                        class="sidebar-link {{ request()->routeIs('roles.index') ? 'active' : '' }}">
                        <i class="fas fa-user-tag"></i>
                        <span>عرض دور</span>
                    </a>
                    @endcan

                    @can(['Read-Permissions'])
                    <a href="{{ route('permissions.index') }}" 
                        class="sidebar-link {{ request()->routeIs('permissions.index') ? 'active' : '' }}">
                        <i class="fas fa-shield-alt"></i>
                        <span>عرض الصلاحيات</span>
                    </a>
                    @endcan
                </div>
                @endcanany

                <!-- تم نقل إعدادات الملف الشخصي إلى القائمة العلوية -->
            </div>
        </aside>

        <!-- Mobile Menu Overlay -->
    <div id="overlay" class="fixed inset-0 bg-black opacity-0 z-40 hidden lg:hidden"></div>

        <!-- Content Area -->
        <div class="content-wrapper w-full">
            <!-- Fixed Profile Navigation Bar -->
            <div class="sticky-nav-wrapper">
                <nav class="navbar navbar-expand-lg fixed-top bg-white shadow mb-4">
                    <div class="container-fluid px-4 py-2 d-flex align-items-center justify-content-between">
                        <!-- Logo & Title + Mobile Menu Btn -->
                        <div class="d-flex align-items-center gap-2">
                            <button id="mobileMenuBtn" class="d-inline-flex d-lg-none me-2">
                                <i class="fas fa-bars"></i>
                            </button>
                            <div class="navbar-brand d-flex align-items-center mb-0">
                                <i class="fas fa-tachometer-alt text-primary-color text-xl ml-2"></i>
                                <h2 class="text-lg font-bold mb-0">لوحة التحكم</h2>
                            </div>
                        </div>
                        <!-- User Info & Options -->
                        <div class="d-flex align-items-center user-menu">
                            <!-- Unified User Profile Dropdown -->
                            <div class="dropdown ms-2">
                                <button class="btn user-profile-btn dropdown-toggle" type="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <div class="d-flex align-items-center">
                                        <span class="user-avatar me-2">
                                            <span>{{ substr(auth('admin')->check() ? auth('admin')->user()->name : auth('merchant')->user()->name, 0, 1) }}</span>
                                        </span>
                                        <span class="font-semibold me-1 d-none d-sm-inline-block">
                                            {{ auth('admin')->check() ? auth('admin')->user()->name : auth('merchant')->user()->name }}
                                        </span>
                                    </div>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end profile-dropdown shadow-sm" aria-labelledby="profileDropdown">
                                    <style>
                                    @media (max-width: 992px) {
                                        .dropdown-menu.profile-dropdown {
                                            top: 60px !important;
                                            left: 0 !important;
                                            right: 0 !important;
                                            border-radius: 0 0 12px 12px !important;
                                            margin-top: 0.5rem !important;
                                        }
                                    }
                                    @media (min-width: 993px) {
                                        .dropdown-menu.profile-dropdown {
                                            margin-top: 12px !important;
                                            right: 8px !important;
                                        }
                                    }
                                    </style>
                                    <li class="dropdown-header">
                                        <div class="d-flex align-items-center">
                                            <div class="dropdown-user-avatar me-2">
                                                <span>{{ substr(auth('admin')->check() ? auth('admin')->user()->name : auth('merchant')->user()->name, 0, 1) }}</span>
                                            </div>
                                            <div>
                                                <h6 class="mb-0">{{ auth('admin')->check() ? auth('admin')->user()->name : auth('merchant')->user()->name }}</h6>
                                                <small class="text-muted">{{ auth('admin')->check() ? 'مشرف' : 'تاجر' }}</small>
                                            </div>
                                        </div>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('profile') }}">
                                            <i class="fas fa-user-circle ml-1"></i>
                                            الملف الشخصي
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('edit-password') }}">
                                            <i class="fas fa-lock ml-1"></i>
                                            تغيير كلمة المرور
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <a class="dropdown-item text-danger" href="{{ route('logout') }}">
                                            <i class="fas fa-sign-out-alt ml-1"></i>
                                            تسجيل الخروج
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
            @yield('content')
        </div>
    </div>
@stack('styles')
    <script src="https://cdn.jsdelivr.net/npm/toastr@2.1.4/build/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.24/dist/sweetalert2.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize custom file input
            bsCustomFileInput.init();
            
            // Mobile menu toggle with overlay
            const mobileMenuBtn = document.getElementById('mobileMenuBtn');
            const sidebar = document.querySelector('.sidebar');
            const overlay = document.getElementById('overlay');
            const body = document.querySelector('body');
            
            if (mobileMenuBtn) {
                mobileMenuBtn.addEventListener('click', () => {
                    sidebar.classList.toggle('show');
                    overlay.classList.toggle('hidden');
                    overlay.classList.toggle('show');
                    body.classList.toggle('menu-open');
                });
            }
            
            if (overlay) {
                overlay.addEventListener('click', () => {
                    sidebar.classList.remove('show');
                    overlay.classList.add('hidden');
                    overlay.classList.remove('show');
                    body.classList.remove('menu-open');
                });
            }
            
            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', function(event) {
                if (window.innerWidth < 992) {
                    const isClickInside = sidebar.contains(event.target) || mobileMenuBtn.contains(event.target);
                    
                    if (!isClickInside && sidebar.classList.contains('show')) {
                        sidebar.classList.remove('show');
                        overlay.classList.add('hidden');
                        overlay.classList.remove('show');
                        body.classList.remove('menu-open');
                    }
                }
            });
            
            // Detect orientation change and fix any layout issues
            window.addEventListener('orientationchange', function() {
                setTimeout(function() {
                    if (window.innerWidth >= 992 && sidebar.classList.contains('show')) {
                        sidebar.classList.remove('show');
                        overlay.classList.add('hidden');
                        overlay.classList.remove('show');
                        body.classList.remove('menu-open');
                    }
                }, 200);
            });
            
            // Handle window resize to reset mobile menu state
            window.addEventListener('resize', function() {
                if (window.innerWidth >= 992 && sidebar.classList.contains('show')) {
                    sidebar.classList.remove('show');
                    overlay.classList.add('hidden');
                    body.classList.remove('overflow-hidden');
                }
            });
            
            // Add active class to sidebar links based on current URL
            const currentPath = window.location.pathname;
            const sidebarLinks = document.querySelectorAll('.sidebar-link');
            
            sidebarLinks.forEach(link => {
                if (link.getAttribute('href') && link.getAttribute('href') !== '#' && 
                    currentPath.includes(link.getAttribute('href').split('?')[0])) {
                    link.classList.add('active');
                }
            });
            
            // Enhanced navbar effect on scroll
            const navbar = document.querySelector('.navbar');
            const navbarBrand = document.querySelector('.navbar-brand');
            const scrollThreshold = 10;
            
            if (navbar && navbarBrand) {
                window.addEventListener('scroll', function() {
                    if (window.scrollY > scrollThreshold) {
                        navbar.classList.add('shadow-lg');
                        navbar.classList.add('scrolled');
                        navbarBrand.classList.add('scrolled');
                    } else {
                        navbar.classList.remove('shadow-lg');
                        navbar.classList.remove('scrolled');
                        navbarBrand.classList.remove('scrolled');
                    }
                });
            }
            
            // Initialize all dropdowns
            var dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'));
            var dropdownList = dropdownElementList.map(function (dropdownToggleEl) {
                return new bootstrap.Dropdown(dropdownToggleEl);
            });
        });

        // Map initialization
        let map, marker;

        function initMap() {
            if (!document.getElementById("map")) return;
            
            map = new google.maps.Map(document.getElementById("map"), {
                center: {
                    lat: 31.5,
                    lng: 34.47
                },
                zoom: 13,
                styles: [
                    {
                        "featureType": "administrative",
                        "elementType": "geometry",
                        "stylers": [{"visibility": "on"}]
                    },
                    {
                        "featureType": "administrative.country",
                        "elementType": "labels.text.fill",
                        "stylers": [{"color": "#0047b3"}]
                    },
                    {
                        "featureType": "water",
                        "elementType": "geometry",
                        "stylers": [{"color": "#e9f2fd"}]
                    }
                ]
            });
            
            const input = document.getElementById("location-input");
            if (!input) return;
            
            const searchBox = new google.maps.places.SearchBox(input);
            map.controls[google.maps.ControlPosition.TOP_CENTER].push(input);
            
            searchBox.addListener("places_changed", () => {
                const places = searchBox.getPlaces();
                if (places.length === 0) return;
                const place = places[0];
                map.setCenter(place.geometry.location);
                if (marker) marker.setMap(null);
                marker = new google.maps.Marker({
                    map,
                    position: place.geometry.location,
                    animation: google.maps.Animation.DROP
                });
                
                // Update form fields with location data
                if (document.getElementById('lat')) {
                    document.getElementById('lat').value = place.geometry.location.lat();
                }
                if (document.getElementById('lng')) {
                    document.getElementById('lng').value = place.geometry.location.lng();
                }
            });
        }
        window.initMap = initMap;

        // Enhanced notification system
        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        const status = @json(session('status'));
        const icon = @json(session('icon'));
        const message = @json(session('message'));

        if (status) {
            Toast.fire({
                icon: icon || 'success',
                title: message
            });
        }

        @if ($errors->any())
            let errorMessages = {!! json_encode($errors->all()) !!};
            Toast.fire({
                icon: 'error',
                title: 'هناك أخطاء في البيانات المدخلة',
                html: errorMessages.join('<br>'),
                timer: 5000
            });
        @endif
        
        // Confirm delete function
        function confirmDestroy(url, button) {
            Swal.fire({
                title: 'هل أنت متأكد؟',
                text: "لن تتمكن من التراجع عن هذا الإجراء!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#0047b3',
                cancelButtonColor: '#ef4444',
                confirmButtonText: 'نعم، قم بالحذف!',
                cancelButtonText: 'إلغاء',
                reverseButtons: true,
                focusCancel: true
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            });
        }
    </script>
    
    @yield('scripts')
</body>

</html>