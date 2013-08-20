<?php
/**
 * Anticipate:
 *   - models\entity\Entity\News $news
 *   - string $title
 *   - string $postUrl
 *   - string $redirectUrl
 *   - array $errors
 */
?>


<div style="padding-top: 111px;" >
    <ul>
        <?php foreach ($errors as $error): ?>
            <li><?php echo $error ?></li>
        <?php endforeach ?>
    </ul>
    
    <form action="<?php echo $postUrl ?>" method="post" >
        <input type="hidden" name="id" value="<?php echo $news->id ?>" />
        <input type="hidden" name="redirecturl" value="<?php echo $redirectUrl ?>" />
        <table>
            <caption><?php echo $title ?></caption>
            <tbody>
                <tr>
                    <td>
                        <label>
                            新聞分類：
                            <select name="category_id" required >
                                <option value="">請選擇新聞分類：</option>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?php echo $category->getId() ?>" <?php echo ($news->category and $news->category->getId() == $category->getId()) ? 'selected' : '' ?> ><?php echo $category->getName() ?></option>
                                <?php endforeach ?>
                            </select>
                        </label>
                    </td>
                </tr>
                <tr>
                    <td><label>標題：<input type="text" name="title" value="<?php echo $news->title ?>" /></label></td>
                </tr>
                <tr>
                    <td><label>內文：<textarea name="content"><?php echo $news->content ?></textarea></label></td>
                </tr>
                <tr>
                    <td><input type="submit" value="<?php echo $title ?>" /></td>
                </tr>
            </tbody>
        </table>
    </form>
    
    <a href="<?php echo $redirectUrl ?>">返回</a>
</div>