<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1"><meta name="csrf-token" content="{{ csrf_token() }}"><title>@yield('title','Elegance Salon') · {{ $settings['salon_name'] ?? 'Elegance Salon' }}</title><link rel="stylesheet" href="{{ asset('css/elegance.css') }}"></head>
<body class="app-shell">
<div class="ambient ambient-a"></div><div class="ambient ambient-b"></div>
@if(auth()->check())
<div class="sidebar" id="sidebar">
 <a class="brand" href="{{ route('dashboard') }}"><span class="brand-mark">E</span><span><b>Elegance</b><small>Salon OS</small></span></a>
 <nav>
  <a class="nav-link {{ request()->routeIs('dashboard')?'active':'' }}" href="{{ route('dashboard') }}"><span>⌂</span> Dashboard</a>
  <a class="nav-link {{ request()->routeIs('appointments.*')?'active':'' }}" href="{{ route('appointments.index') }}"><span>◫</span> Appointments</a>
  @if(in_array(auth()->user()->role,['admin','receptionist']))<a class="nav-link {{ request()->routeIs('clients.*')?'active':'' }}" href="{{ route('clients.index') }}"><span>♙</span> Clients</a>@endif
  @if(in_array(auth()->user()->role,['admin','receptionist']))<a class="nav-link {{ request()->routeIs('payments.*')?'active':'' }}" href="{{ route('payments.index') }}"><span>◇</span> Payments</a>@endif
  @if(auth()->user()->role==='admin')
   <div class="nav-label">MANAGEMENT</div>
   <a class="nav-link {{ request()->routeIs('services.*')?'active':'' }}" href="{{ route('services.index') }}"><span>✦</span> Services</a>
   <a class="nav-link {{ request()->routeIs('staff.*')?'active':'' }}" href="{{ route('staff.index') }}"><span>♛</span> Staff</a>
   <a class="nav-link {{ request()->routeIs('inventory.*')?'active':'' }}" href="{{ route('inventory.index') }}"><span>▣</span> Inventory</a>
   <a class="nav-link {{ request()->routeIs('suppliers.*')?'active':'' }}" href="{{ route('suppliers.index') }}"><span>▱</span> Suppliers</a>
   <a class="nav-link {{ request()->routeIs('reports.*')?'active':'' }}" href="{{ route('reports.index') }}"><span>↗</span> Reports</a>
   <div class="nav-label">ADMIN</div>
   <a class="nav-link {{ request()->routeIs('admin.users')?'active':'' }}" href="{{ route('admin.users') }}"><span>⚙</span> Users</a>
   <a class="nav-link {{ request()->routeIs('admin.feedback')?'active':'' }}" href="{{ route('admin.feedback') }}"><span>♡</span> Feedback</a>
   <a class="nav-link {{ request()->routeIs('admin.settings')?'active':'' }}" href="{{ route('admin.settings') }}"><span>⋯</span> Settings</a>
  @endif
 </nav>
 <div class="sidebar-profile"><div class="avatar">{{ strtoupper(substr(auth()->user()->name,0,1)) }}</div><div><b>{{ auth()->user()->name }}</b><small>{{ ucfirst(auth()->user()->role) }}</small></div></div>
</div>
<main class="main-area">
 <header class="topbar"><button class="icon-btn mobile-only" onclick="document.getElementById('sidebar').classList.toggle('open')">☰</button><div><span class="eyebrow">ELEGANCE SALON</span><h1>@yield('page-title','Dashboard')</h1></div><div class="top-actions"><a class="icon-btn notification-btn" href="{{ route('notifications.index') }}">♢ @if($unreadNotifications)<span>{{ $unreadNotifications }}</span>@endif</a><form method="POST" action="{{ route('logout') }}">@csrf<button class="btn btn-ghost" type="submit">Sign out</button></form></div></header>
 <section class="content-wrap">
  @if(session('success'))<div class="alert success">✓ {{ session('success') }}</div>@endif @if(session('error'))<div class="alert error">! {{ session('error') }}</div>@endif
  @if($errors->any())<div class="alert error"><b>Please fix the following:</b><ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>@endif
  @yield('content')
 </section>
</main>
@else @yield('guest') @endif
<script>document.addEventListener('click',e=>{const b=e.target.closest('[data-modal]');if(b){document.getElementById(b.dataset.modal)?.classList.add('show')}if(e.target.matches('.modal,.modal-close'))e.target.closest('.modal')?.classList.remove('show')});</script>
@stack('scripts')</body></html>
