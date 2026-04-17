<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-2xl font-bold mb-6">Dashboard</h1>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                        <div class="bg-green-500 text-white p-6 rounded-lg shadow">
                            <div class="text-lg">Total Members</div>
                            <div class="text-3xl font-bold">{{ \App\Models\User::where('role', 'member')->count() }}</div>
                        </div>
                        <div class="bg-blue-500 text-white p-6 rounded-lg shadow">
                            <div class="text-lg">Organizations</div>
                            <div class="text-3xl font-bold">{{ \App\Models\User::where('role', 'organAdmin')->count() }}</div>
                        </div>
                        <div class="bg-purple-500 text-white p-6 rounded-lg shadow">
                            <div class="text-lg">Total Payments</div>
                            <div class="text-3xl font-bold">ETB {{ number_format(\App\Models\Payment::sum('amount') ?? 0, 0) }}</div>
                        </div>
                        <div class="bg-yellow-500 text-white p-6 rounded-lg shadow">
                            <div class="text-lg">Total Users</div>
                            <div class="text-3xl font-bold">{{ \App\Models\User::count() }}</div>
                        </div>
                    </div>
                    
                    <h2 class="text-xl font-semibold mb-4">Quick Actions</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <a href="/organ" class="block p-4 bg-gray-100 rounded-lg hover:bg-gray-200 text-center">
                            <div class="font-semibold">Manage Organizations</div>
                        </a>
                        <a href="/members" class="block p-4 bg-gray-100 rounded-lg hover:bg-gray-200 text-center">
                            <div class="font-semibold">Manage Members</div>
                        </a>
                        <a href="/payments" class="block p-4 bg-gray-100 rounded-lg hover:bg-gray-200 text-center">
                            <div class="font-semibold">Manage Payments</div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>