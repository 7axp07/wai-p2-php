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

<button><a href="/">Back to Gallery</a></button>
</body>
</html>
