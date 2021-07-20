<?php

$mensagem = '';
if (isset($_GET['status'])) {
    switch ($_GET['status']) {
        case 'success':
            $mensagem = '<div class="alert alert-success">Ação executada com sucesso!</div>';
            break;

        case 'error':
            $mensagem = '<div class="alert alert-danger">Ação não executada!</div>';
            break;
    }
}

$resultados = '';
foreach ($vagas as $vaga) {
    $resultados .= '<tr>';
    // Primeira coluna: ID
    $resultados .= '<td>';
    $resultados .= $vaga->id;
    $resultados .= '</td>';
    // Segunda coluna: Titulo
    $resultados .= '<td>';
    $resultados .= $vaga->titulo;
    $resultados .= '</td>';
    // Terceira coluna: Descrição
    $resultados .= '<td>';
    $resultados .= $vaga->descricao;
    $resultados .= '</td>';
    // Quarta coluna: status da vaga
    $resultados .= '<td>';
    $resultados .= ($vaga->ativo == 's' ? 'Ativo' : 'Inativo');
    $resultados .= '</td>';
    // Quinta coluna: Data de criação da vaga
    $resultados .= '<td>';
    $resultados .= date('d/m/Y à\s H:i:s', strtotime($vaga->data));
    $resultados .= '</td>';
    // Sexta coluna: botões de ação
    $resultados .= '<td>';
    $resultados .= '<a href="editar.php?id=' . $vaga->id . '">';
    $resultados .= '<button type="button" class="btn btn-primary">Editar</button>';
    $resultados .= '</a>';
    $resultados .= '<a href="excluir.php?id=' . $vaga->id . '">';
    $resultados .= '<button type="button" class="btn btn-danger ml-2">Excluir</button>';
    $resultados .= '</a>';
    $resultados .= '</td>';
    $resultados .= '</tr>';
}

$resultados = strlen($resultados) ? $resultados :
    '<tr>
        <td colspan="6" class="text-center">
            Nenhuma vaga encontrada
        </td>
    </tr>';

?>

<main>

    <?= $mensagem ?>

    <section>
        <a href="cadastrar.php">
            <button class="btn btn-success">Nova vaga</button>
        </a>
    </section>

    <section>

        <table class="table bg-light mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Descrição</th>
                    <th>Status</th>
                    <th>Data</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?= $resultados ?>
            </tbody>
        </table>

    </section>


</main>