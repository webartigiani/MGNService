<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <li class="nav-item">
        <router-link to="/dashboard" class="nav-link">
          <i class="nav-icon fas fa-tachometer-alt white"></i>
          <p>
            Dashboard
          </p>
        </router-link>
      </li>

      <li class="nav-item">
        <router-link to="/workers" class="nav-link">
          <i class="nav-icon fas fa-users white"></i>
          <p>
            Dipendenti
          </p>
        </router-link>
      </li>

      @can('isAdmin')

      @endcan

      @can('isAdmin')
      <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
          <i class="nav-icon fas fa-cog white"></i>
          <p>
            Impostazioni
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">

          <li class="nav-item">
            <router-link to="/product/category" class="nav-link">
              <i class="nav-icon fas fa-car white"></i>
              <p>
                Veicoli
              </p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link to="/product/tag" class="nav-link">
              <i class="nav-icon fas fa-mobile-alt white"></i>
              <p>
                Dispositivi
              </p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link to="/users" class="nav-link">
                <i class="fa fa-users nav-icon white"></i>
                <p>Staff</p>
            </router-link>
            </li>
        </ul>
      </li>
      @endcan

      <li class="nav-item">
        <a href="#" class="nav-link" onclick="event.preventDefault();
          document.getElementById('logout-form').submit();">
          <i class="nav-icon fas fa-power-off white"></i>
          <p>
            {{ __('Logout') }}
          </p>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
          @csrf
        </form>
      </li>
    </ul>
  </nav>
