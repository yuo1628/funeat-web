<?php
/**
 * 編輯分類
 *
 * Anticipate:
 *  - Category $category
 *  - string $title
 *  - string $postUrl
 *  - array $errors
 */
?>

<div style="padding-top: 111px" >
    <ul>
        <?php foreach($errors as $error): ?>
            <li><?php echo $error ?></li>
        <?php endforeach ?>
    </ul>

    <form action="<?php echo $postUrl ?>" method="post" >
        <input type="hidden" name="id" value="<?php echo $category->getId() ?>" />
        <table>
            <caption><?php echo $title ?></caption>
            <tr>
                <td><label>名稱<input type="text" name="name" value="<?php echo $category->getName() ?>" /></label></td>
            </tr>
            <tr>
                <td><input type="submit" value="<?php echo $title ?>" /></td>
            </tr>
        </table>
    </form>
</div>