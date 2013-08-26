<?php
include_once 'config.php';
include_once 'ANNMS/ANNClient.php';

$erro = false;
$e = null;

$client = new ANNClient(SERVER, PORT, USERNAME, PASSWORD);

try {
    $client->connect();
} catch (\annms\AuthenticationExceptionException $e) {
    echo 'Invalid username or password';
    exit;
} catch (\Thrift\Exception\TException $e) {
    echo 'Server offline';
    exit;
}

try {
    if (isset($_POST['query_input'])) {
        $client->query($_POST['query_input']);
    }
} catch (annms\InvalidRequestException $e) {
    $erro = true;
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="Welsiton Ferreira (WFCreations)">
        <link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" href="css/codemirror.css">
        <link rel="stylesheet" href="css/style.css">
        <title>Artificial Neural Network Client</title>
    </head>
    <body>
        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <a class="navbar-brand" href="#">Artificial Neural Network Client</a>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="content">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title" a>Rodar consulta(s) ANNSQL no servidor "<?php echo SERVER . ":" . PORT ?>"</h3>
                    </div>
                    <div class="panel-body">
                        <form class="lead" method="POST">
                            <div class="form-group">
                                <div class="panel panel-default">
                                    <textarea id="code" class="form-control sh_annsql" rows="6" name="query_input"></textarea>
                                </div>

                            </div>
                            <button type="submit" class="btn btn-success pull-right">Executar</button>
                        </form>
                    </div>
                </div>
                <div class="panel<?php echo ($erro ? ' panel-danger' : ' panel-default'); ?>">
                    <div class="panel-heading">
                        <h3 class="panel-title">Resultado</h3>
                    </div>
                    <div class="panel-body">
                        <?php if ($erro) : ?>
                            <?php echo $e->code . ": " . $e->message; ?>
                        <?php else : ?>

                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <script src="js/jquery.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/application.js"></script>
        <script src="js/codemirror.js"></script>
        <script src="js/language/sql.js"></script>
    </body>
</html>