<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Relatório de Inscritos</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f8fafc;
      margin: 0;
      padding: 40px;
      color: #1e293b;
    }

    h1 {
      text-align: center;
      color: #0b671a;
      font-size: 2.5rem;
      margin-bottom: 30px;
    }

    .tabela-relatorio {
      width: 100%;
      border-collapse: collapse;
      background-color: white;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
      border-radius: 10px;
      overflow: hidden;
    }

    .tabela-relatorio th,
    .tabela-relatorio td {
      padding: 14px 18px;
      border-bottom: 1px solid #e2e8f0;
      text-align: left;
    }

    .tabela-relatorio th {
      background-color: #0b671a;
      color: white;
      text-transform: uppercase;
      font-size: 14px;
      letter-spacing: 1px;
    }

    .tabela-relatorio tr:hover {
      background-color: #f1f5f9;
    }

    .mensagem {
      text-align: center;
      margin-top: 40px;
      font-size: 1.1rem;
    }

    .voltar {
      text-align: center;
      margin-top: 40px;
    }

    .voltar a {
      text-decoration: none;
      background-color: #0b671a;
      color: white;
      padding: 10px 20px;
      border-radius: 6px;
      font-weight: bold;
      transition: background 0.2s;
    }

    .voltar a:hover {
      background-color: #0a5417;
    }
  </style>
</head>
<body>

  <h1>Relatório de Inscritos</h1>

  <?php
    // 🔧 Configure suas credenciais:
    $host = 'dpg-d1ljqpur433s73dqhng0-a.oregon-postgres.render.com';
    $port = '5432';
    $dbname = 'site_ifms_eng_soft';
    $user = 'adm_site';
    $password = 'eZifGf4YiHVOqrA9zLuMJcfwZmK2ScJB';

    function mascararCPF($cpf) {
      $cpf = $cpf ?? '';  // se $cpf for null, vira string vazia
      $numeros = preg_replace('/\D/', '', $cpf);
      
      if (strlen($numeros) !== 11) return $cpf;
      
      return substr($numeros, 0, 3) . '.***.***-' . substr($numeros, -2);
    }
    

    try {
        // PostgreSQL → use pgsql | MySQL → mysql
        $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->query("SELECT * FROM inscritos ORDER BY nome, curso, turno");

        if ($stmt->rowCount() > 0) {
            echo "<table class='tabela-relatorio'>";
            echo "<thead>
                    <tr>
                      <th>Nome</th>
                      <th>CPF</th>
                      <th>Data de Nascimento</th>
                      <th>Sexo</th>
                      <th>Curso</th>
                      <th>Turno</th>
                    </tr>
                  </thead><tbody>";

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>
                        <td>{$row['nome']}</td>
                        <td>" . mascararCPF($row['cpf']) . "</td>
                        <td>" . date('d/m/Y', strtotime($row['data_nascimento'])) . "</td>
                        <td>{$row['sexo']}</td>
                        <td>{$row['curso']}</td>
                        <td>{$row['turno']}</td>
                      </tr>";
            }

            echo "</tbody></table>";
        } else {
            echo "<p class='mensagem'>Nenhum inscrito encontrado.</p>";
        }

    } catch (PDOException $e) {
        echo "<p class='mensagem' style='color: red;'>Erro ao conectar ao banco: " . $e->getMessage() . "</p>";
    }
  ?>

  <div class="voltar">
    <a href="index.html">Voltar</a>
  </div>

</body>
</html>
