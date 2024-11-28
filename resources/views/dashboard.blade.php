<x-app-layout>
    <div class="max-w-7xl mx-auto mt-10">
        <h1 class="text-3xl font-bold mb-5">Dashboard</h1>

        <!-- Saldo e Resumo -->
        <div class="grid grid-cols-3 gap-4 mb-6">
            <div class="bg-white p-5 rounded-lg shadow">
                <h3 class="text-lg font-semibold">Saldo Atual</h3>
                <p class="text-2xl">R$ {{ number_format($netBalance, 2, ',', '.') }}</p>
            </div>
            <div class="bg-white p-5 rounded-lg shadow">
                <h3 class="text-lg font-semibold">Total de Receitas</h3>
                <p class="text-2xl">R$ {{ number_format($totalIncome, 2, ',', '.') }}</p>
            </div>
            <div class="bg-white p-5 rounded-lg shadow">
                <h3 class="text-lg font-semibold">Total de Despesas</h3>
                <p class="text-2xl">R$ {{ number_format($totalExpense, 2, ',', '.') }}</p>
            </div>
        </div>

        <!-- Últimas Transações -->
        <h3 class="text-2xl font-semibold mb-4">Últimas Transações</h3>
        <table class="min-w-full table-auto border-collapse border border-gray-200">
            <thead>
                <tr class="bg-gray-100">
                    <th class="px-4 py-2 border">Descrição</th>
                    <th class="px-4 py-2 border">Categoria</th>
                    <th class="px-4 py-2 border">Valor</th>
                    <th class="px-4 py-2 border">Data</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transactions as $transaction)
                    <tr>
                        <td class="px-4 py-2 border">{{ $transaction->description }}</td>
                        <td class="px-4 py-2 border">{{ $transaction->category }}</td>
                        <td class="px-4 py-2 border">R$ {{ number_format($transaction->amount, 2, ',', '.') }}</td>
                        <td class="px-4 py-2 border">{{ $transaction->created_at->format('d/m/Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <canvas id="transactionChart"></canvas>
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
