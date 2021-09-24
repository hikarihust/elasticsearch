<?php
    $page = $_GET['page'] ?? '';

    $menuitems = [
        'manageindex' => 'Quan ly Index',
        'document' => 'Cap nhat Document',
        'search' => 'Tim kiem'
    ];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
              integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Thuc hanh Elasticsearch voi PHP</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-danger">

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">

                <li class="nav-item">
                    <a class="nav-link" href="/">Home</a>
                </li>

                <?php foreach ($menuitems as $url => $label):?>

                <?php
                    $activeclass='';
                    if ($page == $url)
                        $activeclass = 'active';
                ?>

                <li class="nav-item">
                    <a class="nav-link <?php echo $activeclass?>" href="/?page=<?php echo $url?>"><?php echo $label?></a>
                </li>
                <?php endforeach;?>
            </ul>
        </div>
    </nav>
    
    <?php if ($page == ''):?>
        <p class="display-4 alert alert-danger">Thuc hanh Elasticsearch - quang vu</p>
    <?php else:?>
        <?php include $page.'.php'; ?>
    <?php endif;?>

</body>
</html>