<div class="p-6 bg-gray-50 min-h-screen">
    <h1 class="text-3xl font-extrabold text-gray-800 mb-6 border-b pb-2">
        <i class="fas fa-users mr-2"></i> Gerenciar Colaboradores
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
            <h3 class="text-xl font-semibold mb-4 text-gray-700">Cadastrar Novo Colaborador</h3>
            <form wire:submit.prevent="save">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    
                    <div>
                        <label for="nome" class="block text-sm font-medium text-gray-700 mb-1">Nome</label>
                        <input type="text" id="nome" wire:model.live="nome"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 p-2">
                        @error('nome') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" id="email" wire:model.live="email"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 p-2">
                        @error('email') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="cpf" class="block text-sm font-medium text-gray-700 mb-1">CPF</label>
                        <input type="text" id="cpf" wire:model.live="cpf" maxlength="11"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 p-2">
                        @error('cpf') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    
                    <div>
                        <label for="unidade_id" class="block text-sm font-medium text-gray-700 mb-1">Unidade</label>
                        <select id="unidade_id" wire:model.live="unidade_id"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 p-2">
                            <option value="">-- Selecione uma Unidade --</option>
                            @foreach ($unidades as $unidade)
                                <option value="{{ $unidade->Id }}">{{ $unidade->Nome }} ({{ $unidade->Razao_social }})</option>
                            @endforeach
                        </select>
                        @error('unidade_id') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>
                
                <div class="flex items-center justify-end mt-6">
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-Black font-bold py-2 px-4 rounded-lg transition duration-150 ease-in-out shadow-md">
                        <i class="fas fa-save mr-2"></i> Salvar Colaborador
                    </button>
                </div>
            </form>
        </div>
    @else
        <div class="bg-yellow-50 shadow-xl rounded-lg p-6 border-t-4 border-yellow-500">
            <h3 class="text-xl font-bold mb-4 text-yellow-800">Editando Colaborador ID: {{ $colaboradorId }}</h3>
            <form wire:submit.prevent="update">
                 <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                     
                    <div>
                        <label for="nomeEditando" class="block text-sm font-medium text-gray-700 mb-1">Nome</label>
                        <input type="text" id="nomeEditando" wire:model.live="nomeEditando"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500 p-2">
                        @error('nomeEditando') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="emailEditando" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" id="emailEditando" wire:model.live="emailEditando"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500 p-2">
                        @error('emailEditando') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="cpfEditando" class="block text-sm font-medium text-gray-700 mb-1">CPF</label>
                        <input type="text" id="cpfEditando" wire:model.live="cpfEditando" maxlength="11"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500 p-2">
                        @error('cpfEditando') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    
                    <div>
                        <label for="unidadeIdEditando" class="block text-sm font-medium text-gray-700 mb-1">Unidade</label>
                        <select id="unidadeIdEditando" wire:model.live="unidadeIdEditando"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500 p-2">
                            @foreach ($unidades as $unidade)
                                <option value="{{ $unidade->Id }}">{{ $unidade->Nome }} ({{ $unidade->Razao_social }})</option>
                            @endforeach
                        </select>
                        @error('unidadeIdEditando') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>
                
                <div class="flex items-center justify-end space-x-3 mt-6">
                    <button type="button" wire:click="cancelEdit" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded-lg transition duration-150 ease-in-out">
                        <i class="fas fa-times mr-2"></i> Cancelar
                    </button>
                    <button type="submit" class="bg-yellow-600 hover:bg-yellow-700 text-Black font-bold py-2 px-4 rounded-lg transition duration-150 ease-in-out shadow-md">
                        <i class="fas fa-save mr-2"></i> Atualizar Colaborador
                    </button>
                </div>
            </form>
        </div>
    @endif
    </div>


    <div class="mt-8">
        <h3 class="text-2xl font-semibold text-gray-800 mb-4">Lista de Colaboradores Cadastrados</h3>
    </div>
    <div class="overflow-x-auto shadow-xl rounded-lg border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nome</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">CPF</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Unidade</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Data Criação</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Ações</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                @forelse ($colaboradores as $colaborador)
                    <tr class="hover:bg-gray-50 transition duration-100">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $colaborador->Id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $colaborador->Nome }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $colaborador->Email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $colaborador->Cpf }}</td>
                        
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            {{ $colaborador->unidade->Nome ?? 'N/A' }} 
                        </td>
                        
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $colaborador->Data_criacao }}</td> 
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <button wire:click="edit({{ $colaborador->Id }})" class="text-blue-600 hover:text-blue-900 transition duration-150 ease-in-out font-semibold mr-3">
                                <i class="fas fa-edit mr-1"></i> Editar
                            </button>
                            <button wire:click="delete({{ $colaborador->Id }})" 
                                    wire:confirm="Tem certeza que deseja deletar o colaborador '{{ $colaborador->Nome }}'?"
                                    class="text-red-600 hover:text-red-900 transition duration-150 ease-in-out font-semibold">
                                <i class="fas fa-trash-alt mr-1"></i> Deletar
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-lg text-gray-500 bg-gray-50">
                            <i class="fas fa-box-open mr-2"></i> Nenhum Colaborador encontrado.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>