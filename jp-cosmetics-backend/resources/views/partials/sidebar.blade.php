<!-- Sidebar -->
<div id="sidebar"
     class="sidebar p-4 text-slate-100 space-y-1 border-r border-slate-700/60 shadow-xl" style="background-color: rgb(58, 3, 67)">

  <!-- Header -->
  <div class="flex items-center justify-between pb-3 border-b border-slate-700/60">
    <div class="flex items-center gap-3">
      <div class="h-9 w-9 rounded-xl bg-indigo-500/20 ring-1 ring-indigo-400/30 grid place-content-center">
        <span class="text-indigo-300 text-sm font-bold">AP</span>
      </div>
      <h1 class="text-xl font-extrabold tracking-tight">Admin Panel</h1>
    </div>
    <button id="closeSidebar"
            class="md:hidden rounded-lg p-2 hover:bg-slate-700/60 ring-1 ring-transparent hover:ring-slate-600 transition"
            aria-label="Close sidebar">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5">
        <path d="M12 13V20L4 12L12 4V11H20V13H12Z"></path>
      </svg>
    </button>
  </div>

  <!-- Dashboard -->
  <a href="{{ route('user.dashboard') }}"
     class="menu-link block rounded-lg px-3 py-2.5 font-medium text-sm
            hover:bg-slate-700/50 hover:text-white
            ring-1 ring-transparent hover:ring-slate-600 transition
            {{ request()->routeIs('user.dashboard') ? 'bg-slate-700/60 text-white ring-slate-600' : 'text-slate-200' }}">
    <div class="flex items-center gap-3">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5 opacity-90">
        <path d="M3 12C3 12.5523 3.44772 13 4 13H10C10.5523 13 11 12.5523 11 12V4C11 3.44772 10.5523 3 10 3H4C3.44772 3 3 3.44772 3 4V12ZM3 20C3 20.5523 3.44772 21 4 21H10C10.5523 21 11 20.5523 11 20V16C11 15.4477 10.5523 15 10 15H4C3.44772 15 3 15.4477 3 16V20ZM13 20C13 20.5523 13.4477 21 14 21H20C20.5523 21 21 20.5523 21 20V12C21 11.4477 20.5523 11 20 11H14C13.4477 11 13 11.4477 13 12V20ZM14 3C13.4477 3 13 3.44772 13 4V8C13 8.55228 13.4477 9 14 9H20C20.5523 9 21 8.55228 21 8V4C21 3.44772 20.5523 3 20 3H14Z"></path>
      </svg>
      <span>Dashboard</span>
    </div>
  </a>

    <!-- Category -->
    <a href="{{ route('category.list') }}"
    class="menu-link block rounded-lg px-3 py-2.5 font-medium text-sm
           hover:bg-slate-700/50 hover:text-white
           ring-1 ring-transparent hover:ring-slate-600 transition
           {{ request()->routeIs('category.list') ? 'bg-slate-700/60 text-white ring-slate-600' : 'text-slate-200' }}">
    <div class="flex items-center gap-3">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5 opacity-90"><path d="M15.5 5C13.567 5 12 6.567 12 8.5C12 10.433 13.567 12 15.5 12C17.433 12 19 10.433 19 8.5C19 6.567 17.433 5 15.5 5ZM10 8.5C10 5.46243 12.4624 3 15.5 3C18.5376 3 21 5.46243 21 8.5C21 9.6575 20.6424 10.7315 20.0317 11.6175L22.7071 14.2929L21.2929 15.7071L18.6175 13.0317C17.7315 13.6424 16.6575 14 15.5 14C12.4624 14 10 11.5376 10 8.5ZM3 4H8V6H3V4ZM3 11H8V13H3V11ZM21 18V20H3V18H21Z"></path></svg>
      <span>Category</span>
    </div>
  </a>

  <!--Brand-->
  <a href="{{ route('brand.list') }}"
    class="menu-link block rounded-lg px-3 py-2.5 font-medium text-sm
          hover:bg-slate-700/50 hover:text-white
          ring-1 ring-transparent hover:ring-slate-600 transition
          {{ request()->routeIs('brand.list') ? 'bg-slate-700/60 text-white ring-slate-600' : 'text-slate-200' }}">
    <div class="flex items-center gap-3">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5 opacity-90"><path d="M10 6V8H6V18H4V8H0V6H10ZM12 6H14.5L17.4999 11.196L20.5 6H23V18H21V9.133L17.4999 15.196L14 9.135V18H12V6Z"></path></svg>
      <span>Brand</span>
    </div>
  </a>

    <!--Customer-->
    <a href="{{ route('customer.list') }}"
    class="menu-link block rounded-lg px-3 py-2.5 font-medium text-sm
          hover:bg-slate-700/50 hover:text-white
          ring-1 ring-transparent hover:ring-slate-600 transition
          {{ request()->routeIs('customer.list') ? 'bg-slate-700/60 text-white ring-slate-600' : 'text-slate-200' }}">
    <div class="flex items-center gap-3">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5 opacity-90"><path d="M12 10C14.2091 10 16 8.20914 16 6 16 3.79086 14.2091 2 12 2 9.79086 2 8 3.79086 8 6 8 8.20914 9.79086 10 12 10ZM5.5 13C6.88071 13 8 11.8807 8 10.5 8 9.11929 6.88071 8 5.5 8 4.11929 8 3 9.11929 3 10.5 3 11.8807 4.11929 13 5.5 13ZM21 10.5C21 11.8807 19.8807 13 18.5 13 17.1193 13 16 11.8807 16 10.5 16 9.11929 17.1193 8 18.5 8 19.8807 8 21 9.11929 21 10.5ZM12 11C14.7614 11 17 13.2386 17 16V22H7V16C7 13.2386 9.23858 11 12 11ZM5 15.9999C5 15.307 5.10067 14.6376 5.28818 14.0056L5.11864 14.0204C3.36503 14.2104 2 15.6958 2 17.4999V21.9999H5V15.9999ZM22 21.9999V17.4999C22 15.6378 20.5459 14.1153 18.7118 14.0056 18.8993 14.6376 19 15.307 19 15.9999V21.9999H22Z"></path></svg>
      <span>Customer</span>
    </div>
    </a>

  <!--Products-->
  <a href="{{ route('product.list') }}"
  class="menu-link block rounded-lg px-3 py-2.5 font-medium text-sm
        hover:bg-slate-700/50 hover:text-white
        ring-1 ring-transparent hover:ring-slate-600 transition
        {{ request()->routeIs('product.list') ? 'bg-slate-700/60 text-white ring-slate-600' : 'text-slate-200' }}">
  <div class="flex items-center gap-3">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5 opacity-90"><path d="M17.2847 10.6683L22.5 13.9909L17.248 17.3368L12 13.9934L6.75198 17.3368L1.5 13.9909L6.7152 10.6684L1.5 7.34587L6.75206 4L11.9999 7.34335L17.2481 4L22.5 7.34587L17.2847 10.6683ZM17.2112 10.6684L11.9999 7.3484L6.78869 10.6683L12 13.9883L17.2112 10.6684ZM6.78574 18.4456L12.0377 15.1L17.2898 18.4456L12.0377 21.7916L6.78574 18.4456Z"></path></svg>
    <span>Product</span>
  </div>
  </a>

    <!--Order-->
    <a href="{{ route('order.list') }}"
    class="menu-link block rounded-lg px-3 py-2.5 font-medium text-sm
          hover:bg-slate-700/50 hover:text-white
          ring-1 ring-transparent hover:ring-slate-600 transition
          {{ request()->routeIs('order.list') ? 'bg-slate-700/60 text-white ring-slate-600' : 'text-slate-200' }}">
    <div class="flex items-center gap-3">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5 opacity-90"><path d="M8 4H21V6H8V4ZM4.5 6.5C3.67157 6.5 3 5.82843 3 5C3 4.17157 3.67157 3.5 4.5 3.5C5.32843 3.5 6 4.17157 6 5C6 5.82843 5.32843 6.5 4.5 6.5ZM4.5 13.5C3.67157 13.5 3 12.8284 3 12C3 11.1716 3.67157 10.5 4.5 10.5C5.32843 10.5 6 11.1716 6 12C6 12.8284 5.32843 13.5 4.5 13.5ZM4.5 20.4C3.67157 20.4 3 19.7284 3 18.9C3 18.0716 3.67157 17.4 4.5 17.4C5.32843 17.4 6 18.0716 6 18.9C6 19.7284 5.32843 20.4 4.5 20.4ZM8 11H21V13H8V11ZM8 18H21V20H8V18Z"></path></svg>
      <span>Order</span>
    </div>
    </a>

    <!--wishlist-->
    <a href="{{ route('wishlist.list') }}"
    class="menu-link block rounded-lg px-3 py-2.5 font-medium text-sm
          hover:bg-slate-700/50 hover:text-white
          ring-1 ring-transparent hover:ring-slate-600 transition
          {{ request()->routeIs('wishlist.list') ? 'bg-slate-700/60 text-white ring-slate-600' : 'text-slate-200' }}">
    <div class="flex items-center gap-3">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5 opacity-90"><path d="M12.001 4.52853C14.35 2.42 17.98 2.49 20.2426 4.75736C22.5053 7.02472 22.583 10.637 20.4786 12.993L11.9999 21.485L3.52138 12.993C1.41705 10.637 1.49571 7.01901 3.75736 4.75736C6.02157 2.49315 9.64519 2.41687 12.001 4.52853Z"></path></svg>
      <span>Wishlist</span>
    </div>
    </a>

    <!-- Product Request -->
    <a href="{{ route('product.product-requests.index') }}"
      class="menu-link block rounded-lg px-3 py-2.5 font-medium text-sm
            hover:bg-slate-700/50 hover:text-white
            ring-1 ring-transparent hover:ring-slate-600 transition
            {{ request()->routeIs('product.product-requests.index') ? 'bg-slate-700/60 text-white ring-slate-600' : 'text-slate-200' }}">
      <div class="flex items-center gap-3">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5 opacity-90">
          <path d="M12 2L3 7v10l9 5 9-5V7l-9-5zm0 2.2L18.6 7 12 9.8 5.4 7 12 4.2zM5 9.2l6 3.3v7.2l-6-3.3V9.2zm8 10.5v-7.2l6-3.3v7.2l-6 3.3z"/>
          <path d="M11 10h2v2h2v2h-2v2h-2v-2H9v-2h2v-2z"/>
        </svg>

        {{-- <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5 opacity-90"><path d="M12.001 4.52853C14.35 2.42 17.98 2.49 20.2426 4.75736C22.5053 7.02472 22.583 10.637 20.4786 12.993L11.9999 21.485L3.52138 12.993C1.41705 10.637 1.49571 7.01901 3.75736 4.75736C6.02157 2.49315 9.64519 2.41687 12.001 4.52853Z"></path></svg> --}}
        <span>Product Request</span>
      </div>
    </a>

  <!-- Settings (native dropdown, no JS) -->
  <details class="group">
    <summary
      class="cursor-pointer w-full list-none flex items-center justify-between rounded-lg px-3 py-2.5 text-left
             text-sm font-semibold text-slate-200 hover:text-white hover:bg-slate-700/50
             ring-1 ring-transparent hover:ring-slate-600 transition">
      <span class="flex items-center gap-3">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5 opacity-90">
          <path d="M12 14V22H4C4 17.5817 7.58172 14 12 14ZM12 13C8.685 13 6 10.315 6 7C6 3.685 8.685 1 12 1C15.315 1 18 3.685 18 7C18 10.315 15.315 13 12 13ZM14.5946 18.8115C14.5327 18.5511 14.5 18.2794 14.5 18C14.5 17.7207 14.5327 17.449 14.5945 17.1886L13.6029 16.6161L14.6029 14.884L15.5952 15.4569C15.9883 15.0851 16.4676 14.8034 17 14.6449V13.5H19V14.6449C19.5324 14.8034 20.0116 15.0851 20.4047 15.4569L21.3971 14.8839L22.3972 16.616L21.4055 17.1885C21.4673 17.449 21.5 17.7207 21.5 18C21.5 18.2793 21.4673 18.551 21.4055 18.8114L22.3972 19.3839L21.3972 21.116L20.4048 20.543C20.0117 20.9149 19.5325 21.1966 19.0001 21.355V22.5H17.0001V21.3551C16.4677 21.1967 15.9884 20.915 15.5953 20.5431L14.603 21.1161L13.6029 19.384L14.5946 18.8115ZM18 17C17.4477 17 17 17.4477 17 18C17 18.5523 17.4477 19 18 19C18.5523 19 19 18.5523 19 18C19 17.4477 18.5523 17 18 17Z"></path>
        </svg>
        Settings
      </span>
      <svg xmlns="http://www.w3.org/2000/svg"
           viewBox="0 0 24 24" fill="currentColor"
           class="size-5 rounded-full bg-slate-700/60 p-0.5 transition-transform duration-300 rotate-90 group-open:rotate-180">
        <path d="M12 8L18 14H6L12 8Z"></path>
      </svg>
    </summary>

    <div class="mt-1 ml-2 pl-3 border-l border-slate-700/60 font-medium text-slate-300">
      @hasPermission('user.roles.list')
      <a href="{{ route('user.roles.list') }}"
         class="flex items-center gap-3 px-2.5 py-2 rounded-md
                hover:bg-slate-700/40 hover:text-white transition
                {{ request()->routeIs('user.roles.*') ? 'bg-slate-700/60 text-white' : '' }}">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4 opacity-90">
          <path d="M12 14V22H4C4 17.5817 7.58172 14 12 14ZM18 21.5L15.0611 23.0451L15.6224 19.7725L13.2447 17.4549L16.5305 16.9775L18 14L19.4695 16.9775L22.7553 17.4549L20.3776 19.7725L20.9389 23.0451L18 21.5ZM12 13C8.685 13 6 10.315 6 7C6 3.685 8.685 1 12 1C15.315 1 18 3.685 18 7C18 10.315 15.315 13 12 13Z"></path>
        </svg>
        <span>Role</span>
      </a>
      @endHasPermission

      @hasPermission('users.list')
      <a href="{{ route('users.list') }}"
         class="flex items-center gap-3 px-2.5 py-2 rounded-md hover:bg-slate-700/40 hover:text-white transition">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4 opacity-90">
          <path d="M8 4H21V6H8V4ZM3 3.5H6V6.5H3V3.5ZM3 10.5H6V13.5H3V10.5ZM3 17.5H6V20.5H3V17.5ZM8 11H21V13H8V11ZM8 18H21V20H8V18Z"></path>
        </svg>
        <span>User</span>
      </a>
      @endHasPermission

      @hasPermission('business-settings.edit')
        <a href="{{ route('business-settings.edit') }}"
          class="flex items-center gap-3 px-2.5 py-2 rounded-md hover:bg-slate-700/40 hover:text-white transition">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4 opacity-90">
            <path d="M13 14.0619V22H4C4 17.5817 7.58172 14 12 14C12.3387 14 12.6724 14.021 13 14.0619ZM12 13C8.685 13 6 10.315 6 7C6 3.685 8.685 1 12 1C15.315 1 18 3.685 18 7C18 10.315 15.315 13 12 13ZM17.7929 19.9142L21.3284 16.3787L22.7426 17.7929L17.7929 22.7426L14.2574 19.2071L15.6716 17.7929L17.7929 19.9142Z"></path>
          </svg>
          <span>Business Setting</span>
        </a>
      @endHasPermission

      @hasPermission('header-sliders.edit')
        <a href="{{ route('header-sliders.index') }}"
          class="flex items-center gap-3 px-2.5 py-2 rounded-md hover:bg-slate-700/40 hover:text-white transition">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4 opacity-90">
                <path d="M13 14.0619V22H4C4 17.5817 7.58172 14 12 14C12.3387 14 12.6724 14.021 13 14.0619ZM12 13C8.685 13 6 10.315 6 7C6 3.685 8.685 1 12 1C15.315 1 18 3.685 18 7C18 10.315 15.315 13 12 13ZM17.7929 19.9142L21.3284 16.3787L22.7426 17.7929L17.7929 22.7426L14.2574 19.2071L15.6716 17.7929L17.7929 19.9142Z"></path>
            </svg>
            <span>Header Sliders</span>
        </a>
      @endHasPermission

      @hasPermission('footer-sliders.edit')
        <a href="{{ route('footer-sliders.index') }}"
          class="flex items-center gap-3 px-2.5 py-2 rounded-md hover:bg-slate-700/40 hover:text-white transition">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4 opacity-90">
                <path d="M13 14.0619V22H4C4 17.5817 7.58172 14 12 14C12.3387 14 12.6724 14.021 13 14.0619ZM12 13C8.685 13 6 10.315 6 7C6 3.685 8.685 1 12 1C15.315 1 18 3.685 18 7C18 10.315 15.315 13 12 13ZM17.7929 19.9142L21.3284 16.3787L22.7426 17.7929L17.7929 22.7426L14.2574 19.2071L15.6716 17.7929L17.7929 19.9142Z"></path>
            </svg>
            <span>Footer Sliders</span>
        </a>
      @endHasPermission



      {{-- @hasPermission('account-user.index') --}}
      <a href="#"
         class="flex items-center gap-3 px-2.5 py-2 rounded-md hover:bg-slate-700/40 hover:text-white transition">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4 opacity-90">
          <path d="M13 4H21V6H13V4ZM13 11H21V13H13V11ZM13 18H21V20H13V18ZM6.5 19C5.39543 19 4.5 18.1046 4.5 17C4.5 15.8954 5.39543 15 6.5 15C7.60457 15 8.5 15.8954 8.5 17C8.5 18.1046 7.60457 19 6.5 19ZM6.5 21C8.70914 21 10.5 19.2091 10.5 17C10.5 14.7909 8.70914 13 6.5 13C4.29086 13 2.5 14.7909 2.5 17C2.5 19.2091 4.29086 21 6.5 21ZM5 6V9H8V6H5ZM3 4H10V11H3V4Z"></path>
        </svg>
        <span>Change Password</span>
      </a>
      {{-- @endHasPermission --}}
    </div>
  </details>

  <!-- Logout -->
  <form action="{{ route('logout') }}" method="POST" class="pt-2 border-t border-slate-700/60">
    @csrf
    <button type="submit"
            class="w-full text-left rounded-lg px-3 py-2.5 font-semibold text-sm
                   text-rose-300 hover:text-rose-100 hover:bg-rose-500/10
                   ring-1 ring-transparent hover:ring-rose-400/30 transition">
      <div class="flex items-center gap-3">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5 opacity-90">
          <path d="M3 12C3 12.5523 3.44772 13 4 13H10C10.5523 13 11 12.5523 11 12V4C11 3.44772 10.5523 3 10 3H4C3.44772 3 3 3.44772 3 4V12ZM3 20C3 20.5523 3.44772 21 4 21H10C10.5523 21 11 20.5523 11 20V16C11 15.4477 10.5523 15 10 15H4C3.44772 15 3 15.4477 3 16V20ZM13 20C13 20.5523 13.4477 21 14 21H20C20.5523 21 21 20.5523 21 20V12C21 11.4477 20.5523 11 20 11H14C13.4477 11 13 11.4477 13 12V20ZM14 3C13.4477 3 13 3.44772 13 4V8C13 8.55228 13.4477 9 14 9H20C20.5523 9 21 8.55228 21 8V4C21 3.44772 20.5523 3 20 3H14Z"></path>
        </svg>
        <span>Logout</span>
      </div>
    </button>
  </form>

</div>
