<x-app-layout
    :menuItems="$menuItems" 
    :title="$title"
    :menuTitle="$menuTitle"
    :subMenuTitle="$subMenuTitle"
    :idApp="$idApp">

    <div>
        @if ($url)
        <iframe src="{{ $url }}" class="w-full h-screen border-0"></iframe>
        @else
        <p class="text-gray-500">Tidak ada URL untuk ditampilkan.</p>
        @endif
    </div>


</x-app-layout>