<x-app-layout>
    <div class="max-w-7xl mx-auto mt-10">
        <h1 class="text-3xl font-bold mb-5 text-gray-900 dark:text-white">Dashboard</h1>

        <!-- Saldo e Resumo -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-white dark:bg-gray-800 p-5 rounded-lg shadow">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Saldo Atual</h3>
                <p class="text-2xl text-gray-900 dark:text-white">R$ {{ number_format($netBalance, 2, ',', '.') }}</p>
            </div>
            <div class="bg-white dark:bg-gray-800 p-5 rounded-lg shadow">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Total de Receitas</h3>
                <p class="text-2xl text-gray-900 dark:text-white">R$ {{ number_format($totalIncome, 2, ',', '.') }}</p>
            </div>
            <div class="bg-white dark:bg-gray-800 p-5 rounded-lg shadow">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Total de Despesas</h3>
                <p class="text-2xl text-gray-900 dark:text-white">R$ {{ number_format($totalExpense, 2, ',', '.') }}</p>
            </div>
        </div>

        <!-- Últimas Transações -->
        <h3 class="text-2xl font-semibold mb-4 text-gray-900 dark:text-white">Últimas Transações</h3>
        <div class="overflow-x-auto bg-white dark:bg-gray-800 shadow-md rounded-lg p-5">
            <table class="min-w-full table-auto border-collapse border border-gray-200 dark:border-gray-600">
                <thead>
                    <tr class="bg-gray-100 dark:bg-gray-700">
                        <th class="px-4 py-2 border text-gray-900 dark:text-white">Descrição</th>
                        <th class="px-4 py-2 border text-gray-900 dark:text-white">Categoria</th>
                        <th class="px-4 py-2 border text-gray-900 dark:text-white">Valor</th>
                        <th class="px-4 py-2 border text-gray-900 dark:text-white">Data</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transactions as $transaction)
                        <tr class="bg-white dark:bg-gray-800">
                            <td class="px-4 py-2 border text-gray-900 dark:text-white">{{ $transaction->description }}
                            </td>
                            <td class="px-4 py-2 border text-gray-900 dark:text-white">{{ $transaction->category }}</td>
                            <td class="px-4 py-2 border text-gray-900 dark:text-white">R$
                                {{ number_format($transaction->amount, 2, ',', '.') }}</td>
                            <td class="px-4 py-2 border text-gray-900 dark:text-white">
                                {{ $transaction->created_at->format('d/m/Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Gráfico de transações -->
    <div class="max-w-7xl mx-auto mt-8">
        <h3 class="text-2xl font-semibold mb-4 text-gray-900 dark:text-white">Gráfico de Receitas e Despesas</h3>
        <div class="w-full h-64">
            <canvas id="transactionChart" class="w-full h-full"></canvas>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var ctx = document.getElementById('transactionChart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Receitas', 'Despesas'],
                datasets: [{
                    label: 'Transações',
                    data: [{{ $totalIncome }}, {{ $totalExpense }}],
                    backgroundColor: ['#4caf50', '#f44336'],
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false, // Garante que o gráfico será redimensionado conforme a div
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return 'R$ ' + tooltipItem.raw.toFixed(2);
                            }
                        }
                    }
                }
            }
        });
    </script>
</x-app-layout>
