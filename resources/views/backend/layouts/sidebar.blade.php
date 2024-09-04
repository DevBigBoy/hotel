 <!--sidebar wrapper -->
 <div class="sidebar-wrapper" data-simplebar="true">
     <div class="sidebar-header">
         <div>
             <img src="{{ asset('backend/assets/images/logo-icon.png') }}" class="logo-icon" alt="logo icon">
         </div>
         <div>
             <h4 class="logo-text">
                 Almasa
             </h4>
         </div>
         <div class="toggle-icon ms-auto"><i class='bx bx-arrow-back'></i>
         </div>
     </div>

     <!--navigation-->
     <ul class="metismenu" id="menu">

         <li>
             <a href="{{ route('admin.dashboard') }}">
                 <div class="parent-icon"><i class='bx bx-home-alt'></i>
                 </div>
                 <div class="menu-title">Dashboard</div>
             </a>
         </li>

         <li>
             <a href="{{ route('admin.teams.index') }}">
                 <div class="parent-icon">
                     <i class='bx bxs-group'></i>
                 </div>
                 <div class="menu-title">Manage Teams</div>
             </a>
         </li>




         <li class="menu-label">UI Elements</li>

         <li>
             <a href="{{ route('admin.bookarea.index') }}">
                 <div class="parent-icon">
                     <i class='bx bxs-bank'></i>
                 </div>
                 <div class="menu-title">Book Area</div>
             </a>
         </li>

         <li>
             <a href="{{ route('admin.rooms.index') }}">
                 <div class="parent-icon">
                     <i class='bx bxs-extension'></i>
                 </div>
                 <div class="menu-title">Manage Room</div>
             </a>
         </li>

         <li>
             <a href="{{ route('admin.room-types.index') }}">
                 <div class="parent-icon">
                     <i class='bx bxs-alarm-add'></i>
                 </div>
                 <div class="menu-title">Manage Room Type</div>
             </a>
         </li>






     </ul>
     <!--end navigation-->
 </div>
 <!--end sidebar wrapper -->
