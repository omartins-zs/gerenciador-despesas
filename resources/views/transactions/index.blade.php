<x-app-layout>
    <div class="max-w-6xl mx-auto mt-10 text-gray-300">
        <h1 class="text-3xl font-bold mb-5">Minhas Transações</h1>

        <!-- Exibir Totais de Receitas, Despesas e Saldo Líquido -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
            <div class="bg-gray-800 p-4 rounded-md shadow">
                <p class="text-sm font-medium text-gray-400">Total de Receitas</p>
                <p class="text-lg font-bold text-green-400">R$ {{ number_format($totalIncome, 2, ',', '.') }}</p>
            </div>
            <div class="bg-gray-800 p-4 rounded-md shadow">
                <p class="text-sm font-medium text-gray-400">Total de Despesas</p>
                <p class="text-lg font-bold text-red-400">R$ {{ number_format($totalExpense, 2, ',', '.') }}</p>
            </div>
            <div class="bg-gray-800 p-4 rounded-md shadow">
                <p class="text-sm font-medium text-gray-400">Saldo Líquido</p>
                <p class="text-lg font-bold {{ $netBalance < 0 ? 'text-red-400' : 'text-green-400' }}">
                    R$ {{ number_format($netBalance, 2, ',', '.') }}
                </p>
            </div>
        </div>

        <!-- Filtro de Categorias -->
        <form method="GET" action="{{ route('transactions.index') }}" class="mb-4 flex flex-wrap items-end gap-4">
            <div class="flex-grow">
                <label for="category" class="block text-sm font-medium text-gray-400">Filtrar por Categoria:</label>
                <select name="category" id="category"
                    class="w-full bg-gray-800 text-gray-300 border border-gray-600 rounded-md shadow-sm focus:ring focus:ring-blue-300 focus:ring-opacity-50">
                    <option value="all">Todas</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category }}" {{ request('category') === $category ? 'selected' : '' }}>
                            {{ ucfirst($category) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <button type="submit"
                    class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md shadow transition">
                    Filtrar
                </button>
            </div>
        </form>


        <!-- Botão para Adicionar Transações -->
        <div class="flex justify-between items-center mb-4">
            <!-- Botões de Exportação (à esquerda) -->
            <div class="flex gap-4">
                <!-- Exportar CSV -->
                <a href="{{ route('transactions.export') }}" class="bg-blue-500 text-white px-4 py-2 rounded-md">
                    Exportar CSV
                </a>

                <!-- Exportar PDF -->
                <a href="{{ route('transactions.exportPdf') }}" class="bg-green-500 text-white px-4 py-2 rounded-md">
                    Exportar PDF
                </a>
            </div>

            <!-- Botão de Adicionar Transações (à direita) -->
            <a href="{{ route('transactions.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md shadow transition">
                Adicionar Transação
            </a>
        </div>

        <!-- Tabela de Transações -->
        <div class="bg-gray-800 shadow-md rounded-lg p-6">
            @if ($transactions->isEmpty())
                <p class="text-gray-500">Nenhuma transação encontrada.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full table-auto border-collapse border border-gray-700">
                        <thead>
                            <tr class="bg-gray-700">
                                <th class="px-4 py-2 border text-left text-gray-300">Descrição</th>
                                <th class="px-4 py-2 border text-left text-gray-300">Categoria</th>
                                <th class="px-4 py-2 border text-left text-gray-300">Tipo</th>
                                <th class="px-4 py-2 border text-right text-gray-300">Valor</th>
                                <th class="px-4 py-2 border text-center text-gray-300">Data</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transactions as $transaction)
                                <tr class="hover:bg-gray-700">
                                    <td class="px-4 py-2 border text-gray-300">{{ $transaction->description }}</td>
                                    <td class="px-4 py-2 border text-gray-300">{{ ucfirst($transaction->category) }}
                                    </td>
                                    <td class="px-4 py-2 border text-gray-300">
                                        {{ $transaction->type === 'income' ? 'Receita' : 'Despesa' }}
                                    </td>
                                    <td class="px-4 py-2 border text-right text-gray-300">
                                        R$ {{ number_format($transaction->amount, 2, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-2 border text-center text-gray-300">
                                        {{ $transaction->created_at->format('d/m/Y') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
