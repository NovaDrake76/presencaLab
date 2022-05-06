<?php
require_once "config.php";
 
$nome = $matricula = $dia = "";
$nome_err = $matricula_err = $dia_err = "";
 
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $input_nome = trim($_POST["nome"]);
    if(empty($input_nome)){
        $nome_err = "Digite um nome válido.";
    } elseif(!filter_var($input_nome, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $nome_err = "Digite um nome válido.";
    } else{
        $nome = $input_nome;
    }
    
    $input_matricula = trim($_POST["matricula"]);

    $matricula = $input_matricula;

    $param_dia = date("Y-m-d");
    
    if(empty($nome_err) && empty($matricula_err) && empty($dia_err)){
        $sql = "INSERT INTO usuarios (nome, matricula, dia) VALUES (?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "ssd", $param_nome, $param_matricula, $param_dia);
            
           
            $param_nome = $nome;
            $param_matricula = $matricula;
            $param_dia = $dia;

           
            if(mysqli_stmt_execute($stmt)){
   
                header("location: presenca.php");
                exit();
            } else{
                echo "Algo deu errado, tente novamente.";
            }
        }
         
       
        mysqli_stmt_close($stmt);
    }
    
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Deixe sua presença</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Deixe sua Presença</h2>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>Nome</label>
                            <input type="text" name="nome" class="form-control <?php echo (!empty($nome_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $nome; ?>">
                            <span class="invalid-feedback"><?php echo $nome_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Matricula</label>
                            <input type="number" name="matricula" class="form-control <?php echo (!empty($matricula_err)) ? 'is-invalid' : ''; ?>"><?php echo $matricula; ?></input>
                            <span class="invalid-feedback"><?php echo $matricula_err;?></span>
                        </div>
              
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Ver Lista</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>