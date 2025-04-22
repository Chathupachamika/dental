<div class="relative">
    <button type="button" class="relative">
        <i class="fas fa-bell text-2xl"></i>
        <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">3</span>
    </button>

    <!-- Notification Panel -->
    <div id="notificationPanel" class="hidden absolute right-0 mt-2 w-80 bg-gray-800 rounded-lg shadow-lg border border-gray-700 z-50">
        <div class="p-4 border-b border-gray-700">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-white">Notifications</h3>
                <button id="closeButton" class="text-gray-400 hover:text-white">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>

        <div class="max-h-96 overflow-y-auto">
            <!-- Notification Items -->
            <div class="p-4 border-b border-gray-700 hover:bg-gray-700">
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0">
                        <i class="fas fa-car text-blue-500"></i>
                    </div>
                    <div>
                        <p class="text-sm text-white">New booking request from John Doe</p>
                        <p class="text-xs text-gray-400 mt-1">30 minutes ago</p>
                    </div>
                </div>
            </div>

            <div class="p-4 border-b border-gray-700 hover:bg-gray-700">
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0">
                        <i class="fas fa-user-check text-green-500"></i>
                    </div>
                    <div>
                        <p class="text-sm text-white">Vehicle return confirmed</p>
                        <p class="text-xs text-gray-400 mt-1">2 hours ago</p>
                    </div>
                </div>
            </div>

            <div class="p-4 border-b border-gray-700 hover:bg-gray-700">
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-circle text-yellow-500"></i>
                    </div>
                    <div>
                        <p class="text-sm text-white">Maintenance check due for Vehicle #A123</p>
                        <p class="text-xs text-gray-400 mt-1">1 day ago</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="p-4 text-center">
            <a href="#" class="text-indigo-400 hover:text-indigo-300 text-sm">View All Notifications</a>
        </div>
    </div>
</div>

<style>
    #notificationPanel {
        transition: opacity 0.3s ease-in-out;
    }

    #notificationPanel.open {
        display: block;
    }
</style>

<script>
    function toggleNotificationPanel() {
        const panel = document.getElementById('notificationPanel');
        panel.classList.toggle('hidden');
        panel.classList.toggle('open');
    }
</script>
