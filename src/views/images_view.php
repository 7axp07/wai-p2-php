<!DOCTYPE html>
<html>
<head>
    <title>Gallery</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="static/css/styles.css"/>
</head>
<body>
<header><?php dispatch($routing, '/logincreate') ?> | <button><a href="/table">Table View</a></button></header>



<div id="gallery">

    <h2>Gallery | <button><a href="/edit">Add New Image</a></button> </h2>
    <div class=galleryDiv>
    <?php if (count($images)): ?>
            <?php foreach ($images as $image): ?>
                <div class="image">
                    <a href="view?id=<?= $image['_id'] ?>"><img src="upload/thumb/t<?= $image['_id']?>.<?= $image['ext']?>" alt="<?= $image['title'] ?>"/></a>
                    <div class="info"><strong>"<?= $image['title'] ?>"</strong> by <?= $image['author'] ?> <input type="checkbox" id="<?= $image['_id']?>" name="fav" value="fav"></div>
                    
                </div>
            <?php endforeach ?>
        <?php else: ?>
            <div style="padding: 0px">No Images in Gallery</div>
        <?php endif ?>

        
    
</div>

<div class="pagination" style="position: absolute; bottom: 20px; ">
        <?php if ($currentPage > 1): ?>
            <a href="?page=<?= $currentPage - 1 ?>"> < </a>
        <?php endif ?>

        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="?page=<?= $i ?>" <?= $i == $currentPage ? 'class="active"' : '' ?>><?= $i ?></a>
        <?php endfor ?>

        <?php if ($currentPage < $totalPages): ?>
            <a href="?page=<?= $currentPage + 1 ?>"> > </a>
        <?php endif ?>
    </div>

</body>
</html>
