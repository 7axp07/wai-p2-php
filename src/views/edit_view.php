<!DOCTYPE html>
<html>
<head>
    <title>Add/Edit</title>
    <link rel="stylesheet" href="static/css/styles.css"/>
</head>
<body>

<form method="post" enctype="multipart/form-data">
    <label>
        <span>Title:</span>
        <input type="text" name="title" value="<?= $image['title'] ?>" />
    </label>
    <label>
        <span>Author:</span>
        <input type="text" name="author" value="<?= $image['author'] ?>" />
    </label>
    <label>
        <span>Image:</span>
        <input type="file" name="file" value="<?= $image['file'] ?>" required/>
    </label>


    <input type="hidden" name="id" value="<?= $image['_id'] ?>">

    <div>
        <a href="images" class="cancel">Cancel</a>
        <input type="submit" value="Save"/>
    </div>
</form>



</body>
</html>
