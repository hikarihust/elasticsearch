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

$id = $_POST['id'] ? $_POST['id'] : "";
$title = $_POST['title'] ? $_POST['title'] : "";
$content = $_POST['content'] ? $_POST['content'] : "";
$keywords = $_POST['keywords'] ? $_POST['keywords'] : "";
$msg = "";
if ($title && $content && $keywords && $id) {

    $params = [
        'index' => 'article',
        'type'  => 'article_type',
        'id'    => $id,

        'body'  => [
            'title' => $title,
            'content' => $content,
            'keywords' => explode(',', $keywords)
        ]
    ];

    $client->index($params);

    $msg = 'Đã tạo, cập nhật ID = ' . $id;
    $id = $title = $content = $keywords = "";
}
?>

<div class="card m-4">
    <div class="card-header display-4 text-danger">Tạo / cập nhật Document</div>
    <div class="card-body">

        <form method="post" class="form">

            <div class="form-group">
                <label>ID</label>
                <input name="id" value="<?php echo $id ?>" class="form-control">
            </div>

            <div class="form-group">
                <label>Title</label>
                <input name="title" value="<?php echo $title ?>" class="form-control">
            </div>

            <div class="form-group">
                <label>Content</label> <br>
                <textarea name="content" value="<?php echo $content ?>" class="form-control"></textarea>
            </div>

            <div class="form-group">
                <label>Keywords</label>
                <input name="keywords" value="<?php echo $keywords ?>" class="form-control">
            </div>
            <input type="submit" value="Update" class="btn btn-danger">
        </form>
        <?php echo $msg; ?>
    </div>
</div>