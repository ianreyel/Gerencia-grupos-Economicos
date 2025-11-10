<div class="p-6 bg-gray-50 min-h-screen">
    <h1 class="text-3xl font-extrabold text-gray-800 mb-6 border-b pb-2">
        <i class="fas fa-history mr-2"></i> Histórico de Auditoria
    </h1>

    <div class="bg-white shadow-xl rounded-lg p-6 mb-8 border-t-4 border-teal-500">
        <h3 class="text-xl font-semibold mb-4 text-gray-700">Filtrar Eventos</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            
            <div>
                <label for="filterModel" class="block text-sm font-medium text-gray-700 mb-1">Entidade</label>
                <select wire:model.live="filterModel" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500 p-2">
                    <option value="">-- Todos os Modelos --</option>
                    @foreach ($models as $name => $class)
                        <option value="{{ $class }}">{{ $name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="filterEvent" class="block text-sm font-medium text-gray-700 mb-1">Ação</label>
                <select wire:model.live="filterEvent" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500 p-2">
                    <option value="">-- Todas as Ações --</option>
                    <option value="created">Criação</option>
                    <option value="updated">Atualização</option>
                    <option value="deleted">Deleção</option>
                </select>
            </div>
            
            <div>
                <label for="filterUser" class="block text-sm font-medium text-gray-700 mb-1">Usuário</label>
                <input type="text" wire:model.live="filterUser" placeholder="ID ou Nome"
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500 p-2">
            </div>

        </div>
    </div>

    <div class="mt-8">
        <h3 class="text-2xl font-semibold text-gray-800 mb-4">Eventos de Auditoria</h3>
    </div>
    <div class="overflow-x-auto shadow-xl rounded-lg border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ID Audit</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Entidade (Tipo/ID)</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Ação</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Usuário</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Data/Hora</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Detalhes</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                @forelse ($auditorias as $audit)
                    <tr class="hover:bg-gray-50 transition duration-100">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $audit->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            {{ array_search($audit->auditable_type, $models) ?: $audit->auditable_type }} ({{ $audit->auditable_id }})
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                @if($audit->event === 'created') bg-green-100 text-green-800
                                @elseif($audit->event === 'updated') bg-yellow-100 text-yellow-800
                                @elseif($audit->event === 'deleted') bg-red-100 text-red-800
                                @endif">
                                {{ ucfirst($audit->event) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $audit->user->name ?? 'Sistema/N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $audit->created_at->format('d/m/Y H:i:s') }}</td>
                        
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <button onclick="alert('Detalhes: Evento {{ $audit->event }} no ID {{ $audit->auditable_id }}. Detalhes: {{ json_encode($audit->old_values) }} -> {{ json_encode($audit->new_values) }}')" 
                                    class="text-teal-600 hover:text-teal-900 transition duration-150 ease-in-out font-semibold">
                                <i class="fas fa-eye mr-1"></i> Ver Alterações
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-lg text-gray-500 bg-gray-50">
                            <i class="fas fa-box-open mr-2"></i> Nenhum registro de auditoria encontrado.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        
        <div class="p-4 bg-white border-t border-gray-100">
            {{ $auditorias->links() }}
        </div>
    </div>
</div>