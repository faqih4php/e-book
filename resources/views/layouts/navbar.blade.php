
      <!-- Header -->
      <header id="page-header">
        <!-- Header Content -->
        <div class="content-header">
          <!-- Left Section -->
          <div class="d-flex align-items-center">
            <!-- Toggle Sidebar -->
            <!-- Layout API, functionality initialized in Template._uiApiLayout()-->
            <button type="button" class="btn btn-sm btn-alt-secondary me-2 d-lg-none" data-toggle="layout" data-action="sidebar_toggle">
              <i class="fa fa-fw fa-bars"></i>
            </button>
            <!-- END Toggle Sidebar -->

            <!-- Open Search Section (visible on smaller screens) -->
            <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
            <button type="button" class="btn btn-sm btn-alt-secondary d-md-none" data-toggle="layout" data-action="header_search_on">
              <i class="fa fa-fw fa-search"></i>
            </button>
            <!-- END Open Search Section -->

            <!-- Search Form (visible on larger screens) -->
            <form class="d-none d-md-inline-block" action="{{ route('books.search') }}" method="GET">
              <div class="input-group input-group-sm {{ request()->routeIs('dashboard.admin') || request()->routeIs('dashboard.user') ? '' : 'd-none' }}">
                <input type="text" class="form-control form-control-alt" placeholder="Search books.." id="query" name="query">
                <button type="submit" class="input-group-text border-0">
                  <i class="fa fa-fw fa-search"></i>
                </button>
              </div>
            </form>
            <!-- END Search Form -->
          </div>
          <!-- END Left Section -->

          <!-- Right Section -->
          <div class="d-flex align-items-center">
            <!-- User Dropdown -->
            <div class="dropdown d-inline-block ms-2">
              <button type="button" class="btn btn-sm btn-alt-secondary d-flex align-items-center" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img class="rounded-circle" src="{{ asset('/media/avatars/avatar10.jpg') }}" alt="Header Avatar" style="width: 21px;">
                <span class="d-none d-sm-inline-block ms-2">{{ auth()->user()->name }}</span>
                <i class="fa fa-fw fa-angle-down d-none d-sm-inline-block opacity-50 ms-1 mt-1"></i>
              </button>
              <div class="dropdown-menu dropdown-menu-md dropdown-menu-end p-0 border-0" aria-labelledby="page-header-user-dropdown">
                <div class="p-3 text-center bg-body-light border-bottom rounded-top">
                  <img class="img-avatar img-avatar48 img-avatar-thumb" src="{{ asset('/media/avatars/avatar10.jpg') }}" alt="">
                  <p class="mt-2 mb-0 fw-medium">{{ auth()->user()->name }}</p>
                  <p class="mb-0 text-muted fs-sm fw-medium">{{ ucfirst(auth()->user()->role) }}</p>
                </div>
                <div class="p-2">
                  <a class="dropdown-item d-flex align-items-center justify-content-between" href="be_pages_generic_inbox.html">
                    <span class="fs-sm fw-medium">Inbox</span>
                    <span class="badge rounded-pill bg-primary ms-2">3</span>
                  </a>
                  <a class="dropdown-item d-flex align-items-center justify-content-between" href="be_pages_generic_profile.html">
                    <span class="fs-sm fw-medium">Profile</span>
                    <span class="badge rounded-pill bg-primary ms-2">1</span>
                  </a>
                  <a class="dropdown-item d-flex align-items-center justify-content-between" href="javascript:void(0)">
                    <span class="fs-sm fw-medium">Settings</span>
                  </a>
                </div>
                <div role="separator" class="dropdown-divider m-0"></div>
                <div class="p-2">
                  <a class="dropdown-item d-flex align-items-center justify-content-between" href="javascript:void(0)">
                    <span class="fs-sm fw-medium">Lock Account</span>
                  </a>
                  <form id="logout-form" action="{{ route('auths.logout') }}" method="POST" class="d-none">
                      @csrf
                  </form>
                  <a class="dropdown-item d-flex align-items-center justify-content-between" href="javascript:void(0)" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <span class="fs-sm fw-medium">Log Out</span>
                  </a>
                </div>
              </div>
            </div>
            <!-- END User Dropdown -->

            <!-- Notifications Dropdown -->
            <div class="dropdown d-inline-block ms-2">
              <button type="button" class="btn btn-sm btn-alt-secondary" id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-fw fa-bell"></i>
                @if(auth()->user()->unreadNotifications->count() > 0)
                <span class="text-primary">•</span>
                @endif
              </button>
              <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0 border-0 fs-sm" aria-labelledby="page-header-notifications-dropdown">
                <div class="p-2 bg-body-light border-bottom rounded-top d-flex justify-content-between align-items-center">
                  <h5 class="dropdown-header text-uppercase mb-0">Notifications</h5>
                  @if(auth()->user()->notifications->count() > 0)
                      <form action="{{ route('notifications.destroyAll') }}" method="POST" class="m-0">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-sm btn-alt-danger py-0 px-2" title="Clear All">
                              <i class="fa fa-fw fa-trash-alt"></i> Clear All
                          </button>
                      </form>
                  @endif
                </div>
                <ul class="nav-items mb-0" style="max-height: 300px; overflow-y: auto;">
                  @forelse(auth()->user()->notifications as $notification)
                  <li>
                    <div class="text-dark d-flex py-2 px-2 {{ $notification->unread() ? 'bg-body-light' : '' }}">
                      <div class="flex-shrink-0 me-2 ms-2 mt-1">
                        <i class="fa fa-fw {{ $notification->data['icon'] ?? 'fa-bell' }} text-{{ $notification->data['color'] ?? 'primary' }}"></i>
                      </div>
                      <div class="flex-grow-1 pe-2">
                        <div class="fw-semibold">{{ $notification->data['message'] ?? 'New notification' }}</div>
                        <span class="fw-medium text-muted fs-xs">{{ $notification->created_at->diffForHumans() }}</span>
                      </div>
                      <div class="flex-shrink-0 d-flex gap-1 align-items-start">
                          <a href="{{ route('notifications.read', $notification->id) }}" class="btn btn-sm btn-alt-secondary py-1 px-2" title="View">
                              <i class="fa fa-fw fa-eye"></i>
                          </a>
                          <form action="{{ route('notifications.destroy', $notification->id) }}" method="POST" class="m-0">
                              @csrf
                              @method('DELETE')
                              <button type="submit" class="btn btn-sm btn-alt-danger py-1 px-2" title="Delete">
                                  <i class="fa fa-fw fa-trash"></i>
                              </button>
                          </form>
                      </div>
                    </div>
                  </li>
                  @empty
                  <li>
                    <div class="text-center py-4">
                        <i class="fa fa-fw fa-bell-slash text-muted fs-1 mb-2"></i>
                        <div class="fw-medium text-muted">No notifications</div>
                    </div>
                  </li>
                  @endforelse
                </ul>
                <div class="p-2 border-top text-center bg-body-light">
                  <span class="d-inline-block fw-medium text-muted fs-xs">
                     {{ auth()->user()->unreadNotifications->count() }} unread
                  </span>
                </div>
              </div>
            </div>
            <!-- END Notifications Dropdown -->

            <!-- Toggle Side Overlay -->
            <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
            <button type="button" class="btn btn-sm btn-alt-secondary ms-2" data-toggle="layout" data-action="side_overlay_toggle">
              <i class="fa fa-fw fa-list-ul fa-flip-horizontal"></i>
            </button>
            <!-- END Toggle Side Overlay -->
          </div>
          <!-- END Right Section -->
        </div>
        <!-- END Header Content -->

        <!-- Header Search -->
        <div id="page-header-search" class="overlay-header bg-body-extra-light">
          <div class="content-header">
            <form class="w-100" action="be_pages_generic_search.html" method="POST">
              <div class="input-group">
                <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                <button type="button" class="btn btn-alt-danger" data-toggle="layout" data-action="header_search_off">
                  <i class="fa fa-fw fa-times-circle"></i>
                </button>
                <input type="text" class="form-control" placeholder="Search or hit ESC.." id="page-header-search-input" name="page-header-search-input">
              </div>
            </form>
          </div>
        </div>
        <!-- END Header Search -->

        <!-- Header Loader -->
        <!-- Please check out the Loaders page under Components category to see examples of showing/hiding it -->
        <div id="page-header-loader" class="overlay-header bg-body-extra-light">
          <div class="content-header">
            <div class="w-100 text-center">
              <i class="fa fa-fw fa-circle-notch fa-spin"></i>
            </div>
          </div>
        </div>
        <!-- END Header Loader -->
      </header>
      <!-- END Header -->
