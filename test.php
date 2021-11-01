    <?php

    // Class Test
    // {

    //     private $test1 = "テスト1";
    //     private $testtest = "テスト×２";
    //     // public $test = "テスト";
    //     // public $testtest = "テスト×２";

    //     public function __construct(){
    //         $this->test = "いいいいい";
    //         echo $this->test;
    //     }

    //     public function test() {
    //         echo $this->test1;
    //         echo $this->testtest;
    //     }
    // }
    ini_set('display_errors', "On");
    session_start();
    require_once('Database/db.php');
    require_once('errors/PostException.php');
    require_once('security/xss.php');

        $email = "";
        $password = "パスワード";
        $csrf_token = "トークン";
        // var_dump($email);
        // var_dump($password);
        // var_dump($csrf_token);

    $input_errors = [];
    try {
        //メールアドレス空バリデーション
        if (empty($email)) {
            $input_errors['input_email_error'] = "メールアドレスを入力してください";
            // echo "成功";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $input_errors['input_email_error'] = "正しい形式で入力してください";
            // echo "成功2";
        }
        //パスワード空バリデーション
        if (empty($password)) {
            $input_errors['input_password_error']= "パスワードを入力してください";
            // echo "成功3";
        }
        //半角英数8-100位下
        if (!preg_match('/\A[a-z\d]{8,100}+\z/i', "$password")) {
            $input_errors['input_password_error']= "パスワードは半角英数8-100文字で入力してください";
        }

        if (count($input_errors) > 0) {
            throw new PostException($input_errors);
        }

    } catch (PostException $e) {
        $input_errors = $e->getArrayMessage();
        if(!empty($input_errors->input_email_error)) $_SESSION['input_email_error'] = $input_errors->input_email_error;
        if(!empty($input_errors->input_password_error)) $_SESSION['input_password_error'] = $input_errors->input_password_error;
        if(!empty($input_errors->csrf_token_error)) $_SESSION['csrf_token_error'] = $input_errors->csrf_token_error;
        // header('Location: login.php');
        // exit;
    }

    if (isset($_SESSION['input_email_error'])) {
        echo $_SESSION['input_email_error'];
        unset($_SESSION['input_email_error']);
    }
    echo "<br>";
    if (isset($_SESSION['input_password_error'])) {
    echo $_SESSION['input_password_error'];
    unset($_SESSION['input_password_error']);
    }
    echo "<br>";
