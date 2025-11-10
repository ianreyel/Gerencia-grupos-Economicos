<div class="p-6 bg-gray-50 min-h-screen">
    <h1 class="text-3xl font-extrabold text-gray-800 mb-6 border-b pb-2">
        <i class="fas fa-layer-group mr-2"></i> Gerenciar Grupos Econômicos
    </h1>

    @if (session()->has('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 shadow-md" role="alert">
            <p class="font-bold">Sucesso!</p>
            <p>{{ session('success') }}</p>
        </div>
    @endif
    
    @if (session()->has('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 shadow-md" role="alert">
            <p class="font-bold">Erro!</p>
            <p>{{ session('error') }}</p>
        </div>
    @endif
    
    <div class="mb-8">
        @if (!$this->editando)
            <div class="bg-white shadow-xl rounded-lg p-6 border-t-4 border-green-500">
                <h3 class="text-xl font-semibold mb-4 text-gray-700">Novo Grupo Econômico</h3>
                <form wire:submit.prevent="save">
                    <div class="mb-4">
                        <label for="nome" class="block text-sm font-medium text-gray-700 mb-1">Nome do Grupo</label>
                        <input type="text" id="nome" wire:model.live="nome" 
                            placeholder="Ex: Grupo Alfa"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 p-2">
                        
                        @error('nome') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    
                    <button type="submit" 
                        class="w-full bg-green-600 hover:bg-green-700 text-Black font-bold py-2 px-4 rounded-lg transition duration-150 ease-in-out shadow-md">
                        <i class="fas fa-plus mr-2"></i> Salvar Novo Grupo
                    </button>
                </form>
            </div>
        @else
            <div class="bg-yellow-50 shadow-xl rounded-lg p-6 border-t-4 border-yellow-500">
                <h3 class="text-xl font-bold mb-4 text-yellow-800">Editando Grupo ID: {{ $grupoId }}</h3>
                <form wire:submit.prevent="update">
                    <div class="mb-4">
                        <label for="nomeEditando" class="block text-sm font-medium text-gray-700 mb-1">Nome do Grupo</label>
                        <input type="text" id="nomeEditando" wire:model.live="nomeEditando" 
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500 p-2">

                        @error('nomeEditando') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex items-center justify-end space-x-3">
                        <button type="button" wire:click="cancelEdit" 
                            class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded-lg transition duration-150 ease-in-out">
                            <i class="fas fa-times mr-2"></i> Cancelar
                        </button>
                        <button type="submit" 
                            class="bg-yellow-600 hover:bg-yellow-700 text-Black font-bold py-2 px-4 rounded-lg transition duration-150 ease-in-out shadow-md">
                            <i class="fas fa-save mr-2"></i> Atualizar Grupo
                        </button>
                    </div>
                </form>
            </div>
        @endif
    </div>
    
    <div class="mt-8">
        <h3 class="text-2xl font-semibold text-gray-800 mb-4">Lista de Grupos Cadastrados</h3>
    </div>

    <div class="overflow-x-auto shadow-xl rounded-lg border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nome</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Data Criação</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Ações</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                @forelse ($grupos as $grupo)
                <tr class="hover:bg-gray-50 transition duration-100">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $grupo->Id }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $grupo->Nome }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ \Carbon\Carbon::parse($grupo->Data_criacao)->format('d/m/Y H:i') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <button wire:click="edit({{ $grupo->Id }})" 
                            class="text-blue-600 hover:text-blue-900 transition duration-150 ease-in-out font-semibold mr-3">
                            <i class="fas fa-edit mr-1"></i> Editar
                        </button>
                        <button wire:click="delete({{ $grupo->Id }})" 
                            wire:confirm="Tem certeza que deseja deletar o grupo '{{ $grupo->Nome }}'?"
                            class="text-red-600 hover:text-red-900 transition duration-150 ease-in-out font-semibold">
                            <i class="fas fa-trash-alt mr-1"></i> Deletar
                        </button>
                    </td>
                </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-lg text-gray-500 bg-gray-50">
                            <i class="fas fa-box-open mr-2"></i> Nenhum Grupo Econômico encontrado.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>