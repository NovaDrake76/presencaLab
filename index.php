<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Lista de Chamada</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
        table tr td:last-child{
            width: 120px;
        }
    </style>
    <script>
        $(document).ready(function(){
            $('[dia-toggle="tooltip"]').tooltip();   
        });
    </script>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="mt-5 mb-3 clearfix">
                        <h2 class="pull-left">Lista de Chamada</h2>
                        <a href="presenca.php" class="btn btn-success pull-right"><i class="fa fa-plus"></i>Ir para Chamada</a>
                    </div>
                    <?php
                    require_once "config.php";
                    
                    $sql = "SELECT * FROM usuarios";
                    if($result = mysqli_query($link, $sql)){
                        if(mysqli_num_rows($result) > 0){

                            echo '<table class="table table-bordered table-striped">';
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>Nome</th>";
                                        echo "<th>Matrícula</th>";
                                        echo "<th>Turno</th>";
                                        echo "<th>Data</th>";
                                        echo "<th>Curso</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                        echo "<td>" . $row['nome'] . "</td>";
                                        echo "<td>" . $row['matricula'] . "</td>";
                                        echo "<td>" . $row['turno'] . "</td>";
                                        echo "<td>" . $row['dia'] . "</td>";
                                        echo "<td>" . $row['curso'] . "</td>";

                                    echo "</tr>";
                                }
                                echo "</tbody>";                            
                            echo "</table>";
                            mysqli_free_result($result);
                        } else{
                            echo '<div class="alert alert-danger"><em>Sem Registros</em></div>';
                        }
                    } else{
                        echo "Algo deu errado, tente novamente.";
                    }
                     mysqli_close($link);
                    ?>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>