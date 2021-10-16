        <?php if ($now == 1 ) :?>
            <a href="?page_id=<?php echo ($now + 1); ?>">次へ<?php echo ($now + 1); ?></a>
        <?php endif; ?>
        <?php if ($now > 1) :?>
            <a href="?page_id=<?php echo ($now - 1); ?>">前へ<?php echo ($now - 1); ?></a>
        <?php endif; ?>
        <?php if ($now < $max_page) : ?>
            <a href="?page=<?php echo ($now + 1); ?>">次へ</a>
        <?php endif; ?>
        <?php if ($now < $max_page) : ?>
            <a href="?page=<?php echo $max_page; ?>">最後</a>
        <?php endif; ?>

            <!-- <div class="page_link">
        <?php for ($now_link=1; $page_link <= $max_page; $page_link++) : ?>
            <?php if ($page_link == $now) : ?>
                <?php echo $now; ?>ページ
            <?php else :?>
                    <a href="?page_id=<?php echo $page_link; ?>"><?php echo $page_link; ?>ページ</a>
            <?php endif ?>
        <?php endfor; ?>
    </div> -->

