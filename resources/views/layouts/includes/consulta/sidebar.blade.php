   @php
      $links = [
         [
            'name' => 'Dashboard',
            'icon' => 'fa-solid fa-gauge',
            'route' => route('admin.consulta.index'),
            'active' => request()->routeIs('admin.consulta.index')
         ]
];
   @endphp
   
   <aside id="logo-sidebar"
      class="fixed top-0 left-0 z-40 w-64 h-screen pt-16 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0 dark:bg-gray-800 dark:border-gray-700"
      :class="{
         'transform-none': open,
         '-translate-x-full': !open
      }"

      aria-label="Sidebar">
               <div class="h-full px-3 py-4 overflow-y-auto bg-neutral-primary-soft border-e border-default">
                

                  <ul class="space-y-2 font-medium">

                     @foreach ($links as $link )
                        <li>
                           <a href="{{ $link['route'] }}"
   class="flex items-center px-2 py-1.5 rounded-md
          text-gray-700
          hover:bg-gray-100 hover:text-gray-700 group {{ $link['active'] ? 'bg-gray-100': '' }}">

                           <span class="inline-flex w-6 h-6 justify-center items-center">
                           <i class="{{ $link['icon'] }} text-gray-500"></i>
                           </span>
                           <span class="ms-3">
                              {{ $link['name'] }}
                           </span>
                        </a>
                     </li>
                     @endforeach
                     
                     
                  </ul>
               </div>
   </aside>