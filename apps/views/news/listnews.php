<?php
/**
 * Anticipate:
 *   - array $news
 *   - string $postEditUrl
 *   - string $postDeleteUrl
 *   - string $currentUrl
 *   - Pagination $pagination
 */
?>
<div style="padding-top: 111px;">
    <ul>
        <li><a href="<?php echo $addUrl ?>">新增新聞</a></li>
    </ul>

<?php if ($news): ?>
    <table border="1">
        <caption>新聞</caption>
        <thead>
            <tr>
                <th>分類</th>
                <th>標題</th>
                <th>建立時間</th>
                <th>建立者IP</th>
                <th>操作</th>
            </tr>
        <thead>
        <tbody>
            <?php foreach ($news as $aNews): ?>
                <tr>
                    <td><?php echo $aNews->category ? $aNews->category->getName() : '' ?></td>
                    <td><?php echo $aNews->title ?></td>
                    <td><?php echo $aNews->createAt->format('Y-m-d H:G:s') ?></td>
                    <td><?php echo $aNews->createIP ?></td>
                    <td>
                        <form action="<?php echo $postEditUrl?>" method="post">
                            <input type="hidden" name="id" value="<?php echo $aNews->id ?>" />
                            <input type="hidden" name="postfromurl" value="<?php echo $currentUrl ?>" />
                            <input type="submit" value="編輯" />
                        </form>
                        <form action="<?php echo $postDeleteUrl?>" method="post">
                            <input type="hidden" name="id" value="<?php echo $aNews->id ?>" />
                            <input type="hidden" name="postfromurl" value="<?php echo $currentUrl ?>" />
                            <input type="submit" value="刪除" />
                        </form>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
        <tfoot>
            <?php echo $pagination->create_links() ?>
        </tfoot>
    </table>
<?php else: ?>
    <p>沒有任何新聞可以顯示</p>
<?php endif ?>
</div>