<div class="bg-white rounded-lg shadow p-6">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm text-gray-600">{{ $title }}</p>
            <p class="text-2xl font-bold text-gray-900">{{ $value }}</p>
        </div>
        <div class="p-3 bg-{{ $color }}-100 rounded-lg">
            <i class="fas fa-{{ $icon }} text-{{ $color }}-600 text-xl"></i>
        </div>
    </div>
</div>
