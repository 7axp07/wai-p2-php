<div id="gallery">

    <h2>Gallery</h2>

    <table>

        <tbody>
        <?php if (!empty($cart)): ?>
            <?php foreach ($cart as $id => $product): ?>
                <tr>
                    <td>
                        <a href="view?id=<?= $id ?>"><?= $product['name'] ?></a>
                    </td>
                    <td><?= $product['amount'] ?></td>
                </tr>
            <?php endforeach ?>
        <?php else: ?>
            <tr>
                <td colspan="2">Brak produktów w koszyku</td>
            </tr>
        <?php endif ?>
        </tbody>

    </table>
</div>
