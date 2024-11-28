<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    // Listar transações
    public function index(Request $request)
    {
        // Recuperar todas as transações do usuário autenticado
        $query = Auth::user()->transactions();

        // Aplicar filtro de categoria, se existir
        if ($request->has('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        $transactions = $query->get();

        // Calcular as receitas, despesas e saldo líquido
        $totalIncome = $transactions->where('type', 'income')->sum('amount');
        $totalExpense = $transactions->where('type', 'expense')->sum('amount');
        $netBalance = $totalIncome - $totalExpense;

        // Obter lista única de categorias para o filtro
        $categories = Auth::user()->transactions()->distinct()->pluck('category');

        return view('transactions.index', compact('transactions', 'totalIncome', 'totalExpense', 'netBalance', 'categories'));
    }
    // Exibir formulário de criação
    public function create()
    {
        return view('transactions.create');
    }

    // Armazenar nova transação
    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'type' => 'required|in:income,expense',
            'amount' => 'required|numeric|min:0',
        ]);

        Transaction::create([
            'user_id' => Auth::id(),
            'description' => $request->description,
            'category' => $request->category,
            'type' => $request->type,
            'amount' => $request->amount,
        ]);

        return redirect()->route('transactions.index')->with('success', 'Transação adicionada com sucesso!');
    }
}
