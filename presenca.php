<?php
require_once "config.php";
date_default_timezone_set('America/Sao_Paulo');
 
$nome = $matricula = $dia = $turno = $curso = "";
$nome_err = $matricula_err =  $curso_err = "";

$turnoAux = date("H");

if($turnoAux < 12){
    $turno = "Manhã";
}else if($turnoAux >= 13 && $turnoAux < 18){
    $turno = "Tarde";
}else{
    $turno = "Noite";
}

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
    
    $input_curso = trim($_POST["curso"]);
    $curso = $input_curso;

    if(empty($nome_err) && empty($matricula_err)){
        $sql = "INSERT INTO usuarios (nome, matricula, turno, curso) VALUES (?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "siss", $param_nome, $param_matricula, $param_turno, $param_curso);
            
           
            $param_nome = $nome;
            $param_matricula = $matricula;
            $param_turno = $turno;
            $param_curso = $curso;
          
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
                            <label>Matrícula (opcional)</label>
                            <input type="number" name="matricula" class="form-control <?php echo (!empty($matricula_err)) ? 'is-invalid' : ''; ?>"><?php echo $matricula; ?></input>
                            <span class="invalid-feedback"><?php echo $matricula_err;?></span>
                        </div>
                        
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="pedagogia" id="pedagogia">
                            <label class="form-check-label" for="flexRadioDefault1">
                                Faço Pedagogia
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="educacao" id="educacao">
                            <label class="form-check-label" for="flexRadioDefault1">
                                Faço Pós-Graduação em Educação
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="outro" id="outro">
                            <label class="form-check-label" for="flexRadioDefault1">
                                Faço outro curso:
                            </label>
                        </div>
                        <div class="form-group">
                            
                            <input type="text" name="curso" placeholder="Qual o curso?" class="form-control"></input>
                            <span class="invalid-feedback"><?php echo $curso_err;?></span>
                        </div>
              
                        <div class="mt-3">
                            <input type="submit" class="btn btn-primary " value="Enviar">
                        <a href="index.php" class="btn btn-secondary ml-2">Ver Lista</a>
                        </div>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>