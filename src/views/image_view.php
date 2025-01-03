<!DOCTYPE html>
<html>
<head>
    <title>Image</title>
    <link rel="stylesheet" href="static/css/styles.css"/>
</head>
<body>

<h1><?= $image['title'] ?></h1>

<img src="upload/wmarked/w<?= $image['_id']?>.<?= $image['ext']?>" alt="<?= $image['title'] ?>"/>

<p>Author: <?= $image['author'] ?></p>


<a href="images" class="cancel">&laquo; Back</a>


</body>
</html>
