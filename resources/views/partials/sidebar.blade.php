<div class="sidebar border-end position-fixed top-0 start-0 h-100 overflow-auto" style="width: 250px;">
    <div class="sidebar-header border-bottom">
      <div class="sidebar-brand fw-bold">SALES FORECASTING</div>
    </div>
    <ul class="sidebar-nav">
      <li class="nav-item">
        <a class="nav-link d-flex align-items-center text-dark gap-2" href="{{ route('home') }}">
          <svg class="c-sidebar-nav-icon" width="20" height="20" fill="currentColor">
            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-speedometer') }}"></use>
          </svg>
          Dashboard
        </a>
      </li>      
      <li class="nav-title">Menu</li>
      <li class="nav-item">
        <a class="nav-link d-flex align-items-center text-dark gap-2" href="{{ route('sales') }}">
          <svg class="c-sidebar-nav-icon" width="20" height="20" fill="currentColor">
            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-view-column') }}"></use>
          </svg>
          Data Penjualan
        </a>
      </li>  
      <li class="nav-item">
        <a class="nav-link d-flex align-items-center text-dark gap-2" href="{{ route('forecasting') }}">
          <svg class="c-sidebar-nav-icon" width="20" height="20" fill="currentColor">
            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-chart-line') }}"></use>
          </svg>
          Forecasting
        </a>
      </li>  
    </ul>
    <div class="sidebar-footer border-top d-flex justify-content-center align-items-center p-3">
      <form id="logout-form" action="{{ route('logout') }}" method="POST" class="m-0">
        @csrf
        <button type="submit" class="btn btn-light d-flex align-items-center gap-2" title="Logout">
          <svg class="c-sidebar-nav-icon" width="20" height="20" fill="currentColor">
            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-account-logout') }}"></use>
          </svg>
          <span class="text-dark">Logout</span>
        </button>
      </form>
    </div>
    
  </div>