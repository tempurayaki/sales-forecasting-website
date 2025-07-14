<style>
  .sidebar {
    background: linear-gradient(180deg, #ffffff 0%, #f8f9fa 100%);
    box-shadow: 2px 0 15px rgba(0, 0, 0, 0.08);
    backdrop-filter: blur(10px);
    transition: all 0.3s ease;
  }
  
  .sidebar-header {
    padding: 1.5rem 1.25rem;
    background: rgba(255, 255, 255, 0.95);
    border-bottom: 1px solid rgba(0, 0, 0, 0.08);
  }
  
  .sidebar-brand {
    font-size: 1.1rem;
    font-weight: 700;
    letter-spacing: 0.5px;
    color: #2c3e50;
    text-align: center;
    margin: 0;
    position: relative;
  }
  
  .sidebar-brand::after {
    content: '';
    position: absolute;
    bottom: -8px;
    left: 50%;
    transform: translateX(-50%);
    width: 40px;
    height: 2px;
    background: linear-gradient(90deg, #6f42c1, #5a32a3);
    border-radius: 1px;
  }
  
  .sidebar-nav {
    padding: 1rem 0;
    list-style: none;
    margin: 0;
  }
  
  .nav-title {
    padding: 1rem 1.25rem 0.5rem;
    font-size: 0.75rem;
    font-weight: 600;
    color: #6c757d;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin: 0;
  }
  
  .nav-item {
    margin: 0.25rem 0.75rem;
    animation: slideInLeft 0.3s ease;
    animation-fill-mode: both;
  }
  
  .nav-item:nth-child(1) { animation-delay: 0.1s; }
  .nav-item:nth-child(2) { animation-delay: 0.2s; }
  .nav-item:nth-child(3) { animation-delay: 0.3s; }
  .nav-item:nth-child(4) { animation-delay: 0.4s; }
  .nav-item:nth-child(5) { animation-delay: 0.5s; }
  
  .nav-link {
    display: flex;
    align-items: center;
    padding: 0.75rem 1rem;
    color: #495057;
    text-decoration: none;
    border-radius: 8px;
    transition: all 0.2s ease;
    font-weight: 500;
    position: relative;
    overflow: hidden;
  }
  
  .nav-link::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(111, 66, 193, 0.1), transparent);
    transition: left 0.5s ease;
  }
  
  .nav-link:hover::before {
    left: 100%;
  }
  
  .nav-link:hover {
    background: rgba(111, 66, 193, 0.06);
    color: #6f42c1;
    transform: translateX(4px);
    box-shadow: 0 2px 8px rgba(111, 66, 193, 0.15);
  }
  
  .nav-link.active {
    background: linear-gradient(135deg, #6f42c1 0%, #5a32a3 100%);
    color: white;
    box-shadow: 0 4px 12px rgba(111, 66, 193, 0.3);
  }
  
  .nav-link.active:hover {
    transform: translateX(2px);
    box-shadow: 0 6px 16px rgba(111, 66, 193, 0.4);
    color: white;
  }
  
  .nav-link.active::after {
    content: '';
    position: absolute;
    right: 8px;
    top: 50%;
    transform: translateY(-50%);
    width: 4px;
    height: 4px;
    background: rgba(255, 255, 255, 0.8);
    border-radius: 50%;
    box-shadow: 0 0 6px rgba(255, 255, 255, 0.6);
  }
  
  .c-sidebar-nav-icon {
    width: 20px;
    height: 20px;
    margin-right: 0.75rem;
    transition: transform 0.2s ease;
  }
  
  .nav-link:hover .c-sidebar-nav-icon {
    transform: scale(1.1);
  }
  
  .sidebar-footer {
    margin-top: auto;
    padding: 1.5rem 1.25rem;
    border-top: 1px solid rgba(0, 0, 0, 0.08);
    background: rgba(255, 255, 255, 0.8);
  }
  
  .btn-logout {
    background: white;
    border: none;
    color: black;
    padding: 0.75rem 1rem;
    border-radius: 8px;
    font-weight: 500;
    transition: all 0.2s ease;
    box-shadow: 0 2px 8px rgba(220, 53, 69, 0.2);
    width: 100%;
  }
  
  .btn-logout:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
    background: linear-gradient(135deg, #c82333 0%, #bd2130 100%);
    color: white;
  }
  
  @keyframes slideInLeft {
    from {
      opacity: 0;
      transform: translateX(-20px);
    }
    to {
      opacity: 1;
      transform: translateX(0);
    }
  }
</style>

<div class="sidebar border-end position-fixed top-0 start-0 h-100 overflow-auto d-flex flex-column" style="width: 280px;">
  <div class="sidebar-header border-bottom">
    <div class="sidebar-brand fw-bold">SALES FORECASTING.</div>
  </div>
  
  <ul class="sidebar-nav flex-grow-1">
    {{-- Dashboard - Accessible by both admin and user --}}
    <li class="nav-item">
      <a class="nav-link d-flex align-items-center text-dark gap-2 {{ Request::routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
        <svg class="c-sidebar-nav-icon" width="20" height="20" fill="currentColor">
          <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-speedometer') }}"></use>
        </svg>
        Dashboard
      </a>
    </li>      
    
    <li class="nav-title">Menu</li>
    
    {{-- Peramalan Penjualan - Accessible by both admin and user --}}
    <li class="nav-item">
      <a class="nav-link d-flex align-items-center text-dark gap-2 {{ Request::routeIs('forecasting') ? 'active' : '' }}" href="{{ route('forecasting') }}">
        <svg class="c-sidebar-nav-icon" width="20" height="20" fill="currentColor">
          <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-chart-line') }}"></use>
        </svg>
        Peramalan Penjualan
      </a>
    </li>  

    {{-- Admin Section - Only for admin --}}
    @can('admin-access')
    <li class="nav-title">Admin</li>

    <li class="nav-item">
      <a class="nav-link d-flex align-items-center text-dark gap-2 {{ Request::routeIs('sales') ? 'active' : '' }}" href="{{ route('sales') }}">
        <svg class="c-sidebar-nav-icon" width="20" height="20" fill="currentColor">
          <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-view-column') }}"></use>
        </svg>
        Data Penjualan
      </a>
    </li> 
    
    <li class="nav-item">
      <a class="nav-link d-flex align-items-center text-dark gap-2 {{ Request::routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
        <svg class="c-sidebar-nav-icon" width="20" height="20" fill="currentColor">
          <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-user') }}"></use>
        </svg>
        Kelola User
      </a>
    </li>
    @endcan
  </ul>

  
  
  <div class="sidebar-footer border-top d-flex justify-content-center align-items-center p-3">
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="m-0 w-100">
      @csrf
      <button type="submit" class="btn btn-logout d-flex align-items-center justify-content-center gap-2" title="Logout">
        <svg class="c-sidebar-nav-icon" width="20" height="20" fill="currentColor">
          <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-account-logout') }}"></use>
        </svg>
        <span>Logout</span>
      </button>
    </form>
  </div>
</div>