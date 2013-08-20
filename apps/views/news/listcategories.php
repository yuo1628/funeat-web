<?php
/**
 * 顯示分類列表
 *
 * Anticipate:
 *  - array $categories
 *  - Pagination $pagination
 *  - string $title
 *  - string $postEditUrl
 *  - string $postDeleteUrl
 */
?>

<div style="padding-top: 111px">

    <ul>
        <li><a href="<?php echo $addUrl ?>">新增分類</a></li>
    </ul>

    <?php if (!$categories): ?>
        <p>目前無分類資料可以顯示</p>
    <?php else: ?>
        <table border="1">
            <caption><?php echo $title ?></caption>
            <thead>
                <tr>
                    <th>名稱</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tfoot>
                <?php echo $pagination->create_links() ?>
            </tfoot>
            <tbody>
                <?php foreach($categories as $category): ?>
                    <tr>
                        <td><?php echo $category->getName() ?></td>
                        <td>
                            <form action="<?php echo $postEditUrl ?>" method="post">
                                <input type="hidden" name="id" value="<?php echo $category->getId() ?>" />
                                <input type="submit" value="編輯" />
                            </form>
                            <form action="<?php echo $postDeleteUrl ?>" method="post">
                                <input type="hidden" name="id" value="<?php echo $category->getId() ?>" />
                                <input type="submit" value="刪除" />
                            </form>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    <?php endif ?>
</div>