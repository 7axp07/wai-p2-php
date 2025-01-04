<!DOCTYPE html>
<html>
<head>
    <title>Gallery</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="static/css/styles.css"/>
</head>
<body>
<header><?php dispatch($routing, '/logincreate') ?></header>

<table>
    <thead>
    <tr>
        <th>Image</th>
        <th>Author</th>
        <th>Actions</th>
    </tr>
    </thead>

    <tbody>
    <?php if (count($images)): ?>
        <?php foreach ($images as $image): ?>
            <tr>
                <td>
                <a href="view?id=<?= $image['_id'] ?>"><img src="upload/thumb/t<?= $image['_id']?>.<?= $image['ext']?>" alt="<?= $image['title'] ?>"/></a>
                </td>
                <td><?= $image['author'] ?></td>
                <td>
                    <a href="edit?id=<?= $image['_id'] ?>">Edit</a> |
                    <a href="delete?id=<?= $image['_id'] ?>">Delete</a>
                </td>
            </tr>
        <?php endforeach ?>
    <?php else: ?>
        <tr>
            <td colspan="3">No Images in Gallery</td>
        </tr>
    <?php endif ?>
    </tbody>

    <tfoot>
    <tr>
        <td colspan="2">Images in gallery: <?= count($images) ?></td>
        <td>
            <a href="edit">Add New Image</a>
        </td>
    </tr>
    </tfoot>
</table>

<div id="gallery">

    <h2>Gallery</h2>

    <div class=galleryDiv>
    <?php if (count($images)): ?>
            <?php foreach ($images as $image): ?>
                <div class="image">
                    <a href="view?id=<?= $image['_id'] ?>"><img src="upload/thumb/t<?= $image['_id']?>.<?= $image['ext']?>" alt="<?= $image['title'] ?>"/></a>
                    <div class="info"><strong>"<?= $image['title'] ?>"</strong> by <?= $image['author'] ?></div>
                </div>
            <?php endforeach ?>
        <?php else: ?>
            <div class="no-images">No Images in Gallery</div>
        <?php endif ?>

    
</div>


<div class="pagination">
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
