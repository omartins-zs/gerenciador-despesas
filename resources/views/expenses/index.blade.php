<h1>Despesas e Receitas</h1>

<a href="{{ route('expenses.create') }}">Nova Despesa</a>

<ul>
    @foreach($expenses as $expense)
        <li>
            {{ $expense->description }} - R$ {{ number_format($expense->amount, 2, ',', '.') }} - {{ $expense->type }} - {{ $expense->category }} - {{ $expense->created_at->format('d/m/Y') }}
        </li>
    @endforeach
</ul>
