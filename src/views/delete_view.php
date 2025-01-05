<!DOCTYPE html>
<html>
<head>
    <title>Image Deletion</title>
    <link rel="stylesheet" href="static/css/styles.css"/>
</head>
<body>

<form method="post">
    Do you want to delete image: <?= $image['title'] ?>?

    <input type="hidden" name="id" value="<?= $image['_id'] ?>">

    <div>
        <a href="table" class="cancel">Cancel</a>
        <input type="submit" value="Proceed"/>
    </div>
</form>

</body>
</html>
