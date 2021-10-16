<?php
?>
<body>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="../Css/auth.css">
    <title>login</title>
    <div class="container">
        <h1 class="title">
            LOGIN
        </h1>
        <form action="login_complete.php" method="post">
            <!-- フォーム入力のエラーメッセージがあれば表示、db検索エラーメッセージがあれば表示 -->
            <div class="item">
                <label for="exampleFormControlInput1" class="form-label"><label>
                <!-- value値に確認画面の値を設定 -->
                <input type="text" name="email" placeholder="EMAIL" required value="">
            </div>
    <!-- エラーメッセージ -->
            <div class="item">
                <label for="exampleFormControlInput1" class="form-label"><label>
                <input type="password" name="password" placeholder="PASSWORD" required>
            </div>
            <div class="item">
                <input type="hidden" name="csrf_token" value="">
            </div>
            <div class="button">
                <input class="btn btn-primary" type="submit" value="LOGIN">
            </div>
        </form>
        <p>まだ登録がお済みでない方<a href="register.php">こちら</a></p>
    </div>
</body>
