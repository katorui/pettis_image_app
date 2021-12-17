<?php if ($now != 1) :?>
    <a href="?page_id=<?php echo xss($prev);?>">前へ</a>
<?php endif ;?>
<span><?php echo $now; ?></span>
<?php if ($now < $total_page) :?>
    <a href="?page_id=<?php echo xss($next); ?>">次へ</a>
<?php endif ;?>
