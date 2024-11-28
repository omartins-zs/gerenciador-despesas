<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    // Listar transações
    public function index()
    {
        // Recuperar todas as transações do usuário autenticado
        $transactions = Auth::user()->transactions;

        // Calcular as receitas e despesas separadamente
        $totalIncome = $transactions->where('type', 'income')->sum('amount');
        $totalExpense = $transactions->where('type', 'expense')->sum('amount');
        $netBalance = $totalIncome - $totalExpense; // O valor líquido

        return view('transactions.index', compact('transactions', 'totalIncome', 'totalExpense', 'netBalance'));
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
