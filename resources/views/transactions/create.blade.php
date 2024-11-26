@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto mt-10">
    <h1 class="text-3xl font-bold mb-5">Adicionar Transação</h1>
    <div class="bg-white shadow-md rounded-lg p-6">
        <form action="{{ route('transactions.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="description" class="block text-gray-700 font-bold mb-2">Descrição</label>
                <input type="text" name="description" id="description"
                       class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200"
                       required>
            </div>
            <div class="mb-4">
                <label for="category" class="block text-gray-700 font-bold mb-2">Categoria</label>
                <input type="text" name="category" id="category"
                       class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200"
                       required>
            </div>
            <div class="mb-4">
                <label for="type" class="block text-gray-700 font-bold mb-2">Tipo</label>
                <select name="type" id="type"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200">
                    <option value="income">Receita</option>
                    <option value="expense">Despesa</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="amount" class="block text-gray-700 font-bold mb-2">Valor</label>
                <input type="number" name="amount" id="amount" step="0.01"
                       class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200"
                       required>
            </div>
            <div class="flex justify-end">
                <button type="submit"
                        class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">
                    Salvar
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
