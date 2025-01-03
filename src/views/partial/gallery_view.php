
<div id="gallery">

    <h2>Gallery</h2>

    <div class=gallery style="display: grid; gap: 10px;">
    <?php if (count($images)): ?>
            <?php foreach ($images as $image): ?>
                <div class="image">
                    <a href="view?id=<?= $image['_id'] ?>"><img src="upload/thumb/t<?= $image['_id']?>.<?= $image['ext']?>" alt="<?= $image['title'] ?>"/></a>
                    <div class="author"><?= $image['author'] ?></div>
                </div>
            <?php endforeach ?>
        <?php else: ?>
            <div class="no-images">No Images in Gallery</div>
        <?php endif ?>

    
</div>

