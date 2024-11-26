<form action="{{ route('expenses.store') }}" method="POST">
    @csrf
    <div>
        <label for="description">Descrição:</label>
        <input type="text" name="description" id="description" required>
    </div>

    <div>
        <label for="amount">Valor:</label>
        <input type="number" name="amount" id="amount" required step="0.01">
    </div>

    <div>
        <label for="type">Tipo:</label>
        <select name="type" id="type">
            <option value="expense">Despesa</option>
            <option value="income">Receita</option>
        </select>
    </div>

    <div>
        <label for="category">Categoria:</label>
        <input type="text" name="category" id="category" required>
    </div>

    <button type="submit">Salvar</button>
</form>
