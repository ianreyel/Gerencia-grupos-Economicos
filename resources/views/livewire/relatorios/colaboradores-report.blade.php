<div class="p-6 bg-gray-50 min-h-screen">
    <h1 class="text-3xl font-extrabold text-gray-800 mb-6 border-b pb-2">
        <i class="fas fa-chart-line mr-2"></i> Relatório de Colaboradores
    </h1>

    <div class="bg-white shadow-xl rounded-lg p-6 mb-8 border-t-4 border-indigo-500">
        <h3 class="text-xl font-semibold mb-4 text-gray-700">Filtros de Busca</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            
            <div>
                <label for="filterNome" class="block text-sm font-medium text-gray-700 mb-1">Nome do Colaborador</label>
                <input type="text" wire:model.live="filterNome" placeholder="Pesquisar por nome"
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2">
            </div>

            <div>
                <label for="filterGrupoId" class="block text-sm font-medium text-gray-700 mb-1">Grupo Econômico</label>
                <select wire:model.live="filterGrupoId" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2">
                    <option value="">-- Todos os Grupos --</option>
                    @foreach ($grupos as $grupo)
                        <option value="{{ $grupo->Id }}">{{ $grupo->Nome }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="filterBandeiraId" class="block text-sm font-medium text-gray-700 mb-1">Bandeira</label>
                <select wire:model.live="filterBandeiraId" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2">
                    <option value="">-- Todas as Bandeiras --</option>
                    @foreach ($bandeiras as $bandeira)
                        <option value="{{ $bandeira->Id }}">{{ $bandeira->Nome }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        
        <div class="flex justify-end mt-6">
            <button wire:click="exportExcel" class="bg-indigo-600 hover:bg-indigo-700 text-Black font-bold py-2 px-4 rounded-lg transition duration-150 ease-in-out shadow-md">
                <i class="fas fa-file-excel mr-2"></i> Exportar para Excel
            </button>
        </div>
    </div>

    <div class="mt-8">
        <h3 class="text-2xl font-semibold text-gray-800 mb-4">Resultados do Relatório</h3>
    </div>
    <div class="overflow-x-auto shadow-xl rounded-lg border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nome Colaborador</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Unidade</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Bandeira</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Grupo Econômico</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">CPF</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                @forelse ($colaboradores as $colaborador)
                    <tr class="hover:bg-gray-50 transition duration-100">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $colaborador->Nome }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $colaborador->Email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $colaborador->unidade->Nome ?? 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $colaborador->unidade->bandeira->Nome ?? 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $colaborador->unidade->bandeira->grupoEconomico->Nome ?? 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $colaborador->Cpf }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-lg text-gray-500 bg-gray-50">
                            <i class="fas fa-box-open mr-2"></i> Nenhum colaborador encontrado com os filtros aplicados.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        
        <div class="p-4 bg-white border-t border-gray-100">
            {{ $colaboradores->links() }}
        </div>
    </div>
</div>