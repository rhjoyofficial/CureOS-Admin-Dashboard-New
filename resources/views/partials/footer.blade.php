<footer class="bg-white border-t border-gray-200 py-4 px-6">
    <div class="flex flex-col md:flex-row justify-between items-center">
        <div class="text-sm text-gray-600">
            &copy; {{ date('Y') }} {{ config('app.name', 'CureOS') }}. All rights reserved.
        </div>
        <div class="flex items-center space-x-4 mt-2 md:mt-0">
            <span class="text-sm text-gray-600">v1.0.0</span>
            <span class="text-sm text-gray-600">•</span>
            <span class="text-sm text-gray-600">
                <i class="fas fa-circle text-green-500 text-xs mr-1"></i>
                System Online
            </span>
        </div>
    </div>
</footer>
