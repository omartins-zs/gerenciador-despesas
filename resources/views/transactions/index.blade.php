@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto mt-10">
    <h1 class="text-3xl font-bold mb-5">Minhas Transações</h1>
    <a href="{{ route('transactions.create') }}"
       class="bg-blue-500 text-white px-4 py-2 rounded-md mb-4 inline-block">
        Adicionar Transação
    </a>
    <div class="bg-white shadow-md rounded-lg p-6">
        @if($transactions->isEmpty())
            <p class="text-gray-500">Nenhuma transação encontrada.</p>
        @else
            <table class="min-w-full table-auto border-collapse border border-gray-200">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 border">Descrição</th>
                        <th class="px-4 py-2 border">Categoria</th>
                        <th class="px-4 py-2 border">Tipo</th>
                        <th class="px-4 py-2 border">Valor</th>
                        <th class="px-4 py-2 border">Data</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $transaction)
                        <tr>
                            <td class="px-4 py-2 border">{{ $transaction->description }}</td>
                            <td class="px-4 py-2 border">{{ $transaction->category }}</td>
                            <td class="px-4 py-2 border">
                                {{ $transaction->type === 'income' ? 'Receita' : 'Despesa' }}
                            </td>
                            <td class="px-4 py-2 border">
                                R$ {{ number_format($transaction->amount, 2, ',', '.') }}
                            </td>
                            <td class="px-4 py-2 border">{{ $transaction->created_at->format('d/m/Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
@endsection
