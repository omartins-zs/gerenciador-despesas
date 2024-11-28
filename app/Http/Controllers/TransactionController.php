<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Barryvdh\DomPDF\Facade\Pdf;

class TransactionController extends Controller
{
    // Listar transações
    public function index(Request $request)
    {
        // Recuperar a query base das transações do usuário autenticado
        $query = Auth::user()->transactions();

        // Aplicar filtro de categoria, se existir
        if ($request->has('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        // Obter as transações filtradas
        $transactions = $query->get();

        // Calcular as receitas, despesas e saldo líquido
        $totalIncome = $transactions->where('type', 'income')->sum('amount');
        $totalExpense = $transactions->where('type', 'expense')->sum('amount');
        $netBalance = $totalIncome - $totalExpense;

        // Obter lista única de categorias para o filtro
        $categories = Auth::user()->transactions()->select('category')->distinct()->pluck('category');

        // Retornar a view com os dados
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

    public function exportCsv()
    {
        $transactions = Auth::user()->transactions;

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=transacoes.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0",
        ];

        $callback = function () use ($transactions) {
            $output = fopen('php://output', 'w');
            fputcsv($output, ['Descrição', 'Categoria', 'Tipo', 'Valor', 'Data']);

            foreach ($transactions as $transaction) {
                fputcsv($output, [
                    $transaction->description,
                    $transaction->category,
                    $transaction->type === 'income' ? 'Receita' : 'Despesa',
                    $transaction->amount,
                    $transaction->created_at->format('d/m/Y'),
                ]);
            }
            fclose($output);
        };

        return Response::stream($callback, 200, $headers);
    }

    public function exportPdf()
    {
        // Recupera as transações do usuário autenticado
        $transactions = Auth::user()->transactions;

        if ($transactions->isEmpty()) {
            return back()->with('error', 'Você não tem transações para exportar.');
        }

        // Carrega a view com os dados e gera o PDF
        $pdf = Pdf::loadView('transactions.pdf', compact('transactions'));

        // Faz o download do PDF gerado
        return $pdf->download('transacoes.pdf');
    }
}
