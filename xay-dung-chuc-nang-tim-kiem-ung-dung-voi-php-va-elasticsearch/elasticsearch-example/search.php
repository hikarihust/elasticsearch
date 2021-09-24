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

//Kiem tra xem Index đe ton tai khong
$exist = $client->indices()->exists(['index' => 'article']);

if(!$exist) {
    echo "Index - article khong ton tai";
    die();
}

$search = $_POST['search'] ?? null;

if ($search != null) {
    // Tham số tìm kiếm
    $params = [
        'index' => 'article',
        'type' => 'article_type',

        'body' => [
            'query' => [
                'bool' => [
                    'should' => [
                        ['match' => ['title' => $search]],
                        ['match' => ['content' => $search]],
                        // ['match' => ['keywords' => $search]]
                    ]
                ]
            ],
            'highlight' => [
                'pre_tags' => ["<strong class='text-danger'>"],
                'post_tags' => ["</strong>"],

               'fields' => [
                           'title' =>  new stdClass(),
                           'content' => new stdClass()
                   ]
           ]
        ]
    ];

    $results = $client->search($params);
    $rs = array();

    if ($results['hits']['total'] >= 1) {
        $total = $results['hits']['total']['value'];
        $rs = $results['hits']['hits'];
    }
}
?>

<div class="card m-4">
    <div class="card-header display-4 text-danger">Tìm kiếm</div>
    <div class="card-body">

        <form method="post" class="form-inline">
            <div class="form-group">
                <input name="search" value="<?=$search?>" class="form-control">
                <input type="submit" value="Tìm kiếm" class="form-control btn btn-danger ml-2">
            </div>
        </form>

        <hr>

        <?php if ($total > 0):?>
            <h3>Kết quả tìm kiếm: <?php echo $search?></h3>
            <hr>
            <?php foreach ($rs as $r):?>

                <?php
                    $title    = $r['highlight']['title'][0] ??  $r['_source']['title'];
                    $content  = $r['highlight']['content'][0]  ?? $r['_source']['content'];
                ?>

                <p><strong> <?php echo $title?> </strong>  <br>
                    <?php echo $content ?>
                </p>
                <hr>

            <?php endforeach?>
        <?php endif;?>

    </div>
</div>