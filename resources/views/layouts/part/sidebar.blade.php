
@foreach ($menuItems as $menu)
<li>
    <div>
        <div @click="openMenu === {{ $menu['id'] }} ? openMenu = null : openMenu = {{ $menu['id'] }}"
            class="flex items-center justify-between p-2 rounded-lg text-white cursor-pointer hover:bg-gray-100 hover:text-black transition">
            <div class="flex items-center">
                <!-- Icon -->
                <svg class="shrink-0 w-5 h-5  hover:text-black" fill="currentColor"
                    viewBox="0 0 18 18">
                    <path
                        d="M6.143 0H1.857A1.857 1.857 0 0 0 0 1.857v4.286C0 7.169.831 8 1.857 8h4.286A1.857 1.857 0 0 0 8 6.143V1.857A1.857 1.857 0 0 0 6.143 0Zm10 0h-4.286A1.857 1.857 0 0 0 10 1.857v4.286C10 7.169 10.831 8 11.857 8h4.286A1.857 1.857 0 0 0 18 6.143V1.857A1.857 1.857 0 0 0 16.143 0Zm-10 10H1.857A1.857 1.857 0 0 0 0 11.857v4.286C0 17.169.831 18 1.857 18h4.286A1.857 1.857 0 0 0 8 16.143v-4.286A1.857 1.857 0 0 0 6.143 10Zm10 0h-4.286A1.857 1.857 0 0 0 10 11.857v4.286c0 1.026.831 1.857 1.857 1.857h4.286A1.857 1.857 0 0 0 18 16.143v-4.286A1.857 1.857 0 0 0 16.143 10Z" />
                </svg>
                <span class="ms-3">{{ $menu['title'] }}</span>
            </div>

            <!-- Arrow -->
            <svg class="w-4 h-4 transition-transform duration-200"
                :class="openMenu === {{ $menu['id'] }} ? 'rotate-180' : ''"
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M19 9l-7 7-7-7" />
            </svg>
        </div>

        <ul x-show="openMenu === {{ $menu['id'] }}" x-collapse
            class="ml-6 mt-1 space-y-1 overflow-hidden" x-cloak>
            @foreach ($menu['children'] as $child)
                <li>
                    <a href="{{ $child['form'] ? url('form/' . $child['form']) : '#' }}"
                        class="block p-2 text-sm text-white rounded hover:bg-gray-100 hover:text-black transition">
                        {{ $child['title'] }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</li>
@endforeach