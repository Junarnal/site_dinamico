<?php
header('Content-Type: application/json');

$host = 'dpg-d1ljqpur433s73dqhng0-a.oregon-postgres.render.com';
$port = '5432';
$db_name = 'site_ifms_eng_soft';
$user = 'adm_site';
$password = 'eZifGf4YiHVOqrA9zLuMJcfwZmK2ScJB';

try {
    $conexao = new PDO("pgsql:host=$host;port=$port;dbname=$db_name;sslmode=require", $user, $password);
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Captura os dados do formulário
    $nome = $_POST['inscrito_nome'];
    $cpf = $_POST['inscrito_cpf'];
    $data_nasc = $_POST['inscrito_data_nasc'];
    $sexo = $_POST['inscrito_sexo'];
    $rg = $_POST['inscrito_rg'];
    $rg_expedidor = $_POST['inscrito_rg_expedidor'];
    $estado_civil = $_POST['inscrito_estado_civil'];
    $nome_mae = $_POST['inscrito_nome_mae'];
    $nome_pai = $_POST['inscrito_nome_pai'];
    $celular = $_POST['inscrito_celular'];
    $email = $_POST['inscrito_email'];
    $cep = $_POST['inscrito_cep'];
    $logradouro = $_POST['inscrito_logradouro'];
    $numero_end = $_POST['inscrito_numero_endereco'];
    $bairro = $_POST['inscrito_bairro'];
    $complemento = $_POST['inscrito_complemento'];
    $cidade = $_POST['inscrito_cidade'];
    $estado = $_POST['inscrito_estado'];
    $curso = $_POST['inscrito_curso'];
    $turno = $_POST['inscrito_turno'];

    $cpf = preg_replace('/\D/', '', $cpf);
    $celular = preg_replace('/\D/', '', $celular);

    // Prepara e executa a SQL
    $stmt = $conexao->prepare("INSERT INTO inscritos (
        nome, cpf, data_nascimento, sexo, rg, orgao_expedidor, estado_civil,
        nome_mae, nome_pai, celular, email, cep, logradouro, numero_endereco,
        bairro, complemento, cidade, estado, curso, turno
    ) VALUES (
        :nome, :cpf, :data_nasc, :sexo, :rg, :rg_expedidor, :estado_civil,
        :nome_mae, :nome_pai, :celular, :email, :cep, :logradouro, :numero_end,
        :bairro, :complemento, :cidade, :estado, :curso, :turno
    )");

    $stmt->execute([
        ':nome' => $nome,
        ':cpf' => $cpf,
        ':data_nasc' => $data_nasc,
        ':sexo' => $sexo,
        ':rg' => $rg,
        ':rg_expedidor' => $rg_expedidor,
        ':estado_civil' => $estado_civil,
        ':nome_mae' => $nome_mae,
        ':nome_pai' => $nome_pai,
        ':celular' => $celular,
        ':email' => $email,
        ':cep' => $cep,
        ':logradouro' => $logradouro,
        ':numero_end' => $numero_end,
        ':bairro' => $bairro,
        ':complemento' => $complemento,
        ':cidade' => $cidade,
        ':estado' => $estado,
        ':curso' => $curso,
        ':turno' => $turno
    ]);

    echo json_encode(['status' => 'ok']);
} catch (PDOException $e) {
    // Verifica se é erro de duplicidade de CPF
    if ($e->getCode() === '23000') {
        echo json_encode(['status' => 'erro', 'mensagem' => 'CPF já cadastrado.']);
    } else {
        echo json_encode(['status' => 'erro', 'mensagem' => 'Erro ao salvar os dados: ' . $e->getMessage()]);
    }
}
?>
