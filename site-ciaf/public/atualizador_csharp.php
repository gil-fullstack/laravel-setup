<?php
$link = mysqli_connect('localhost', 'tvsistem_fabio', 'To@kDU(TpE#F', 'tvsistem_ciafcsharp');

if (isset($_POST["enviar"])) {
    set_time_limit(0);
    
    $senha = $_POST["senha"];
    
    if (!empty($senha)) {
        if ($senha == "FEa7jQGQ") {
            $query = mysqli_query($link, "SELECT nome FROM bancos");

            mysqli_close($link);

            while ($row = mysqli_fetch_assoc($query)) {
                $nome_bd = $row["nome"];

                @$link = mysqli_connect('localhost', 'tvsistem_fabio', 'To@kDU(TpE#F', $nome_bd);

                // Altere daqui...
                mysqli_query($link, "");
                // ... até aqui!
                // Se necessário, adicione mais queries ;)

                mysqli_close($link);
                
                echo $nome_bd . " finalizado.<br>";
                
                $atualizados .= ($nome_bd . "<br>");
            }
        } else {
            echo "Senha não confere!";
        }
    } else {
        echo "Campo senha está vazio!";
    }
}
?>
<!doctype html>
<html>
    <head>   
        <title>Atualizador de BD C#</title>

        <!-- Basic -->
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="Tesche & Vasconcelos">
        <meta name="robots" content="noindex, nofollow, nosnippet, noodp, noarchive, noimageindex">
        <meta name="googlebot" content="noindex, nofollow, nosnippet, noodp, noarchive, noimageindex">
        
        <link rel="shortcut icon" href="assets/images/favicon2.png" type="image/x-icon">
    </head>
    <body>
        <form action="" method="post">
            <input type="password" name="senha" placeholder="Senha" tabindex="2" required autofocus minlength="8" maxlength="8">
            <input type="submit" name="enviar" value="Atualizar" tabindex="3">
        </form>
    </body>
</html>