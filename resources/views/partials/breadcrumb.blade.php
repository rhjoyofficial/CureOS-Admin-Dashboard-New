<nav class="mb-6" aria-label="Breadcrumb">
    <ol class="flex items-center space-x-2 text-sm">
        <li>
            <a href="{{ route('dashboard') }}" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-home"></i>
            </a>
        </li>

        @php
            $segments = Request::segments();
            $url = '';
        @endphp

        @foreach ($segments as $segment)
            @php
                $url .= '/' . $segment;
                $name = ucfirst(str_replace('-', ' ', $segment));
            @endphp

            @if (!$loop->last)
                <li class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                    <a href="{{ $url }}" class="text-gray-500 hover:text-gray-700">{{ $name }}</a>
                </li>
            @else
                <li class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                    <span class="text-gray-900 font-medium">{{ $name }}</span>
                </li>
            @endif
        @endforeach
    </ol>
</nav>
