<?php
use Elasticsearch\ClientBuilder;

require "vendor/autoload.php";

$hosts = [
    [
        'host' => '3.138.195.50',
        'port' => '9200',
        'scheme' => 'http',
    ]
];

$client = \Elasticsearch\ClientBuilder::create()
    ->setHosts($hosts)
    ->build();

$indices = $client->cat()->indices();

$act = $_GET['act'] ?? null;
$mgs = 'Chon lenh tao hoac xoa';
if ($act == 'create') {
    try {
        //Tao Index: article
        $params = [
            'index' => 'article'
        ];
        $exist = $client->indices()->exists($params);
        if ($exist) {
            $mgs = "Index - article da ton tai - khong can tao";
        }
        else {
            $client->indices()->create($params);
            $mgs = "Index - articl moi duoc tao";
        }
    }
    catch (Exception $e) {
        //Loi tao Index
        $res = json_decode($e->getMessage());
        echo $res->error->reason;
    }
}
else if ($act == 'delete') {
    // Xoa index:article
    $params = [
        'index' => 'article'
    ];

    $exist = $client->indices()->exists($params);
    if ($exist) {
        $client->indices()->delete($params);
        $mgs = "da xoa index - article";
    }
    else {
        $mgs = "Index - articl khong ton tai";
    }
}

//Kiem tra xem Index đe ton tai khong
$exist = $client->indices()->exists(['index' => 'article']);
?>

<div class="card m-4">
    <div class="card-header display-4 text-danger">Quan ly Index</div>
    <div class="card-body">
        <?php if (!$exist):?>
            <a href="http://3.138.195.50:8888/?page=manageindex&act=create" class="btn btn-primary">Tao index <strong>article</strong></a>
        <?php else:?>
            <a href="http://3.138.195.50:8888/?page=manageindex&act=delete" class="btn btn-danger">Xoa index <strong>article</strong></a>
        <?php endif;?>
        <div class="alert alert-danger mt-4"><?php echo $mgs?></div>
    </div>
</div>